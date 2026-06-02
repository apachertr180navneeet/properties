@extends('admin.layouts.app')

@section('style')
<style>
    .status-pill {
        transition: all .15s ease !important;
        user-select: none;
    }
    .status-pill:hover {
        transform: scale(1.08);
        box-shadow: 0 2px 6px rgba(0,0,0,.08);
    }
    .bg-label-light {
        background-color: #f0f2f9 !important;
        color: #566a7f !important;
    }
    .prop-card {
        border-radius: 16px;
        border: 1px solid rgba(105,108,255,.1);
        box-shadow: 0 6px 24px rgba(0,0,0,.06);
        background: #fff;
        overflow: hidden;
    }
    .prop-header {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, #f5f7ff 0%, #fff 100%);
        border-bottom: 1px solid #f0f2f9;
    }
    .prop-title { font-size: 1.35rem; font-weight: 700; color: #2b2b4a; margin: 0; }
    .prop-subtitle { font-size: .85rem; color: #8592a3; margin-top: .25rem; }
    .prop-section {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #f5f6ff;
    }
    .prop-section:last-child { border-bottom: none; }
    .prop-section-title {
        font-size: .82rem;
        font-weight: 700;
        color: #696cff;
        text-transform: uppercase;
        letter-spacing: .6px;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .prop-section-title i { font-size: 1.1rem; }
    .info-card {
        background: #f9faff;
        border-radius: 10px;
        padding: 1rem 1.15rem;
        border: 1px solid #f0f2f9;
    }
    .info-card .label {
        font-size: .78rem;
        color: #8592a3;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: .3rem;
    }
    .info-card .label i { font-size: .9rem; color: #696cff; }
    .info-card .value {
        font-size: .95rem;
        color: #2b2b4a;
        font-weight: 600;
    }
    .doc-card {
        border: 1.5px dashed #e4e6fc;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        background: #fcfdff;
        transition: all .2s;
    }
    .doc-card:hover { border-color: #696cff; background: #f8f9ff; }
    .doc-card img { max-width: 100%; max-height: 110px; object-fit: cover; border-radius: 6px; }
    .doc-card .doc-label { font-size: .8rem; color: #566a7f; margin-top: .5rem; font-weight: 500; }
    .price-amount { font-size: 1.15rem; color: #059669; font-weight: 700; }
    @media (max-width: 767.98px) {
        .prop-header { padding: 1.25rem; }
        .prop-section { padding: 1rem 1.25rem; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Page Header -->
    <div class="d-flex align-items-center justify-content-between py-3 mb-3">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Management / Properties /</span> {{ $property->title }}
        </h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.properties.edit', $property->id) }}" class="btn btn-premium">
                <i class="bx bx-edit-alt"></i> Edit
            </a>
            <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back"></i> Back
            </a>
        </div>
    </div>

    <div class="prop-card mb-5">
        <!-- Property Header -->
        <div class="prop-header">
            <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                <div>
                    <h5 class="prop-title">{{ $property->title }}</h5>
                    <p class="prop-subtitle">
                        <i class="bx bx-calendar"></i> Created {{ $property->created_at->format('d M Y') }}
                        &middot; ID #{{ $property->id }}
                    </p>
                </div>
                <div class="d-flex gap-2 flex-wrap align-items-center">
                    <span class="badge bg-label-info fs-tiny px-3 py-2 rounded-pill">{{ $property->property_type ?? 'N/A' }}</span>
                    <span class="badge bg-label-dark fs-tiny px-3 py-2 rounded-pill">{{ $property->property_category }}</span>
                    <div class="d-flex gap-1 ms-2 status-toggle-group" data-id="{{ $property->id }}">
                        @foreach(['available', 'sold', 'pending'] as $st)
                            <span class="badge status-pill {{ $property->status === $st ? 'bg-label-success' : 'bg-label-light' }}"
                                  data-status="{{ $st }}"
                                  style="cursor: pointer; padding: .35em .65em; font-size: .78rem; border-radius: 50px; transition: all .15s;"
                                  onclick="changeStatus(this, {{ $property->id }}, '{{ $st }}')">
                                {{ ucfirst($st) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Info Cards Row -->
        <div class="prop-section">
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label"><i class="bx bx-map"></i> City</div>
                        <div class="value">{{ $property->city ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label"><i class="bx bx-current-location"></i> Location</div>
                        <div class="value">{{ $property->location ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label"><i class="bx bx-user"></i> Sales Person</div>
                        <div class="value">{{ optional($property->salesPerson)->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label"><i class="bx bx-rupee"></i> Amount</div>
                        <div class="value price-amount">{{ $property->price ? '₹ ' . number_format($property->price, 2) : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Owner Information -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-user"></i> Owner Information</div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Owner Name</div>
                        <div class="value">{{ $property->owner_name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Owner Phone</div>
                        <div class="value">{{ $property->owner_phone ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Registry Owner</div>
                        <div class="value">{{ $property->registry_owner ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Via</div>
                        <div class="value">{{ $property->via ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Location Details -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-map-pin"></i> Location Details</div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label">State</div>
                        <div class="value">{{ $property->state ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label">Pin Code</div>
                        <div class="value">{{ $property->pin_code ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <div class="label">Address</div>
                        <div class="value">{{ $property->address ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Size & Dimensions -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-calculator"></i> Size & Dimensions</div>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Plot Number</div>
                        <div class="value">{{ $property->plot_number ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Dimensions (L X W)</div>
                        <div class="value">
                            @if($property->length || $property->width)
                                {{ $property->length ?? '-' }} {{ $property->size_separator ?? 'X' }} {{ $property->width ?? '-' }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Area Size</div>
                        <div class="value">{{ $property->area_size ? $property->area_size . ' ' . $property->area_unit : '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Corner Plot</div>
                        <div class="value">{{ $property->corner_plot ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Facing</div>
                        <div class="value">{{ $property->facing ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Build Type</div>
                        <div class="value">{{ $property->build_type ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Condition</div>
                        <div class="value">{{ $property->property_condition ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Construction Type</div>
                        <div class="value">{{ $property->construction_type ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Property Age</div>
                        <div class="value">{{ $property->property_age ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing & Dates -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-money"></i> Pricing & Dates</div>
            <div class="row g-3">
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Full Amount</div>
                        <div class="value">{{ $property->price ? '₹ ' . number_format($property->price, 2) : '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Sq. Yard Rate</div>
                        <div class="value">{{ $property->sq_yard_rate ? '₹ ' . number_format($property->sq_yard_rate, 2) : '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Stamp Duty</div>
                        <div class="value">{{ $property->stamp_duty ? '₹ ' . number_format($property->stamp_duty, 2) : '-' }}</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="info-card">
                        <div class="label">Add on Date</div>
                        <div class="value">{{ $property->add_on_date ? \Carbon\Carbon::parse($property->add_on_date)->format('d M Y') : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Setup & Remarks -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-wrench"></i> Setup & Remarks</div>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="info-card">
                        <div class="label">Setup Type</div>
                        <div class="value">{{ $property->setup_type ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="info-card">
                        <div class="label">Remarks</div>
                        <div class="value">{{ $property->remarks ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="prop-section">
            <div class="prop-section-title"><i class="bx bx-folder"></i> Documents</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="doc-card">
                        @if($property->property_photo)
                            <a href="{{ $property->property_photo }}" target="_blank">
                                <img src="{{ $property->property_photo }}" alt="Property Photo">
                            </a>
                            <div class="doc-label"><i class="bx bx-image"></i> Property Photo</div>
                        @else
                            <div class="py-3">
                                <i class="bx bx-image" style="font-size: 2rem; color: #d4d8f0;"></i>
                                <div class="doc-label">No Photo Uploaded</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="doc-card">
                        @if($property->registry_document)
                            <a href="{{ $property->registry_document }}" target="_blank">
                                @if(pathinfo($property->registry_document, PATHINFO_EXTENSION) === 'pdf')
                                    <div class="py-2">
                                        <i class="bx bx-file" style="font-size: 2.5rem; color: #696cff;"></i>
                                    </div>
                                @else
                                    <img src="{{ $property->registry_document }}" alt="Registry Document">
                                @endif
                            </a>
                            <div class="doc-label">
                                <i class="bx bx-file"></i>
                                {{ pathinfo($property->registry_document, PATHINFO_EXTENSION) === 'pdf' ? 'Registry Document (PDF)' : 'Registry Document' }}
                            </div>
                        @else
                            <div class="py-3">
                                <i class="bx bx-file" style="font-size: 2rem; color: #d4d8f0;"></i>
                                <div class="doc-label">No Document Uploaded</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function changeStatus(el, id, status) {
        const url = "{{ route('admin.properties.toggle-status', ['id' => '__ID__']) }}";
        fetch(url.replace('__ID__', id), {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ status: status })
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const group = el.closest('.status-toggle-group');
                    group.querySelectorAll('.status-pill').forEach(p => {
                        p.className = 'badge status-pill bg-label-light';
                        if (p.dataset.status === res.status) {
                            p.className = 'badge status-pill bg-label-success';
                        }
                    });
                }
            })
            .catch(() => {});
    }
</script>
@endsection
