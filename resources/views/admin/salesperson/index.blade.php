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

    /* Premium Filter Bar Design */
    .filter-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: none;
        background: #ffffff;
        margin-bottom: 2rem;
    }
    .filter-bar-container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
        padding: 1.25rem;
    }
    .filter-item-search {
        flex: 1 1 300px;
    }
    .filter-actions {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    
    /* Styled Select and Input fields to match premium layout */
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
    
    .premium-select {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc !important;
        padding: 0.6rem 2rem 0.6rem 1rem !important;
        font-size: 0.9rem !important;
        transition: all 0.25s ease !important;
        background-color: #fcfdfd !important;
    }
    .premium-select:focus {
        border-color: #696cff !important;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }

    .btn-premium-search {
        background-color: #3b71ca !important;
        color: #ffffff !important;
        border: none !important;
        padding: 0.6rem 1.5rem !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium-search:hover {
        background-color: #2b559b !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(59, 113, 202, 0.2);
    }
    .btn-premium-search:active {
        transform: translateY(0);
    }

    .btn-premium-add {
        background-color: #3b71ca !important;
        color: #ffffff !important;
        border: none !important;
        padding: 0.6rem 1.5rem !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium-add:hover {
        background-color: #2b559b !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(59, 113, 202, 0.2);
    }
    .btn-premium-add:active {
        transform: translateY(0);
    }

    /* Premium Table Styles */
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
    }
    .table-premium {
        margin-bottom: 0 !important;
    }
    .table-premium th {
        background-color: #f5f6ff !important;
        color: #566a7f !important;
        font-weight: 600 !important;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem !important;
        border-bottom: 1px solid #e4e6fc !important;
    }
    .table-premium td {
        padding: 1.1rem 1.25rem !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f0f2f9 !important;
    }
    .table-premium tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-premium tbody tr:hover {
        background-color: #f9faff !important;
    }

    /* Form Design */
    .form-card {
        border-radius: 16px;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(105, 108, 255, 0.08);
        background: #ffffff;
        transition: all 0.3s ease;
    }
    .form-card-header {
        border-bottom: 1px solid #f0f2f9;
        padding: 1.5rem 2rem;
        background: linear-gradient(to right, #ffffff, #fcfdfd);
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }
    .form-card-title {
        color: #3b71ca !important;
        font-weight: 700;
        font-size: 1.3rem;
        margin: 0;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .form-card-body {
        padding: 2rem;
    }
    .form-label-premium {
        font-weight: 600 !important;
        color: #435971 !important;
        font-size: 0.9rem !important;
        margin-bottom: 0.5rem !important;
    }

    /* Badges & Action Buttons */
    .badge-premium {
        padding: 0.5em 0.85em;
        font-weight: 500;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    .action-btn-edit {
        border-radius: 6px !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
        padding: 0.35rem 0.85rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .action-btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(255, 171, 0, 0.2);
    }
    .action-btn-delete {
        border-radius: 6px !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
        padding: 0.35rem 0.85rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .action-btn-delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(255, 62, 29, 0.2);
    }

    /* Modal Styling */
    .modal-premium {
        border-radius: 16px;
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .modal-header-premium {
        background: linear-gradient(135deg, #3b71ca 0%, #2b559b 100%);
        color: white;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        padding: 1.25rem 1.75rem;
    }
    .modal-title-premium {
        color: white;
        font-weight: 600;
        font-size: 1.15rem;
    }
    .modal-body-premium {
        padding: 2rem;
    }
    .detail-section-title {
        font-weight: 600;
        color: #3b71ca;
        border-bottom: 2.5px solid #f0f2f9;
        padding-bottom: 5px;
        margin-bottom: 12px;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .detail-item label {
        font-size: 0.8rem;
        color: #8e9bb2;
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 2px;
        display: block;
    }
    .detail-item span {
        font-size: 0.95rem;
        font-weight: 500;
        color: #2b303a;
    }
    
    .list-scroller {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #f0f2f9;
        border-radius: 8px;
        padding: 8px;
        background: #fbfbfe;
    }
    .list-scroller::-webkit-scrollbar {
        width: 6px;
    }
    .list-scroller::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .list-scroller::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 4px;
    }
    .list-scroller::-webkit-scrollbar-thumb:hover {
        background: #aaa;
    }

    .detail-list-item {
        padding: 8px 12px;
        border-bottom: 1px solid #f0f2f9;
        font-size: 0.85rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .detail-list-item:last-child {
        border-bottom: none;
    }

    /* Premium Switch Toggle */
    .premium-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
        vertical-align: middle;
    }
    .premium-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .premium-switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ffe9e6; /* Soft red for inactive */
        border: 1.5px solid #ffccd5;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 24px;
    }
    .premium-switch-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        bottom: 2.5px;
        background-color: #ff3e1d; /* Solid red dot for inactive */
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(255, 62, 29, 0.2);
    }
    .premium-switch input:checked + .premium-switch-slider {
        background-color: #e8fadf; /* Soft green for active */
        border-color: #c7ebc1;
    }
    .premium-switch input:checked + .premium-switch-slider:before {
        transform: translateX(22px);
        background-color: #2d7a1e; /* Solid green dot for active */
        box-shadow: 0 2px 4px rgba(45, 122, 30, 0.2);
    }
    .premium-switch input:focus + .premium-switch-slider {
        box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.15);
    }
    .premium-switch input:disabled + .premium-switch-slider {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Premium Pagination */
    .pagination {
        gap: 4px;
    }
    .pagination .page-item .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc;
        padding: 0.5rem 0.9rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #566a7f;
        background: #fff;
        transition: all .2s ease;
        margin: 0;
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

    .btn-premium-action {
        color: #ffffff !important;
        border: none !important;
        padding: 0.6rem 1.5rem !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium-print {
        background-color: #696cff !important;
    }
    .btn-premium-print:hover {
        background-color: #5f61e6 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(105, 108, 255, 0.2);
    }

    /* PRINT STYLES */
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .card-header, .print-btn-container, .navbar, .layout-menu, .content-backdrop, footer {
            display: none !important;
        }
        .table-responsive {
            overflow: visible !important;
        }
        .pagination-container {
            display: none !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" id="print-section">
    <!-- Hidden Print Header -->
    <div class="d-none d-print-block text-center mb-4">
        <h2>{{ config('app.name', 'Paresh Properties') }}</h2>
        <h4>Sales Persons List</h4>
        <p class="text-muted small">Generated on: {{ now()->format('d M Y, h:i A') }}</p>
        <hr>
    </div>

    <h4 class="fw-bold py-3 mb-3 d-print-none">
        <span class="text-muted fw-light">Management /</span> Sales Persons
    </h4>

    <!-- Filter Bar Card -->
    <div class="card filter-card d-print-none">
        <form action="{{ route('admin.salespersons.index') }}" method="GET" id="search-form">
            <div class="filter-bar-container">
                <!-- Search Input -->
                <div class="filter-item-search">
                    <input type="text" name="search" class="form-control premium-input" id="filter-search" placeholder="Search Here" value="{{ request('search') }}">
                </div>

                <!-- Action Buttons -->
                <div class="filter-actions">
                    <button type="button" class="btn btn-outline-secondary" id="reset-btn" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                    <button type="button" class="btn btn-premium-add" onclick="resetAndFocusForm()">
                        <i class="bx bx-plus"></i> Add
                    </button>
                    <a href="{{ route('admin.salespersons.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-premium-add" style="background-color: #28a745 !important;">
                        <i class="bx bx-download"></i> Excel
                    </a>
                    <button type="button" class="btn btn-premium-action btn-premium-print" id="print-btn">
                        <i class="bx bx-printer"></i> PRINT
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

<div id="salesperson-table-container" class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;">
        @include('admin.salesperson.partials.table')
    </div>

    <!-- Add/Edit SALES MAN Modal -->
    <div class="modal fade" id="addEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content modal-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title modal-title-premium" id="addEditModalTitle">Add/Edit SALES MAN</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.salespersons.store') }}" method="POST" id="salesperson-form">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    
                    <div class="modal-body modal-body-premium">
                        <div id="form-error-container" class="alert alert-danger d-none"></div>
                        <div class="row g-3">
                            <!-- Sales Person Name -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label form-label-premium" for="form_name">Sales Person Name:</label>
                                    <input type="text" name="name" id="form_name" class="form-control premium-input" placeholder="Enter Sales Person Name">
                                    <div class="invalid-feedback" id="form_name_error"></div>
                                </div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label form-label-premium" for="form_phone">Mobile Number:</label>
                                    <input type="text" name="phone" id="form_phone" class="form-control premium-input" placeholder="Enter Mobile Number">
                                    <div class="invalid-feedback" id="form_phone_error"></div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label form-label-premium" for="form_email">Email Address:</label>
                                    <input type="email" name="email" id="form_email" class="form-control premium-input" placeholder="Enter Email Address">
                                    <div class="invalid-feedback" id="form_email_error"></div>
                                </div>
                            </div>

                            <!-- City -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label form-label-premium" for="form_city">City:</label>
                                    <input type="text" name="city" id="form_city" class="form-control premium-input" placeholder="Enter City">
                                    <div class="invalid-feedback" id="form_city_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 text-start">
                        <button type="submit" class="btn btn-premium-search" id="form_submit_btn" style="padding: 0.75rem 2.5rem !important;">
                            Submit
                        </button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="padding: 0.75rem 2rem; border-radius: 8px;">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="viewDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-premium">
            <div class="modal-header modal-header-premium">
                <h5 class="modal-title modal-title-premium" id="modalSalesPersonName">Sales Person Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-body-premium">
                
                <!-- General Info -->
                <div class="detail-section-title">General Information</div>
                <div class="detail-grid">
                    <div class="detail-item">
                        <label>Email Address</label>
                        <span id="detailEmail">-</span>
                    </div>
                    <div class="detail-item">
                        <label>Mobile Number</label>
                        <span id="detailPhone">-</span>
                    </div>
                    <div class="detail-item">
                        <label>City</label>
                        <span id="detailCity">-</span>
                    </div>
                    <div class="detail-item">
                        <label>Status</label>
                        <span id="detailStatus">-</span>
                    </div>
                </div>

                <!-- Assigned Properties & Customers in grid -->
                <div class="row mt-4">
                    <!-- Properties -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-section-title d-flex justify-content-between align-items-center">
                            <span>Properties</span>
                            <span class="badge bg-primary rounded-pill" id="detailPropertiesCount" style="font-size: 0.75rem;">0</span>
                        </div>
                        <div class="list-scroller" id="detailPropertiesList">
                            <div class="text-center text-muted py-3">No properties assigned</div>
                        </div>
                    </div>

                    <!-- Customers -->
                    <div class="col-md-6 mb-3">
                        <div class="detail-section-title d-flex justify-content-between align-items-center">
                            <span>Customers</span>
                            <span class="badge bg-info rounded-pill" id="detailCustomersCount" style="font-size: 0.75rem;">0</span>
                        </div>
                        <div class="list-scroller" id="detailCustomersList">
                            <div class="text-center text-muted py-3">No customers assigned</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function showToast(message, type = 'success') {
        const toast = document.getElementById('custom-toast');
        toast.className = 'custom-toast toast-' + type + ' show';
        toast.innerHTML = '<i class="bx ' + (type === 'success' ? 'bx-check-circle' : 'bx-x-circle') + '"></i> ' + message;
        setTimeout(() => toast.classList.remove('show'), 4000);
    }

    function clearFormErrors() {
        document.querySelectorAll('.form-control').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
        const errContainer = document.getElementById('form-error-container');
        errContainer.classList.add('d-none');
        errContainer.textContent = '';
    }

    function showFormErrors(errors) {
        for (const field in errors) {
            const input = document.getElementById('form_' + field);
            const errorEl = document.getElementById('form_' + field + '_error');
            if (input) input.classList.add('is-invalid');
            if (errorEl) errorEl.textContent = errors[field].join(', ');
        }
    }

    function refreshTable() {
        const form = document.getElementById('search-form');
        const params = new URLSearchParams(new FormData(form));
        const url = "{{ route('admin.salespersons.table') }}?" + params.toString();
        const newUrl = window.location.pathname + '?' + params.toString();
        window.history.replaceState({}, '', newUrl);
        fetch(url)
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    document.getElementById('salesperson-table-container').innerHTML = res.html;
                }
            });
    }

    // Handles filling the Add/Edit form for edit mode
    function editSalesPerson(salesperson) {
        clearFormErrors();
        const form = document.getElementById('salesperson-form');
        form.action = `/admin/salespersons/${salesperson.id}`;
        document.getElementById('form-method').value = 'PUT';

        document.getElementById('form_name').value = salesperson.name;
        document.getElementById('form_phone').value = salesperson.phone || '';
        document.getElementById('form_email').value = salesperson.email;
        document.getElementById('form_city').value = salesperson.city || '';

        document.getElementById('addEditModalTitle').innerText = 'Edit SALES MAN';
        document.getElementById('form_submit_btn').innerText = 'Update';

        bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).show();
    }

    // Resets form to add mode
    function resetAndFocusForm() {
        clearFormErrors();
        const form = document.getElementById('salesperson-form');
        form.action = "{{ route('admin.salespersons.store') }}";
        document.getElementById('form-method').value = 'POST';

        document.getElementById('form_name').value = '';
        document.getElementById('form_phone').value = '';
        document.getElementById('form_email').value = '';
        document.getElementById('form_city').value = '';

        document.getElementById('addEditModalTitle').innerText = 'Add SALES MAN';
        document.getElementById('form_submit_btn').innerText = 'Submit';

        bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).show();
    }

    // AJAX form submission
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('salesperson-form').addEventListener('submit', function(e) {
            e.preventDefault();
            clearFormErrors();

            const form = this;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('form_submit_btn');
            const originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';

            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            })
            .then(response => response.json().then(data => ({ status: response.status, data })))
            .then(({ status, data }) => {
                if (data.success) {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).hide();
                    refreshTable();
                    showToast(data.message, 'success');
                } else {
                    if (data.errors) {
                        showFormErrors(data.errors);
                    } else {
                        const errContainer = document.getElementById('form-error-container');
                        errContainer.textContent = data.message || 'An error occurred.';
                        errContainer.classList.remove('d-none');
                    }
                }
            })
            .catch(() => {
                showToast('Something went wrong. Please try again.', 'error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = originalText;
            });
        });

        // Live search on input
        document.getElementById('filter-search').addEventListener('input', function() {
            clearTimeout(this._timer);
            this._timer = setTimeout(refreshTable, 400);
        });

        // Prevent form from doing full page submit
        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            refreshTable();
        });

        // Pagination links via AJAX
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination a');
            if (link) {
                e.preventDefault();
                const url = link.href;
                const tableUrl = "{{ route('admin.salespersons.table') }}";
                const params = new URLSearchParams(new URL(url).search);
                fetch(tableUrl + '?' + params.toString())
                    .then(r => r.json())
                    .then(res => {
                        if (res.success) {
                            window.history.replaceState({}, '', url);
                            document.getElementById('salesperson-table-container').innerHTML = res.html;
                        }
                    });
            }
        });

        // Status toggle via AJAX
        document.addEventListener('change', function(e) {
            const checkbox = e.target.closest('.toggle-status');
            if (!checkbox) return;
            const id = checkbox.dataset.id;
            
            checkbox.disabled = true;

            fetch(`/admin/salespersons/${id}/toggle-status`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(res => {
                checkbox.disabled = false;
                if (res.success) {
                    checkbox.checked = res.status === 'active';
                    showToast(res.message, 'success');
                } else {
                    checkbox.checked = !checkbox.checked;
                    showToast(res.message, 'error');
                }
            })
            .catch(() => {
                checkbox.disabled = false;
                checkbox.checked = !checkbox.checked;
                showToast('Error toggling status.', 'error');
            });
        });

        // Reset button
        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('filter-search').value = '';
            const url = new URL(window.location);
            url.searchParams.delete('search');
            window.history.replaceState({}, '', url);
            refreshTable();
        });

        // Trigger print
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });
    });

    // Confirm Delete using SweetAlert2
    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete Sales Person "${name}". This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-danger me-3',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.querySelector(`.delete-form-${id}`);
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        showToast(res.message, 'success');
                        refreshTable();
                    } else {
                        showToast(res.message, 'error');
                    }
                })
                .catch(() => showToast('Error deleting salesperson.', 'error'));
            }
        });
    }

    // Fetch and View Sales Person Details via AJAX
    function viewSalesPerson(id) {
        fetch(`/admin/salespersons/${id}`)
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    const salesperson = result.data;
                    
                    document.getElementById('modalSalesPersonName').innerText = `${salesperson.name} - Profile Details`;
                    document.getElementById('detailEmail').innerText = salesperson.email;
                    document.getElementById('detailPhone').innerText = salesperson.phone || 'N/A';
                    document.getElementById('detailCity').innerText = salesperson.city || 'N/A';
                    
                    const statusBadge = salesperson.status === 'active' 
                        ? '<span class="badge bg-label-success badge-premium">Active</span>' 
                        : '<span class="badge bg-label-danger badge-premium">Inactive</span>';
                    document.getElementById('detailStatus').innerHTML = statusBadge;

                    document.getElementById('detailPropertiesCount').innerText = salesperson.properties_count;
                    let propertiesHtml = '';
                    if (salesperson.properties && salesperson.properties.length > 0) {
                        salesperson.properties.forEach(prop => {
                            const formattedPrice = new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 0 }).format(prop.price);
                            propertiesHtml += `
                                <div class="detail-list-item">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">${prop.title}</span>
                                        <span class="text-muted" style="font-size: 0.75rem;"><i class="bx bx-map-pin"></i> ${prop.location || 'N/A'}</span>
                                    </div>
                                    <span class="badge bg-label-primary">${formattedPrice}</span>
                                </div>
                            `;
                        });
                    } else {
                        propertiesHtml = '<div class="text-center text-muted py-3">No properties assigned</div>';
                    }
                    document.getElementById('detailPropertiesList').innerHTML = propertiesHtml;

                    document.getElementById('detailCustomersCount').innerText = salesperson.customers_count;
                    let customersHtml = '';
                    if (salesperson.customers && salesperson.customers.length > 0) {
                        salesperson.customers.forEach(cust => {
                            customersHtml += `
                                <div class="detail-list-item">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">${cust.name}</span>
                                        <span class="text-muted" style="font-size: 0.75rem;"><i class="bx bx-envelope"></i> ${cust.email}</span>
                                    </div>
                                    <span style="font-size: 0.8rem; color: #566a7f;">${cust.phone || 'N/A'}</span>
                                </div>
                            `;
                        });
                    } else {
                        customersHtml = '<div class="text-center text-muted py-3">No customers assigned</div>';
                    }
                    document.getElementById('detailCustomersList').innerHTML = customersHtml;

                    bootstrap.Modal.getOrCreateInstance(document.getElementById('viewDetailModal')).show();
                } else {
                    showToast(result.message || 'Failed to fetch details.', 'error');
                }
            })
            .catch(() => {
                showToast('An error occurred while loading salesperson data.', 'error');
            });
    }
</script>
@endsection
