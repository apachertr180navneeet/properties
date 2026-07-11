<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\RandomProperty;

use Exception;
use Validator;
use Illuminate\Support\Facades\DB;

class RandomPropertyController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get customers who have random properties, with latest date
            $query = Customer::whereHas('randomProperties')
                ->withCount('randomProperties')
                ->with(['randomProperties' => function($q) {
                    $q->latest('date');
                }]);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            $customers = $query->orderBy('id', 'desc')->paginate($request->get('limit', 10))->withQueryString();

            return view('admin.random_properties.index', compact('customers'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading random properties: ' . $e->getMessage());
        }
    }

    public function getTable(Request $request)
    {
        try {
            $query = Customer::whereHas('randomProperties')
                ->withCount('randomProperties')
                ->with(['randomProperties' => function($q) {
                    $q->latest('date');
                }]);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%");
            }

            $customers = $query->orderBy('id', 'desc')->paginate($request->get('limit', 10))->withQueryString();

            $html = view('admin.random_properties.partials.table', compact('customers'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function create()
    {
        try {
            $customers = Customer::where('status', 'active')->orderBy('name')->get();
            // Start with one empty row for UI
            $randomProperties = [new RandomProperty()];
            $selectedCustomer = null;
            return view('admin.random_properties.create', compact('customers', 'randomProperties', 'selectedCustomer'));
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required|exists:customers,id',
                'properties' => 'required|array|min:1',
                'properties.*.date' => 'required|date',
                'properties.*.property_name' => 'required|string|max:255',
                'properties.*.remark' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            DB::beginTransaction();
            
            $customerId = $request->customer_id;
            
            // Overwrite strategy: If we are editing, we can delete all existing and recreate them, 
            // or just rely on the user adding/updating rows. 
            // The simplest approach for a bulk form is to delete existing for this customer and re-insert, 
            // OR the form sends IDs for existing ones. 
            // Based on typical "Add/Edit" behavior for bulk items, deleting and recreating is easiest, 
            // but let's see if the UI has IDs. Let's assume we delete and recreate.
            
            RandomProperty::where('customer_id', $customerId)->delete();

            $insertData = [];
            foreach ($request->properties as $prop) {
                $insertData[] = [
                    'customer_id' => $customerId,
                    'date' => $prop['date'],
                    'property_name' => $prop['property_name'],
                    'remark' => $prop['remark'] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($insertData)) {
                RandomProperty::insert($insertData);
            }

            DB::commit();

            return redirect()->route('admin.random_properties.index')->with('success', 'Random properties saved successfully!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error saving random properties: ' . $e->getMessage());
        }
    }

    public function edit($customerId)
    {
        try {
            $customers = Customer::where('status', 'active')->orderBy('name')->get();
            $randomProperties = RandomProperty::where('customer_id', $customerId)->orderBy('date', 'desc')->get();
            if ($randomProperties->isEmpty()) {
                $randomProperties = [new RandomProperty()];
            }
            $selectedCustomer = Customer::findOrFail($customerId);
            
            return view('admin.random_properties.edit', compact('customers', 'randomProperties', 'selectedCustomer'));
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
