<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th style="width: 60px;">S.No.</th>
                <th>Date</th>
                <th>Party Name</th>
                <th style="width: 180px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customers as $customer)
                <tr>
                    <td>
                        <span class="text-muted fw-medium">{{ $customers->firstItem() + $loop->index }}</span>
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">
                            @if($customer->randomProperties->isNotEmpty())
                                {{ $customer->randomProperties->first()->date->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="fw-semibold text-dark">{{ $customer->name }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.random_properties.show', $customer->id) }}" class="btn btn-sm btn-outline-info">
                                <i class="bx bx-show"></i> Show
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No random properties found matching the search criteria.
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
