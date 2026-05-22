<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MessageTemplate;
use Illuminate\Http\Request;
use Validator;
use Exception;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MessageTemplateController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = MessageTemplate::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('template_name', 'like', "%{$search}%");
            }

            $limit = $request->get('limit', 10);
            $templates = $query->orderBy('days_to_send', 'asc')->paginate($limit)->withQueryString();

            return view('admin.message_templates.index', compact('templates'));
        } catch (Exception $e) {
            return back()->with('error', 'Error loading templates: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'template_name'  => 'required|string|max:255',
                'days_to_send'   => 'required|integer|min:1',
                'message_content'=> 'nullable|string',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $image = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '_' . Str::slug($request->template_name) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/templates'), $filename);
                $image = asset('uploads/templates/' . $filename);
            }

            MessageTemplate::create([
                'template_name'   => $request->template_name,
                'days_to_send'    => $request->days_to_send,
                'message_content' => $request->message_content,
                'image'           => $image,
                'status'          => 'active',
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Template created successfully!']);
            }

            return redirect()->route('admin.message-templates.index')->with('success', 'Template created successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error creating template: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error creating template: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $template = MessageTemplate::findOrFail($id);
            return response()->json(['success' => true, 'data' => $template]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Template not found.'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $template = MessageTemplate::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'template_name'  => 'required|string|max:255',
                'days_to_send'   => 'required|integer|min:1',
                'message_content'=> 'nullable|string',
                'image'          => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $image = $template->image;
            if ($request->input('remove_image') == '1') {
                if ($image) {
                    $path = parse_url($image, PHP_URL_PATH);
                    $relativePath = ltrim($path, '/');
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath));
                    }
                }
                $image = null;
            }

            if ($request->hasFile('image')) {
                // Remove old image
                if ($image) {
                    $path = parse_url($image, PHP_URL_PATH);
                    $relativePath = ltrim($path, '/');
                    if (file_exists(public_path($relativePath))) {
                        unlink(public_path($relativePath));
                    }
                }

                $file = $request->file('image');
                $filename = time() . '_' . Str::slug($request->template_name) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/templates'), $filename);
                $image = asset('uploads/templates/' . $filename);
            }

            $template->update([
                'template_name'   => $request->template_name,
                'days_to_send'    => $request->days_to_send,
                'message_content' => $request->message_content,
                'image'           => $image,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Template updated successfully!']);
            }

            return redirect()->route('admin.message-templates.index')->with('success', 'Template updated successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error updating template: ' . $e->getMessage()], 500);
            }
            return back()->withInput()->with('error', 'Error updating template: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $template = MessageTemplate::findOrFail($id);
            $template->status = $template->status === 'active' ? 'inactive' : 'active';
            $template->save();

            return response()->json([
                'success' => true,
                'status'  => $template->status,
                'message' => 'Status changed to ' . ucfirst($template->status),
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error toggling status: ' . $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $template = MessageTemplate::findOrFail($id);

            if ($template->image) {
                $path = parse_url($template->image, PHP_URL_PATH);
                $relativePath = ltrim($path, '/');
                if (file_exists(public_path($relativePath))) {
                    unlink(public_path($relativePath));
                }
            }

            $template->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Template deleted successfully!']);
            }

            return redirect()->route('admin.message-templates.index')->with('success', 'Template deleted successfully!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Error deleting template: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Error deleting template: ' . $e->getMessage());
        }
    }

    public function getTable(Request $request)
    {
        try {
            $query = MessageTemplate::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('template_name', 'like', "%{$search}%");
            }

            $limit = $request->get('limit', 10);
            $templates = $query->orderBy('days_to_send', 'asc')->paginate($limit)->withQueryString();

            $html = view('admin.message_templates.partials.table', compact('templates'))->render();
            return response()->json(['success' => true, 'html' => $html]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = MessageTemplate::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('template_name', 'like', "%{$search}%");
            }

            $templates = $query->orderBy('days_to_send', 'asc')->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'S.No');
            $sheet->setCellValue('B1', 'Template Name');
            $sheet->setCellValue('C1', 'Day to Send');
            $sheet->setCellValue('D1', 'Status');

            $row = 2;
            foreach ($templates as $i => $tpl) {
                $sheet->setCellValue('A' . $row, $i + 1);
                $sheet->setCellValue('B' . $row, $tpl->template_name);
                $sheet->setCellValue('C' . $row, $tpl->days_to_send);
                $sheet->setCellValue('D' . $row, ucfirst($tpl->status));
                $row++;
            }

            $writer   = new Xlsx($spreadsheet);
            $filename = 'message-templates-' . date('Y-m-d-His') . '.xlsx';
            $temp     = tempnam(sys_get_temp_dir(), $filename);
            $writer->save($temp);

            return response()->download($temp, $filename)->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return back()->with('error', 'Export failed: ' . $e->getMessage());
        }
    }
}
