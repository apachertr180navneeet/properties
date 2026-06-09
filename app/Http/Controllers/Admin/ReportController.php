<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Property;
use App\Models\PropertyShowing;
use App\Models\SalesPerson;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $showings = $this->filteredShowings($request)
                ->orderBy('show_date', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();
            $customers = Customer::where('status', 'active')->orderBy('name')->get();
            $properties = Property::where('status', 'available')->orderBy('title')->get();

            return view('admin.reports.showings', compact('showings', 'salespersons', 'customers', 'properties'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading showings report: ' . $e->getMessage());
        }
    }

    public function getTable(Request $request)
    {
        try {
            $showings = $this->filteredShowings($request)
                ->orderBy('show_date', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            $html = view('admin.reports.partials.table', compact('showings'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $showings = $this->filteredShowings($request)->orderBy('show_date', 'desc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Set Headers
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Property Name');
            $sheet->setCellValue('C1', 'Sales Person');
            $sheet->setCellValue('D1', 'Customer');
            $sheet->setCellValue('E1', 'Show Date');

            // Set Header Styling
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '696CFF'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];
            $sheet->getStyle('A1:E1')->applyFromArray($headerStyle);

            // Set Data
            $row = 2;
            foreach ($showings as $i => $showing) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, optional($showing->property)->title ?? 'N/A');
                $sheet->setCellValue('C' . $row, optional($showing->salesPerson)->name ?? 'N/A');
                $sheet->setCellValue('D' . $row, optional($showing->customer)->name ?? 'N/A');
                $sheet->setCellValue('E' . $row, optional($showing->show_date)->format('d/m/Y') ?? 'N/A');
                
                // Alignments
                $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                
                $row++;
            }

            // Auto-size columns
            foreach (range('A', 'E') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'showings-report-' . date('Y-m-d-His') . '.xlsx';
            $temp = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($temp);

            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    private function filteredShowings(Request $request)
    {
        $query = PropertyShowing::with(['property', 'salesPerson', 'customer']);

        if ($request->filled('sales_person_id')) {
            $query->where('sales_person_id', $request->sales_person_id);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($request->filled('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        return $query;
    }
}
