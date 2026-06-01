<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th style="width: 60px;">S.No.</th>
                <th>Name</th>
                <th>Owner</th>
                <th>Type</th>
                <th>Build</th>
                <th>Condition</th>
                <th>City</th>
                <th>Facing</th>
                <th>Amount</th>
                <th>Sales Person</th>
                <th>Status</th>
                <th style="width: 180px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($properties as $property)
                <tr>
                    <td>
                        <span class="text-muted fw-semibold">{{ $properties->firstItem() + $loop->index }}</span>
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $property->title }}</span>
                    </td>
                    <td>{{ $property->owner_name ?? '-' }}</td>
                    <td>{{ $property->property_type ?? '-' }}</td>
                    <td>{{ $property->build_type ?? '-' }}</td>
                    <td>{{ $property->property_condition ?? '-' }}</td>
                    <td>{{ $property->city ?? '-' }}</td>
                    <td>{{ $property->facing ?? '-' }}</td>
                    <td>
                        @if($property->price)
                            {{ rtrim(rtrim(number_format($property->price / 100000, 2), '0'), '.') }}L
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $property->salesPersons->count() ? $property->salesPersons->pluck('name')->implode(', ') : '-' }}</td>
                    <td>
                        <div class="d-flex gap-1 status-toggle-group" data-id="{{ $property->id }}">
                            @foreach(['available', 'sold', 'pending'] as $st)
                                <span class="badge status-pill {{ $property->status === $st ? 'bg-label-success' : 'bg-label-light' }}"
                                      data-status="{{ $st }}"
                                      style="cursor: pointer; padding: .35em .65em; font-size: .75rem; border-radius: 50px; transition: all .15s;"
                                      onclick="changeStatus(this, {{ $property->id }}, '{{ $st }}')">
                                    {{ ucfirst($st) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.properties.show', $property->id) }}" class="btn btn-sm btn-outline-info action-btn-edit">
                                <i class="bx bx-show"></i> View
                            </a>
                            <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-sm btn-outline-warning action-btn-edit">
                                <i class="bx bx-edit-alt"></i> Edit
                            </a>
                            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="d-inline delete-form-{{ $property->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger action-btn-delete" onclick="confirmDelete({{ $property->id }}, '{{ addslashes($property->title) }}')">
                                    <i class="bx bx-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No properties found matching the search criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($properties->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3">
        <x-pagination :paginator="$properties" />
    </div>
@endif
