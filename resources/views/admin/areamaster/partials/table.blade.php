<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th style="width:60px;">S.No.</th>
                <th>Area Name</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($areaMasters as $area)
                <tr>
                    <td><span class="text-muted fw-medium">{{ $loop->index + $areaMasters->firstItem() }}</span></td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $area->area_name }}</span>
                    </td>
                    <td>
                        <label class="premium-switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $area->id }}" {{ $area->status === 'active' ? 'checked' : '' }}>
                            <span class="premium-switch-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning action-btn-edit" onclick="editAreaMaster({{ json_encode($area) }})">
                                <i class="bx bx-edit-alt"></i> Edit
                            </button>
                            <form action="{{ route('admin.areamaster.destroy', $area->id) }}" method="POST" class="d-inline delete-form-{{ $area->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn-delete" onclick="confirmDelete({{ $area->id }}, '{{ $area->area_name }}')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No Areas found matching the search criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($areaMasters->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3">
    <x-pagination :paginator="$areaMasters" />
    </div>
@endif