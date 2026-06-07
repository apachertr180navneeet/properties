<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalesPerson;
use Illuminate\Http\Request;
use Validator;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SalesPersonController extends Controller
{
    /**
     * Display a listing of the salespersons.
     */
    public function index(Request $request)
    {
        try {
            $query = SalesPerson::query()->withCount(['properties', 'customers']);

            // Name filter dropdown
            if ($request->filled('name_filter')) {
                $query->where('name', $request->name_filter);
            }

            // General Search
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $limit = $request->get('limit', 10);
            $salespersons = $query->orderBy('id', 'desc')->paginate($limit)->withQueryString();
            
            // Pluck names for the dropdown
            $names = SalesPerson::orderBy('name')->pluck('name')->unique();

            return view('admin.salesperson.index', compact('salespersons', 'names'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading salespersons: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created salesperson in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'phone' => 'required|string|digits:10|unique:sales_persons,phone',
                'city' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            SalesPerson::create(array_merge(
                $request->only(['name', 'email', 'phone', 'city']),
                ['status' => 'active']
            ));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Salesperson created successfully!']);
            }

            return redirect()->route('admin.salespersons.index')->with('success', 'Salesperson created successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating salesperson: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error creating salesperson: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified salesperson's data (for AJAX/view).
     */
    public function show($id)
    {
        try {
            $salesperson = SalesPerson::with(['properties', 'customers'])->withCount(['properties', 'customers'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $salesperson
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Salesperson not found: ' . $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified salesperson in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $salesperson = SalesPerson::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'phone' => 'required|string|digits:10|unique:sales_persons,phone,' . $id,
                'city' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $salesperson->update($request->only(['name', 'email', 'phone', 'city']));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Salesperson updated successfully!']);
            }

            return redirect()->route('admin.salespersons.index')->with('success', 'Salesperson updated successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating salesperson: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error updating salesperson: ' . $e->getMessage());
        }
    }

    /**
     * Toggle salesperson status via AJAX.
     */
    public function toggleStatus($id)
    {
        try {
            $salesperson = SalesPerson::findOrFail($id);
            $salesperson->status = $salesperson->status === 'active' ? 'inactive' : 'active';
            $salesperson->save();

            return response()->json([
                'success' => true,
                'status' => $salesperson->status,
                'message' => "Status changed to " . ucfirst($salesperson->status)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return only the table HTML for AJAX refresh.
     */
    public function getTable(Request $request)
    {
        try {
            $query = SalesPerson::query()->withCount(['properties', 'customers']);

        if ($request->filled('name_filter')) {
            $query->where('name', $request->name_filter);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $limit = $request->get('limit', 10);
        $salespersons = $query->orderBy('id', 'desc')->paginate($limit)->withQueryString();

        $html = view('admin.salesperson.partials.table', compact('salespersons'))->render();
        return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) { dd($e); }
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = SalesPerson::query()->withCount(['properties', 'customers']);

            if ($request->filled('name_filter')) {
                $query->where('name', $request->name_filter);
            }
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $salespersons = $query->orderBy('id', 'desc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Email');
            $sheet->setCellValue('D1', 'Phone');
            $sheet->setCellValue('E1', 'City');
            $sheet->setCellValue('F1', 'Properties');
            $sheet->setCellValue('G1', 'Customers');
            $sheet->setCellValue('H1', 'Status');

            $row = 2;
            foreach ($salespersons as $i => $sp) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $sp->name);
                $sheet->setCellValue('C' . $row, $sp->email);
                $sheet->setCellValue('D' . $row, $sp->phone);
                $sheet->setCellValue('E' . $row, $sp->city);
                $sheet->setCellValue('F' . $row, $sp->properties_count);
                $sheet->setCellValue('G' . $row, $sp->customers_count);
                $sheet->setCellValue('H' . $row, ucfirst($sp->status));
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'salespersons-' . date('Y-m-d-His') . '.xlsx';
            $temp = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($temp);

            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified salesperson from storage.
     */
    public function destroy(Request $request, $id)
    {
        try {
            $salesperson = SalesPerson::findOrFail($id);
            $salesperson->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Salesperson deleted successfully!']);
            }

            return redirect()->route('admin.salespersons.index')->with('success', 'Salesperson deleted successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting salesperson: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting salesperson: ' . $e->getMessage());
        }
    }
}
