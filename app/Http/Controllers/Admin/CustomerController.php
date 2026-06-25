<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MessageTemplate;
use App\Models\Property;
use App\Models\PropertyShowing;
use App\Models\SalesPerson;
use App\Services\WhatsAppService;
use Exception;
use Illuminate\Http\Request;
use Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $customers = $this->filteredCustomers($request)
                ->orderBy('id', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();

            return view('admin.customers.index', compact('customers', 'salespersons'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading customers: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $customer = new Customer(['status' => 'active']);
            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();

            return view('admin.customers.create', compact('customer', 'salespersons'));
        } catch (Exception $e) { dd($e); }
    }

    public function store(Request $request)
    {
        return $this->saveCustomer($request, new Customer(), 'Customer created successfully!');
    }

    public function edit($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();

            return view('admin.customers.edit', compact('customer', 'salespersons'));
        } catch (Exception $e) { dd($e); }
    }

    public function update(Request $request, $id)
    {
        return $this->saveCustomer($request, Customer::findOrFail($id), 'Customer updated successfully!');
    }

    public function toggleStatus($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->status = $customer->status === 'active' ? 'inactive' : 'active';
            $customer->save();

            return response()->json([
                'success' => true,
                'status' => $customer->status,
                'message' => 'Status changed to ' . ucfirst($customer->status),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            Customer::findOrFail($id)->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Customer deleted successfully!']);
            }

            return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting customer: ' . $e->getMessage()], 500);
            }

            return back()->with('error', 'Error deleting customer: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $customers = $this->filteredCustomers($request)->orderBy('id', 'desc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Name');
            $sheet->setCellValue('C1', 'Phone');
            $sheet->setCellValue('D1', 'Phone 2');
            $sheet->setCellValue('E1', 'City');
            $sheet->setCellValue('F1', 'Via');
            $sheet->setCellValue('G1', 'Sales Person');
            $sheet->setCellValue('H1', 'Type');
            $sheet->setCellValue('I1', 'Visit Date');
            $sheet->setCellValue('J1', 'Msg Count');
            $sheet->setCellValue('K1', 'Messaging');
            $sheet->setCellValue('L1', 'Start Date');
            $sheet->setCellValue('M1', 'Stop Date');
            $sheet->setCellValue('N1', 'Status');

            $row = 2;
            foreach ($customers as $i => $customer) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $customer->name);
                $sheet->setCellValue('C' . $row, $customer->phone);
                $sheet->setCellValue('D' . $row, $customer->customer_phone_2);
                $sheet->setCellValue('E' . $row, $customer->city);
                $sheet->setCellValue('F' . $row, $customer->via);
                $sheet->setCellValue('G' . $row, optional($customer->salesPerson)->name);
                $sheet->setCellValue('H' . $row, ucfirst($customer->customer_type ?? ''));
                $sheet->setCellValue('I' . $row, optional($customer->visit_date)->format('d/m/Y'));
                $sheet->setCellValue('J' . $row, $customer->whatsapp_count);
                $sheet->setCellValue('K' . $row, ucfirst($customer->messaging));
                $sheet->setCellValue('L' . $row, optional($customer->messaging_started_at)->format('d/m/Y'));
                $sheet->setCellValue('M' . $row, optional($customer->messaging_stopped_at)->format('d/m/Y'));
                $sheet->setCellValue('N' . $row, ucfirst($customer->status));
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'customers-' . date('Y-m-d-His') . '.xlsx';
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
            $customers = $this->filteredCustomers($request)
                ->orderBy('id', 'desc')
                ->paginate($request->get('limit', 10))
                ->withQueryString();

            $html = view('admin.customers.partials.table', compact('customers'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) { dd($e); }
    }

    public function sendWhatsapp($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            if ($customer->messaging === 'start') {
                $customer->messaging = 'stop';
                $customer->messaging_stopped_at = now();
                $message = 'WhatsApp service stopped successfully.';
            } else {
                $customer->messaging = 'start';
                $customer->messaging_started_at = now();
                $message = 'WhatsApp service started successfully.';

                $whatsApp = app(WhatsAppService::class);

                $templates = MessageTemplate::where('days_to_send', 1)
                    ->where('status', 'active')
                    ->get();

                foreach ($templates as $template) {
                    if ($whatsApp->sendMessage($customer->phone, $template->message_content)) {
                        $customer->whatsapp_count++;
                        $message = 'WhatsApp service started & Day 1 message sent.';
                    }
                }
            }
            
            $customer->save();

            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $customer->messaging,
                'count' => $customer->whatsapp_count,
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating WhatsApp service status.'], 500);
        }
    }

    public function assignProperties(Request $request, $id)
    {
        try {
            $customer = Customer::with(['properties', 'showings.salesPerson'])->findOrFail($id);
            $assignedIds = $customer->properties->pluck('id')->toArray();
            $showings = $customer->showings->groupBy('property_id');

            $query = Property::query()
                ->where(function ($q) use ($assignedIds) {
                    $q->where('status', 'available')
                      ->orWhereIn('id', $assignedIds);
                })
                ->with('salesPersons');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('property_type', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%")
                      ->orWhere('location', 'like', "%{$search}%");
                });
            }

            if ($request->filled('type_filter')) {
                $query->where('property_type', $request->type_filter);
            }

            if ($request->filled('assignment_filter')) {
                if ($request->assignment_filter === 'assigned') {
                    $query->whereIn('id', $assignedIds);
                } elseif ($request->assignment_filter === 'unassigned') {
                    $query->whereNotIn('id', $assignedIds);
                }
            }

            $properties = $query->orderBy('id', 'desc')
                ->paginate($request->get('limit', 12))
                ->withQueryString();

            $propertySalesPersons = Property::whereIn('id', $assignedIds)
                ->with('salesPersons')
                ->get()
                ->keyBy('id')
                ->map(fn($p) => $p->salesPersons);

            $salespersons = SalesPerson::where('status', 'active')->orderBy('name')->get();

            return view('admin.customers.assign_properties', compact('customer', 'properties', 'assignedIds', 'showings', 'propertySalesPersons', 'salespersons'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading properties: ' . $e->getMessage());
        }
    }

    public function storeShowing(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'property_id' => 'required|exists:properties,id',
                'sales_person_id' => 'required|exists:sales_persons,id',
                'show_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            $showing = PropertyShowing::create([
                'customer_id' => $customer->id,
                'property_id' => $request->property_id,
                'sales_person_id' => $request->sales_person_id,
                'show_date' => $request->show_date,
            ]);

            $showing->load('salesPerson');

            return response()->json([
                'success' => true,
                'message' => 'Showing recorded successfully!',
                'showing' => [
                    'id' => $showing->id,
                    'sales_person_name' => $showing->salesPerson->name,
                    'show_date' => $showing->show_date->format('d M Y'),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function toggleProperty(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $propertyId = $request->input('property_id');
            $property = Property::with('salesPersons')->findOrFail($propertyId);

            if ($customer->properties()->where('property_id', $propertyId)->exists()) {
                $customer->properties()->detach($propertyId);
                $assigned = false;
                $message = 'Property "' . $property->title . '" removed from ' . $customer->name;
            } else {
                $customer->properties()->attach($propertyId);
                $assigned = true;
                $message = 'Property "' . $property->title . '" assigned to ' . $customer->name;

                if ($property->salesPersons->isNotEmpty()) {
                    app(\App\Services\WhatsAppService::class)->sendPropertyAssignedToCustomer($property, $customer->name, $customer->phone);
                }
            }

            return response()->json([
                'success' => true,
                'assigned' => $assigned,
                'message' => $message,
                'total_assigned' => $customer->properties()->count(),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    private function filteredCustomers(Request $request)
    {
        $query = Customer::query()->with('salesPerson');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('customer_phone_2', 'like', "%{$search}%")
                ->orWhere('via', 'like', "%{$search}%")
                ->orWhere('customer_type', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%")
                    ->orWhereHas('salesPerson', function ($salesQuery) use ($search) {
                        $salesQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('sales_person_id')) {
            $query->where('sales_person_id', $request->sales_person_id);
        }

        return $query;
    }

    private function saveCustomer(Request $request, Customer $customer, string $message)
    {
        try {
            $phoneRule = 'required|digits:10|unique:customers,phone,' . ($customer->exists ? $customer->id : 'NULL') . ',id';

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'phone' => $phoneRule,
                'customer_phone_2' => 'nullable|digits:10',
                'via' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'base_requirement' => 'nullable|string',
                'sales_person_id' => 'required|exists:sales_persons,id',
                'customer_type' => 'nullable|in:buyer,seller,both',
                'visit_date' => 'nullable|date',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $data = $request->only([
                'name',
                'phone',
                'customer_phone_2',
                'city',
                'via',
                'base_requirement',
                'sales_person_id',
                'customer_type',
                'visit_date',
            ]);
            $data['status'] = $customer->status ?? 'active';

            if (!$customer->exists) {
                $data['email'] = $this->makePlaceholderEmail($request->phone);
            }

            $customer->fill($data);
            $customer->save();

            return redirect()->route('admin.customers.index')->with('success', $message);
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Error saving customer: ' . $e->getMessage());
        }
    }

    private function makePlaceholderEmail(string $phone): string
    {
        $base = preg_replace('/[^0-9A-Za-z]/', '', $phone) ?: uniqid();
        $email = 'customer-' . $base . '@properties.local';
        $counter = 1;

        while (Customer::where('email', $email)->exists()) {
            $email = 'customer-' . $base . '-' . $counter . '@properties.local';
            $counter++;
        }

        return $email;
    }
}
