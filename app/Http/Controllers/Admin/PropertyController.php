<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SalesPerson;
use App\Models\AreaMaster;
use App\Services\WhatsAppService;
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
            $property = Property::with('salesPersons')->findOrFail($id);

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
            $properties->load('salesPersons');

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Title');
            $sheet->setCellValue('C1', 'Owner Name');
            $sheet->setCellValue('D1', 'Owner Phone');
            $sheet->setCellValue('E1', 'Type');
            $sheet->setCellValue('F1', 'Category');
            $sheet->setCellValue('G1', 'Build Type');
            $sheet->setCellValue('H1', 'Condition');
            $sheet->setCellValue('I1', 'Location');
            $sheet->setCellValue('J1', 'City');
            $sheet->setCellValue('K1', 'Price');
            $sheet->setCellValue('L1', 'Sq.Yard Rate');
            $sheet->setCellValue('M1', 'Area Size');
            $sheet->setCellValue('N1', 'Area Unit');
            $sheet->setCellValue('O1', 'Length');
            $sheet->setCellValue('P1', 'Separator');
            $sheet->setCellValue('Q1', 'Width');
            $sheet->setCellValue('S1', 'Facing');
            $sheet->setCellValue('T1', 'Via');
            $sheet->setCellValue('U1', 'Registry Owner');
            $sheet->setCellValue('V1', 'Setup Type');
            $sheet->setCellValue('W1', 'Construction Type');
            $sheet->setCellValue('X1', 'Property Age');
            $sheet->setCellValue('Y1', 'Sales Person');
            $sheet->setCellValue('Z1', 'Status');

            $row = 2;
            foreach ($properties as $i => $property) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $property->title);
                $sheet->setCellValue('C' . $row, $property->owner_name);
                $sheet->setCellValue('D' . $row, $property->owner_phone);
                $sheet->setCellValue('E' . $row, $property->property_type);
                $sheet->setCellValue('F' . $row, $property->property_category);
                $sheet->setCellValue('G' . $row, $property->build_type);
                $sheet->setCellValue('H' . $row, $property->property_condition);
                $sheet->setCellValue('I' . $row, $property->location);
                $sheet->setCellValue('J' . $row, $property->city);
                $sheet->setCellValue('K' . $row, $property->price);
                $sheet->setCellValue('L' . $row, $property->sq_yard_rate);
                $sheet->setCellValue('M' . $row, $property->area_size);
                $sheet->setCellValue('N' . $row, $property->area_unit);
                $sheet->setCellValue('O' . $row, $property->length);
                $sheet->setCellValue('P' . $row, $property->size_separator);
                $sheet->setCellValue('Q' . $row, $property->width);
                $sheet->setCellValue('S' . $row, $property->facing);
                $sheet->setCellValue('T' . $row, $property->via);
                $sheet->setCellValue('U' . $row, $property->registry_owner);
                $sheet->setCellValue('V' . $row, $property->setup_type);
                $sheet->setCellValue('W' . $row, $property->construction_type);
                $sheet->setCellValue('X' . $row, $property->property_age);
                $sheet->setCellValue('Y' . $row, $property->salesPersons->pluck('name')->implode(', '));
                $sheet->setCellValue('Z' . $row, ucfirst($property->status ?? 'available'));
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
        $query = Property::query()->with('salesPersons');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('owner_name', 'like', "%{$search}%")
                    ->orWhere('property_type', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('via', 'like', "%{$search}%")
                    ->orWhere('registry_owner', 'like', "%{$search}%")
                    ->orWhereHas('salesPersons', function ($salesQuery) use ($search) {
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
                'owner_name' => 'nullable|string|max:255',
                'owner_phone' => 'nullable|string|max:20',
                'property_type' => 'nullable|string|max:255',
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
                'length' => 'nullable|numeric|min:0',
                'width' => 'nullable|numeric|min:0',

                'facing' => 'nullable|in:East,West,North,South',
                'remarks' => 'nullable|string',
                'via' => 'nullable|string|max:255',
                'price' => 'required|numeric|min:0',
                'sq_yard_rate' => 'nullable|numeric|min:0',
                'stamp_duty' => 'nullable|numeric|min:0',
                'registry_owner' => 'nullable|string|max:255',
                'setup_type' => 'nullable|in:Fully Furnished,Semi Furnished,Maintained',
                'add_on_date' => 'nullable|date',
                'build_type' => 'nullable|in:Plot,Villa',
                'property_condition' => 'nullable|in:Used,Unused',
                'construction_type' => 'nullable|in:New,Old',
                'property_age' => 'nullable|string|max:255',
                'sales_person_ids' => 'nullable|array',
                'sales_person_ids.*' => 'exists:sales_persons,id',
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
                'owner_name',
                'owner_phone',
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
                'length',
                'width',

                'facing',
                'remarks',
                'via',
                'price',
                'sq_yard_rate',
                'stamp_duty',
                'registry_owner',
                'setup_type',
                'add_on_date',
                'build_type',
                'property_condition',
                'construction_type',
                'property_age',
            ]);
            $data['corner_plot'] = $request->corner_plot;
            $data['size_separator'] = 'X';

            if ($request->hasFile('property_photo')) {
                $data['property_photo'] = $this->uploadFile($request->file('property_photo'), 'uploads/properties/photos/');
            }

            if ($request->hasFile('registry_document')) {
                $data['registry_document'] = $this->uploadFile($request->file('registry_document'), 'uploads/properties/documents/');
            }

            $salesPersonIds = $request->input('sales_person_ids', []);
            $data['sales_person_id'] = !empty($salesPersonIds) ? $salesPersonIds[0] : null;

            $property->fill($data);
            $property->save();

            $property->salesPersons()->sync($salesPersonIds);

            $property->load('salesPersons');
            app(WhatsAppService::class)->sendPropertyDetails($property);

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
