@php
    $templates = $templates ?? [];
@endphp
<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th style="width:60px;">S.No.</th>
                <th>Template Name</th>
                <th>Day to Send</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($templates as $template)
                <tr>
                    <td><span class="text-muted fw-medium">{{ $loop->index + $templates->firstItem() }}</span></td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($template->image)
                                <img src="{{ $template->image }}" alt="{{ $template->template_name }}" class="rounded me-2 shadow-sm" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid #dee2e6;">
                            @else
                                <div class="rounded me-2 bg-light d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; border: 1px solid #dee2e6;">
                                    <i class="bx bx-image text-muted fs-4"></i>
                                </div>
                            @endif
                            <span class="fw-semibold text-dark">{{ $template->template_name }}</span>
                        </div>
                    </td>
                    <td>{{ $template->days_to_send }}</td>
                    <td>
                        <label class="premium-switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $template->id }}" {{ $template->status === 'active' ? 'checked' : '' }}>
                            <span class="premium-switch-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning action-btn-edit" onclick="editTemplate({{ json_encode($template) }})">
                                <i class="bx bx-edit-alt"></i> Edit
                            </button>
                            <form action="{{ route('admin.message-templates.destroy', $template->id) }}" method="POST" class="d-inline delete-form-{{ $template->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn-delete" onclick="confirmDelete({{ $template->id }}, '{{ $template->template_name }}')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No Message Templates found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($templates->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3">
        <x-pagination :paginator="$templates" />
    </div>
@endif
