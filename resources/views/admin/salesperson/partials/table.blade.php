<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th style="width:60px;">S.No.</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>City</th>
                <th class="text-center">Assign Customer</th>
                <th class="text-center">Properties</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salespersons as $salesperson)
                <tr>
                    <td><span class="text-muted fw-medium">{{ $loop->index + $salespersons->firstItem() }}</span></td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-semibold text-dark">{{ $salesperson->name }}</span>
                            <span class="text-muted" style="font-size: 0.75rem;">{{ $salesperson->email }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="text-secondary fw-medium">{{ $salesperson->phone ?? 'N/A' }}</span>
                    </td>
                    <td>
                        <span class="text-secondary">{{ $salesperson->city ?? 'N/A' }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-label-info badge-premium">{{ $salesperson->customers_count }}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-label-primary badge-premium">{{ $salesperson->properties_count }}</span>
                    </td>
                    <td>
                        <label class="premium-switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $salesperson->id }}" {{ $salesperson->status === 'active' ? 'checked' : '' }}>
                            <span class="premium-switch-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-outline-warning action-btn-edit" onclick="editSalesPerson({{ json_encode($salesperson) }})">
                                <i class="bx bx-edit-alt"></i> Edit
                            </button>
                            <form action="{{ route('admin.salespersons.destroy', $salesperson->id) }}" method="POST" class="d-inline delete-form-{{ $salesperson->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn-delete" onclick="confirmDelete({{ $salesperson->id }}, '{{ $salesperson->name }}')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No Sales Persons found matching the search criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($salespersons->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3">
    <x-pagination :paginator="$salespersons" />
    </div>
@endif