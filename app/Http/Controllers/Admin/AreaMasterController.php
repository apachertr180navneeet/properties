<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AreaMaster;
use Illuminate\Http\Request;
use Validator;
use Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AreaMasterController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = AreaMaster::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('area_name', 'like', "%{$search}%");
            }

            $limit = $request->get('limit', 10);
            $areaMasters = $query->orderBy('area_name', 'asc')->paginate($limit)->withQueryString();

            return view('admin.areamaster.index', compact('areaMasters'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading areas: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'area_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            AreaMaster::create([
                'area_name' => $request->area_name,
                'status' => 'active',
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Area created successfully!']);
            }

            return redirect()->route('admin.areamaster.index')->with('success', 'Area created successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating area: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error creating area: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $areaMaster = AreaMaster::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $areaMaster
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Area not found: ' . $e->getMessage()
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $areaMaster = AreaMaster::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'area_name' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $areaMaster->update($request->only(['area_name']));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Area updated successfully!']);
            }

            return redirect()->route('admin.areamaster.index')->with('success', 'Area updated successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating area: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error updating area: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $areaMaster = AreaMaster::findOrFail($id);
            $areaMaster->status = $areaMaster->status === 'active' ? 'inactive' : 'active';
            $areaMaster->save();

            return response()->json([
                'success' => true,
                'status' => $areaMaster->status,
                'message' => "Status changed to " . ucfirst($areaMaster->status)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error toggling status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = AreaMaster::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('area_name', 'like', "%{$search}%");
            }

            $areaMasters = $query->orderBy('area_name', 'asc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Area Name');
            $sheet->setCellValue('C1', 'Status');

            $row = 2;
            foreach ($areaMasters as $i => $area) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $area->area_name);
                $sheet->setCellValue('C' . $row, ucfirst($area->status));
                $row++;
            }

            $writer = new Xlsx($spreadsheet);
            $filename = 'areas-' . date('Y-m-d-His') . '.xlsx';
            $temp = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($temp);

            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $areaMaster = AreaMaster::findOrFail($id);
            $areaMaster->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Area deleted successfully!']);
            }

            return redirect()->route('admin.areamaster.index')->with('success', 'Area deleted successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting area: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting area: ' . $e->getMessage());
        }
    }

    public function getTable(Request $request)
    {
        try {
            $query = AreaMaster::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('area_name', 'like', "%{$search}%");
        }

        $limit = $request->get('limit', 10);
        $areaMasters = $query->orderBy('area_name', 'asc')->paginate($limit)->withQueryString();

        $html = view('admin.areamaster.partials.table', compact('areaMasters'))->render();
        return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) { dd($e); }
    }
}
