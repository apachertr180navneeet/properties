<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Sales Person</th>
                <th>Visit Date</th>
                <th>Whatsapp</th>
                <th>Btn</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td><span class="fw-semibold text-dark">{{ $customer->name }}</span></td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>{{ $customer->city ?? '-' }}</td>
                    <td>{{ optional($customer->salesPerson)->name ?? '-' }}</td>
                    <td>{{ optional($customer->visit_date)->format('d/m/Y') ?? '-' }}</td>
                    <td class="text-center">
                        <span class="whatsapp-count-{{ $customer->id }} fw-semibold">{{ $customer->whatsapp_count }}</span>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-outline-primary action-btn-edit" onclick="sendWhatsapp({{ $customer->id }})">
                            {{ $customer->whatsapp_count > 0 ? 'Stop' : 'Start' }}
                        </button>
                    </td>
                    <td>
                        <label class="premium-switch">
                            <input type="checkbox" class="toggle-status" data-id="{{ $customer->id }}" {{ $customer->status === 'active' ? 'checked' : '' }}>
                            <span class="premium-switch-slider"></span>
                        </label>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.customers.assign-properties', $customer->id) }}" class="btn btn-sm btn-outline-success action-btn-edit" title="Assign Properties">
                                <i class="bx bx-building-house"></i> Assign
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning action-btn-edit">
                                <i class="bx bx-edit-alt"></i> Edit
                            </a>
                            <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-inline delete-form-{{ $customer->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn-delete" onclick="confirmDelete({{ $customer->id }}, '{{ addslashes($customer->name) }}')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No customers found matching the search criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($customers->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3">
        <x-pagination :paginator="$customers" />
    </div>
@endif
