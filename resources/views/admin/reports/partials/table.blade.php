<div class="table-responsive">
    <table class="table table-premium align-middle">
        <thead>
            <tr>
                <th>Property Name</th>
                <th>Salesperson</th>
                <th>Customer</th>
                <th>Show Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($showings as $showing)
                <tr>
                    <td>
                        <span class="fw-semibold text-dark">{{ optional($showing->property)->title ?? 'N/A' }}</span>
                        @if(optional($showing->property)->location)
                            <small class="text-muted d-block"><i class="bx bx-map-pin fs-6"></i> {{ $showing->property->location }}</small>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="fw-semibold text-dark d-block">{{ optional($showing->salesPerson)->name ?? 'N/A' }}</span>
                                <small class="text-muted">{{ optional($showing->salesPerson)->phone ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div>
                                <span class="fw-semibold text-dark d-block">{{ optional($showing->customer)->name ?? 'N/A' }}</span>
                                <small class="text-muted">{{ optional($showing->customer)->phone ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-label-success badge-premium text-success">
                            <i class="bx bx-calendar me-1"></i>
                            {{ optional($showing->show_date)->format('d M Y') ?? 'N/A' }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-5 text-muted">
                        <i class="bx bx-info-circle fs-3 mb-2 d-block text-secondary"></i>
                        No property showings found matching the filter criteria.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if($showings->hasPages())
    <div class="card-footer d-flex justify-content-end bg-white border-0 py-3 pagination-container">
        <x-pagination :paginator="$showings" />
    </div>
@endif
