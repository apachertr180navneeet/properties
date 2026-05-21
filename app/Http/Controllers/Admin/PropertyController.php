<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SalesPerson;
use App\Models\AreaMaster;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        try {
            $properties = $this->filteredProperties($request)
                ->orderBy('id', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            return view('admin.properties.index', compact('properties'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading properties: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();
            $areas = AreaMaster::where('status', 'active')->orderBy('area_name')->get();
            $property = new Property();

            return view('admin.properties.create', compact('property', 'salespersons', 'areas'));
        } catch (Exception $e) { dd($e); }
    }

    public function store(Request $request)
    {
        return $this->saveProperty($request, new Property(), 'Property created successfully!');
    }

    public function edit($id)
    {
        try {
            $property = Property::findOrFail($id);
            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();
            $areas = AreaMaster::where('status', 'active')->orderBy('area_name')->get();

            return view('admin.properties.edit', compact('property', 'salespersons', 'areas'));
        } catch (Exception $e) { dd($e); }
    }

    public function update(Request $request, $id)
    {
        return $this->saveProperty($request, Property::findOrFail($id), 'Property updated successfully!');
    }

    public function show($id)
    {
        try {
            $property = Property::with('salesPerson')->findOrFail($id);

            return view('admin.properties.show', compact('property'));
        } catch (Exception $e) {
            return back()->with('error', 'Property not found.');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Property::findOrFail($id)->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Property deleted successfully!']);
            }

            return redirect()->route('admin.properties.index')->with('success', 'Property deleted successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting property: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Error deleting property: ' . $e->getMessage());
        }
    }

    public function toggleStatus(Request $request, $id)
    {
        try {
            $property = Property::findOrFail($id);
            $status = $request->input('status', 'available');
            if (!in_array($status, ['available', 'sold', 'pending'])) {
                return response()->json(['success' => false, 'message' => 'Invalid status.'], 400);
            }
            $property->status = $status;
            $property->save();

            return response()->json([
                'success' => true,
                'status' => $property->status,
                'message' => 'Status changed to ' . ucfirst($property->status),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $properties = $this->filteredProperties($request)->orderBy('id', 'desc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Title');
            $sheet->setCellValue('C1', 'Type');
            $sheet->setCellValue('D1', 'Category');
            $sheet->setCellValue('E1', 'Location');
            $sheet->setCellValue('F1', 'City');
            $sheet->setCellValue('G1', 'Price');
            $sheet->setCellValue('H1', 'Area Size');
            $sheet->setCellValue('I1', 'Area Unit');
            $sheet->setCellValue('J1', 'Sales Person');
            $sheet->setCellValue('K1', 'Status');

            $row = 2;
            foreach ($properties as $i => $property) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $property->title);
                $sheet->setCellValue('C' . $row, $property->property_type);
                $sheet->setCellValue('D' . $row, $property->property_category);
                $sheet->setCellValue('E' . $row, $property->location);
                $sheet->setCellValue('F' . $row, $property->city);
                $sheet->setCellValue('G' . $row, $property->price);
                $sheet->setCellValue('H' . $row, $property->area_size);
                $sheet->setCellValue('I' . $row, $property->area_unit);
                $sheet->setCellValue('J' . $row, optional($property->salesPerson)->name);
                $sheet->setCellValue('K' . $row, ucfirst($property->status ?? 'available'));
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'properties-' . date('Y-m-d-His') . '.xlsx';
            $temp = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($temp);

            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function getTable(Request $request)
    {
        try {
            $properties = $this->filteredProperties($request)
                ->orderBy('id', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            $html = view('admin.properties.partials.table', compact('properties'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) { dd($e); }
    }

    private function filteredProperties(Request $request)
    {
        $query = Property::query()->with('salesPerson');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('property_type', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('salesPerson', function ($salesQuery) use ($search) {
                        $salesQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }

    private function saveProperty(Request $request, Property $property, string $message)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'property_type' => 'required|in:Plot,Flat,Villa',
                'property_category' => 'required|in:Residential,Commercial',

                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'address' => 'required|string',
                'location' => 'required|string|max:255',
                'pin_code' => 'required|string|max:20',
                'plot_number' => 'nullable|string|max:255',
                'area_size' => 'required|numeric|min:0',
                'area_unit' => 'required|string|max:30',
                'corner_plot' => 'required|in:Yes,No',
                'price' => 'required|numeric|min:0',
                'stamp_duty' => 'nullable|numeric|min:0',
                'sales_person_id' => 'required|exists:sales_persons,id',
                'property_photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
                'registry_document' => 'nullable|file|mimes:pdf,jpeg,jpg,png|max:10240',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }

                return back()->withErrors($validator)->withInput();
            }

            $data = $request->only([
                'title',
                'property_type',
                'property_category',
                'city',
                'state',
                'address',
                'location',
                'pin_code',
                'plot_number',
                'area_size',
                'area_unit',
                'price',
                'stamp_duty',
                'sales_person_id',
            ]);
            $data['corner_plot'] = $request->corner_plot;

            if ($request->hasFile('property_photo')) {
                $data['property_photo'] = $this->uploadFile($request->file('property_photo'), 'uploads/properties/photos/');
            }

            if ($request->hasFile('registry_document')) {
                $data['registry_document'] = $this->uploadFile($request->file('registry_document'), 'uploads/properties/documents/');
            }

            $property->fill($data);
            $property->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => $message]);
            }

            return redirect()->route('admin.properties.index')->with('success', $message);
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error saving property: ' . $e->getMessage()], 500);
            }

            return back()->withInput()->with('error', 'Error saving property: ' . $e->getMessage());
        }
    }

    private function uploadFile($file, string $folder): string
    {
        $path = public_path($folder);

        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $filename = time() . '-' . preg_replace('/[^A-Za-z0-9.\-]/', '', str_replace(' ', '-', $file->getClientOriginalName()));
        $file->move($path, $filename);

        return asset($folder . $filename);
    }
}
