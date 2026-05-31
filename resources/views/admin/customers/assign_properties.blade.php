@extends('admin.layouts.app')

@section('style')
<style>
    /* Custom Toast */
    .custom-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 99999;
        min-width: 280px;
        max-width: 400px;
        padding: 14px 20px;
        border-radius: 10px;
        font-size: .9rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,.15);
        transform: translateX(120%);
        transition: transform .4s ease;
        cursor: pointer;
    }
    .custom-toast.show { transform: translateX(0); }
    .custom-toast.toast-success { background: #059669; color: #fff; }
    .custom-toast.toast-error { background: #dc2626; color: #fff; }
    .custom-toast i { font-size: 1.3rem; }

    /* Customer Header Card */
    .customer-header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 14px;
        padding: 1.5rem 2rem;
        color: #fff;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
    }
    .customer-header-card::before {
        content: '';
        position: absolute;
        top: -40%;
        right: -10%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .customer-header-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 15%;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .customer-header-card h4 {
        margin: 0;
        font-weight: 700;
        font-size: 1.3rem;
    }
    .customer-header-card .customer-meta {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        margin-top: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }
    .customer-header-card .customer-meta span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .assigned-counter {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 0.75rem;
        font-size: 0.95rem;
    }

    /* Filter Card */
    .filter-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        background: #ffffff;
        margin-bottom: 1.5rem;
    }
    .filter-bar-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        padding: 1.25rem;
    }
    .filter-item-search {
        flex: 1 1 250px;
    }
    .filter-item-type,
    .filter-item-assignment {
        flex: 0 0 170px;
    }
    .filter-actions {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    .premium-input {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc !important;
        padding: 0.6rem 1rem !important;
        font-size: 0.9rem !important;
        transition: all 0.25s ease !important;
        background-color: #fcfdfd !important;
    }
    .premium-input:focus {
        border-color: #696cff !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }

    /* Property Cards Grid */
    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.25rem;
        padding: 0;
    }

    .property-card {
        background: #ffffff;
        border-radius: 14px;
        border: 2px solid #f0f2f9;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        display: flex;
        flex-direction: column;
    }
    .property-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 36px rgba(0, 0, 0, 0.08);
        border-color: #e0e3ff;
    }
    .property-card.is-assigned {
        border-color: #059669;
        background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 30%);
    }
    .property-card.is-assigned:hover {
        border-color: #059669;
        box-shadow: 0 12px 36px rgba(5, 150, 105, 0.12);
    }

    .property-card-header {
        padding: 1.15rem 1.25rem 0.6rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
    }
    .property-card-header .property-title {
        font-weight: 700;
        font-size: 1rem;
        color: #2d3748;
        margin: 0;
        line-height: 1.3;
    }
    .property-card-header .property-type-badge {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.3em 0.7em;
        border-radius: 6px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .badge-plot { background: #fef3cd; color: #856404; }
    .badge-flat { background: #d1ecf1; color: #0c5460; }
    .badge-villa { background: #f8d7da; color: #721c24; }

    .property-card-body {
        padding: 0.5rem 1.25rem 0.85rem;
        flex: 1;
    }
    .property-detail-row {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0.3rem 0;
        font-size: 0.875rem;
        color: #64748b;
    }
    .property-detail-row i {
        font-size: 1rem;
        color: #94a3b8;
        width: 18px;
        text-align: center;
        flex-shrink: 0;
    }
    .property-detail-row .detail-value {
        font-weight: 500;
        color: #475569;
    }
    .property-price {
        font-size: 1.15rem;
        font-weight: 700;
        color: #059669;
        margin-top: 0.25rem;
    }

    .property-card-footer {
        padding: 0.85rem 1.25rem;
        background: #f9fafb;
        border-top: 1px solid #f0f2f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .property-card.is-assigned .property-card-footer {
        background: #f0fdf4;
        border-top-color: #dcfce7;
    }

    /* Assign Toggle Switch */
    .assign-switch {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }
    .assign-switch input {
        opacity: 0;
        width: 0;
        height: 0;
        position: absolute;
    }
    .assign-switch-track {
        width: 50px;
        height: 26px;
        background: #e2e8f0;
        border-radius: 26px;
        position: relative;
        transition: all 0.3s ease;
    }
    .assign-switch-track::before {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        background: #fff;
        border-radius: 50%;
        top: 3px;
        left: 3px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    .assign-switch input:checked + .assign-switch-track {
        background: linear-gradient(135deg, #059669, #10b981);
    }
    .assign-switch input:checked + .assign-switch-track::before {
        transform: translateX(24px);
    }
    .assign-switch-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: #94a3b8;
        transition: color 0.3s ease;
    }
    .assign-switch input:checked ~ .assign-switch-label {
        color: #059669;
    }

    /* Assigned badge on card */
    .assigned-ribbon {
        position: absolute;
        top: 12px;
        right: -30px;
        background: #059669;
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        padding: 3px 35px;
        transform: rotate(45deg);
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(5,150,105,0.3);
        z-index: 2;
    }

    /* Status badge */
    .property-status-badge {
        font-size: 0.72rem;
        padding: 0.25em 0.6em;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        display: block;
        color: #cbd5e1;
    }

    /* Pagination */
    .pagination { gap: 4px; }
    .pagination .page-item .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc;
        padding: 0.5rem 0.9rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #566a7f;
        background: #fff;
        transition: all .2s ease;
    }
    .pagination .page-item .page-link:hover {
        border-color: #696cff;
        color: #696cff;
        background: #f5f6ff;
    }
    .pagination .page-item.active .page-link {
        background: #696cff;
        border-color: #696cff;
        color: #fff;
        box-shadow: 0 2px 8px rgba(105,108,255,.3);
    }
    .pagination .page-item.disabled .page-link {
        opacity: .5;
        pointer-events: none;
    }

    .btn-back {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.35);
        color: #fff;
        border-radius: 8px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.3);
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 767.98px) {
        .property-grid {
            grid-template-columns: 1fr;
        }
        .filter-item-search,
        .filter-item-type,
        .filter-item-assignment,
        .filter-actions {
            flex: 1 1 100%;
        }
        .customer-header-card {
            padding: 1.25rem;
        }
        .customer-header-card h4 {
            font-size: 1.1rem;
        }
        .customer-header-card .customer-meta {
            gap: 0.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light">Management / <a href="{{ route('admin.customers.index') }}" class="text-muted">Customers</a> /</span> Assign Properties
    </h4>

    {{-- Customer Info Header --}}
    <div class="customer-header-card">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h4><i class="bx bx-user me-1"></i> {{ $customer->name }}</h4>
                <div class="customer-meta">
                    <span><i class="bx bx-phone"></i> {{ $customer->phone ?? '-' }}</span>
                    <span><i class="bx bx-map"></i> {{ $customer->city ?? '-' }}</span>
                    <span><i class="bx bx-user-pin"></i> {{ optional($customer->salesPerson)->name ?? '-' }}</span>
                </div>
                <div class="assigned-counter">
                    <i class="bx bx-building-house"></i>
                    <span id="assigned-count">{{ count($assignedIds) }}</span> Properties Assigned
                </div>
            </div>
            <a href="{{ route('admin.customers.index') }}" class="btn-back">
                <i class="bx bx-arrow-back"></i> Back to Customers
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card filter-card">
        <form action="{{ route('admin.customers.assign-properties', $customer->id) }}" method="GET" id="filter-form">
            <div class="filter-bar-container">
                <div class="filter-item-search">
                    <input type="text" name="search" class="form-control premium-input" id="filter-search" placeholder="Search properties..." value="{{ request('search') }}">
                </div>
                <div class="filter-item-type">
                    <select name="type_filter" id="filter-type" class="form-control premium-input">
                        <option value="">All Types</option>
                        <option value="Plot" {{ request('type_filter') == 'Plot' ? 'selected' : '' }}>Plot</option>
                        <option value="Flat" {{ request('type_filter') == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Villa" {{ request('type_filter') == 'Villa' ? 'selected' : '' }}>Villa</option>
                    </select>
                </div>
                <div class="filter-item-assignment">
                    <select name="assignment_filter" id="filter-assignment" class="form-control premium-input">
                        <option value="">All Properties</option>
                        <option value="assigned" {{ request('assignment_filter') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="unassigned" {{ request('assignment_filter') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                        <i class="bx bx-search"></i> Search
                    </button>
                    <a href="{{ route('admin.customers.assign-properties', $customer->id) }}" class="btn btn-outline-secondary" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                        <i class="bx bx-reset"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

    {{-- Property Cards Grid --}}
    <div class="property-grid" id="property-grid">
        @forelse($properties as $property)
            @php
                $isAssigned = in_array($property->id, $assignedIds);
                $typeBadge = match(strtolower($property->property_type ?? '')) {
                    'plot' => 'badge-plot',
                    'flat' => 'badge-flat',
                    'villa' => 'badge-villa',
                    default => 'bg-label-secondary'
                };
                $statusColor = match(strtolower($property->status ?? 'available')) {
                    'available' => 'bg-label-success',
                    'sold' => 'bg-label-danger',
                    'pending' => 'bg-label-warning',
                    default => 'bg-label-secondary'
                };
            @endphp
            <div class="property-card {{ $isAssigned ? 'is-assigned' : '' }}" id="property-card-{{ $property->id }}">
                @if($isAssigned)
                    <div class="assigned-ribbon" id="ribbon-{{ $property->id }}">ASSIGNED</div>
                @endif

                <div class="property-card-header">
                    <h5 class="property-title">{{ $property->title }}</h5>
                    <span class="property-type-badge {{ $typeBadge }}">{{ $property->property_type ?? '-' }}</span>
                </div>

                <div class="property-card-body">
                    <div class="property-price">
                        @if($property->price)
                            ₹ {{ rtrim(rtrim(number_format($property->price / 100000, 2), '0'), '.') }} Lakh
                        @else
                            <span class="text-muted">Price not set</span>
                        @endif
                    </div>

                    <div class="property-detail-row">
                        <i class="bx bx-map"></i>
                        <span class="detail-value">{{ $property->location ?? '-' }}, {{ $property->city ?? '' }}</span>
                    </div>
                    <div class="property-detail-row">
                        <i class="bx bx-area"></i>
                        <span class="detail-value">
                            {{ $property->area_size ? $property->area_size . ' ' . ($property->area_unit ?? '') : '-' }}
                            @if($property->corner_plot)
                                <span class="badge bg-label-info ms-1" style="font-size: 0.7rem;">Corner</span>
                            @endif
                        </span>
                    </div>
                    <div class="property-detail-row">
                        <i class="bx bx-category"></i>
                        <span class="detail-value">{{ $property->property_category ?? '-' }}</span>
                    </div>
                    <div class="property-detail-row">
                        <i class="bx bx-user"></i>
                        <span class="detail-value">{{ $property->salesPersons->count() ? $property->salesPersons->pluck('name')->implode(', ') : '-' }}</span>
                    </div>

                    @if($isAssigned && isset($showings[$property->id]))
                        <div class="mt-2 pt-2" style="border-top: 1px dashed #e4e6fc;">
                            <div style="font-size: 0.75rem; font-weight: 600; color: #696cff; text-transform: uppercase; letter-spacing: 0.4px; margin-bottom: 4px;">
                                <i class="bx bx-history"></i> Showings
                            </div>
                            @foreach($showings[$property->id] as $showing)
                                <div style="font-size: 0.78rem; color: #475569; display: flex; align-items: center; gap: 6px; padding: 2px 0;">
                                    <i class="bx bx-user-circle" style="color: #94a3b8;"></i>
                                    <span>{{ $showing->salesPerson->name ?? '-' }}</span>
                                    <span style="color: #94a3b8;">&middot;</span>
                                    <span>{{ $showing->show_date->format('d M Y') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="property-card-footer">
                    <div class="d-flex align-items-center gap-2">
                        <span class="property-status-badge {{ $statusColor }}">
                            {{ ucfirst($property->status ?? 'available') }}
                        </span>
                        @if($isAssigned)
                            @php
                                $assignedSPs = $propertySalesPersons[$property->id] ?? collect();
                            @endphp
                            <button type="button" class="btn btn-sm btn-outline-primary show-property-btn"
                                    data-property-id="{{ $property->id }}"
                                    data-property-title="{{ $property->title }}"
                                    data-sales-persons='{{ $assignedSPs->map(fn($sp) => ["id" => $sp->id, "name" => $sp->name])->toJson() }}'
                                    style="border-radius: 6px; font-size: 0.75rem; padding: 0.2rem 0.6rem;">
                                <i class="bx bx-show"></i> Show
                            </button>
                        @endif
                    </div>
                    <label class="assign-switch" onclick="event.stopPropagation()">
                        <input type="checkbox"
                               class="toggle-property"
                               data-property-id="{{ $property->id }}"
                               {{ $isAssigned ? 'checked disabled' : '' }}>
                        <span class="assign-switch-track"></span>
                        <span class="assign-switch-label">{{ $isAssigned ? 'Assigned' : 'Assign' }}</span>
                    </label>
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <i class="bx bx-building-house"></i>
                <h5 class="text-muted fw-semibold">No properties found</h5>
                <p class="text-muted">Try adjusting your search or filter criteria.</p>
            </div>
        @endforelse
    </div>

    @if($properties->hasPages())
        <div class="d-flex justify-content-end mt-4 mb-3">
            <x-pagination :paginator="$properties" />
        </div>
    @endif
</div>
@endsection

<!-- Showing Modal -->
<div class="modal fade" id="showingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 12px 40px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom: 1px solid #f0f2f9; padding: 1rem 1.25rem;">
                <h6 class="modal-title fw-bold" style="color: #2b2b4a;">
                    <i class="bx bx-show" style="color: #696cff;"></i> Record Showing
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="showing-form">
                <div class="modal-body" style="padding: 1.25rem;">
                    <p id="showing-property-title" class="text-muted mb-3" style="font-size: 0.9rem;"></p>
                    <input type="hidden" name="property_id" id="showing-property-id">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size: 0.85rem; color: #435971;">Sales Person</label>
                        <select name="sales_person_id" id="showing-sales-person" class="form-select" required style="border-radius: 8px; border-color: #e4e6fc;">
                            <option value="">— Select —</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-semibold" style="font-size: 0.85rem; color: #435971;">Show Date</label>
                        <input type="date" name="show_date" id="showing-date" class="form-control" value="{{ date('Y-m-d') }}" required style="border-radius: 8px; border-color: #e4e6fc;">
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f2f9; padding: 0.85rem 1.25rem;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 8px; font-size: 0.85rem;">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="showing-submit" style="border-radius: 8px; font-size: 0.85rem;">
                        <i class="bx bx-check"></i> Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('script')
<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('custom-toast');
        toast.className = 'custom-toast toast-' + type + ' show';
        toast.innerHTML = '<i class="bx ' + (type === 'success' ? 'bx-check-circle' : 'bx-x-circle') + '"></i> ' + message;
        setTimeout(() => toast.classList.remove('show'), 4000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Live search with debounce
        document.getElementById('filter-search').addEventListener('input', function() {
            clearTimeout(this._timer);
            this._timer = setTimeout(() => {
                document.getElementById('filter-form').submit();
            }, 600);
        });

        // Filter dropdowns auto submit
        document.getElementById('filter-type').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
        document.getElementById('filter-assignment').addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });

        // Show Property button - open modal
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.show-property-btn');
            if (!btn) return;

            const propertyId = btn.dataset.propertyId;
            const propertyTitle = btn.dataset.propertyTitle;
            const sps = JSON.parse(btn.dataset.salesPersons || '[]');

            document.getElementById('showing-property-id').value = propertyId;
            document.getElementById('showing-property-title').textContent = 'Property: ' + propertyTitle;
            document.getElementById('showing-date').value = new Date().toISOString().split('T')[0];

            // Populate dropdown with only assigned sales persons
            const select = document.getElementById('showing-sales-person');
            select.innerHTML = '<option value="">— Select —</option>';
            sps.forEach(function(sp) {
                const opt = document.createElement('option');
                opt.value = sp.id;
                opt.textContent = sp.name;
                select.appendChild(opt);
            });

            const modal = new bootstrap.Modal(document.getElementById('showingModal'));
            modal.show();
        });

        // Submit showing form
        document.getElementById('showing-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('showing-submit');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Saving...';

            const formData = new FormData(this);
            const propertyId = formData.get('property_id');

            fetch('/admin/customers/{{ $customer->id }}/store-showing', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bx bx-check"></i> Record';

                if (res.success) {
                    const modalEl = document.getElementById('showingModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    showToast(res.message, 'success');

                    // Reload page to show updated showings
                    setTimeout(() => location.reload(), 800);
                } else {
                    showToast(res.message || 'Error recording showing.', 'error');
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="bx bx-check"></i> Record';
                showToast('Error recording showing.', 'error');
            });
        });

        // Toggle property assignment
        document.addEventListener('change', function(e) {
            const checkbox = e.target.closest('.toggle-property');
            if (!checkbox) return;

            const propertyId = checkbox.dataset.propertyId;
            const card = document.getElementById('property-card-' + propertyId);
            const label = checkbox.closest('.assign-switch').querySelector('.assign-switch-label');

            checkbox.disabled = true;

            fetch('/admin/customers/{{ $customer->id }}/toggle-property', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ property_id: propertyId })
            })
            .then(r => r.json())
            .then(res => {
                checkbox.disabled = false;

                if (res.success) {
                    showToast(res.message, 'success');

                    // Update counter
                    document.getElementById('assigned-count').textContent = res.total_assigned;

                    // Update card visual state
                    if (res.assigned) {
                        card.classList.add('is-assigned');
                        label.textContent = 'Assigned';
                        // Add ribbon if not exists
                        if (!document.getElementById('ribbon-' + propertyId)) {
                            const ribbon = document.createElement('div');
                            ribbon.className = 'assigned-ribbon';
                            ribbon.id = 'ribbon-' + propertyId;
                            ribbon.textContent = 'ASSIGNED';
                            card.insertBefore(ribbon, card.firstChild);
                        }
                        // Reload to add showing section
                        setTimeout(() => location.reload(), 500);
                    } else {
                        card.classList.remove('is-assigned');
                        label.textContent = 'Assign';
                        const ribbon = document.getElementById('ribbon-' + propertyId);
                        if (ribbon) ribbon.remove();
                        setTimeout(() => location.reload(), 500);
                    }
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast(res.message || 'Error updating assignment.', 'error');
                }
            })
            .catch(() => {
                checkbox.disabled = false;
                checkbox.checked = !checkbox.checked;
                showToast('Error updating assignment.', 'error');
            });
        });
    });
</script>
@endsection
