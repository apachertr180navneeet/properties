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
    .filter-item {
        flex: 1 1 200px;
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
    .btn-premium-download {
        background-color: #28a745 !important;
    }
    .btn-premium-download:hover {
        background-color: #218838 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.2);
    }
    .btn-premium-reset {
        background-color: #8592a3 !important;
    }
    .btn-premium-reset:hover {
        background-color: #717d8c !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(133, 146, 163, 0.2);
    }
    .btn-premium-print {
        background-color: #696cff !important;
    }
    .btn-premium-print:hover {
        background-color: #5f61e6 !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(105, 108, 255, 0.2);
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

    /* Pagination */
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

    @media (max-width: 767.98px) {
        .filter-item,
        .filter-actions {
            flex: 1 1 100%;
        }
        .filter-actions .btn {
            flex: 1;
            justify-content: center;
        }
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
        <h4>Property Showings Report</h4>
        <p class="text-muted small">Generated on: {{ now()->format('d M Y, h:i A') }}</p>
        <hr>
    </div>

    <h4 class="fw-bold py-3 mb-3 d-print-none">
        <span class="text-muted fw-light">Reports /</span> Property Showings
    </h4>

    <div class="card filter-card d-print-none">
        <form action="{{ route('admin.reports.showings') }}" method="GET" id="search-form">
            <div class="filter-bar-container">
                <div class="filter-item">
                    <select name="sales_person_id" id="filter-salesperson" class="form-control premium-input">
                        <option value="">All Sales Persons</option>
                        @foreach($salespersons as $sp)
                            <option value="{{ $sp->id }}" {{ request('sales_person_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="customer_id" id="filter-customer" class="form-control premium-input">
                        <option value="">All Customers</option>
                        @foreach($customers as $cust)
                            <option value="{{ $cust->id }}" {{ request('customer_id') == $cust->id ? 'selected' : '' }}>{{ $cust->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select name="property_id" id="filter-property" class="form-control premium-input">
                        <option value="">All Properties</option>
                        @foreach($properties as $prop)
                            <option value="{{ $prop->id }}" {{ request('property_id') == $prop->id ? 'selected' : '' }}>{{ $prop->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-actions">
                    <button type="button" class="btn btn-premium-action btn-premium-reset" id="reset-btn">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                    <a href="{{ route('admin.reports.showings.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-premium-action btn-premium-download" id="excel-btn">
                        <i class="bx bx-download"></i> Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

    <div id="showing-table-container" class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        @include('admin.reports.partials.table')
    </div>

    <!-- Print Button Placement as per drawing -->
    <div class="d-flex justify-content-end mb-4 print-btn-container d-print-none">
        <button type="button" class="btn btn-premium-action btn-premium-print" id="print-btn">
            <i class="bx bx-printer"></i> PRINT
        </button>
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

    function refreshTable() {
        const form = document.getElementById('search-form');
        const params = new URLSearchParams(new FormData(form));
        const url = "{{ route('admin.reports.showings.table') }}?" + params.toString();
        const exportUrl = "{{ route('admin.reports.showings.export') }}?" + params.toString();
        const newUrl = window.location.pathname + '?' + params.toString();
        
        window.history.replaceState({}, '', newUrl);
        
        // Update export Excel button link
        document.getElementById('excel-btn').setAttribute('href', exportUrl);
        
        fetch(url)
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    document.getElementById('showing-table-container').innerHTML = res.html;
                } else {
                    showToast('Failed to fetch showings data.', 'error');
                }
            })
            .catch(() => showToast('Error fetching data.', 'error'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            refreshTable();
        });

        document.getElementById('filter-salesperson').addEventListener('change', refreshTable);
        document.getElementById('filter-customer').addEventListener('change', refreshTable);
        document.getElementById('filter-property').addEventListener('change', refreshTable);

        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('filter-salesperson').value = '';
            document.getElementById('filter-customer').value = '';
            document.getElementById('filter-property').value = '';
            
            const url = new URL(window.location);
            url.searchParams.delete('sales_person_id');
            url.searchParams.delete('customer_id');
            url.searchParams.delete('property_id');
            window.history.replaceState({}, '', url);
            
            refreshTable();
        });

        // Trigger print
        document.getElementById('print-btn').addEventListener('click', function() {
            window.print();
        });

        // Handle dynamic pagination click
        document.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination a');
            if (!link) return;

            e.preventDefault();
            const tableUrl = "{{ route('admin.reports.showings.table') }}";
            const params = new URLSearchParams(new URL(link.href).search);
            
            fetch(tableUrl + '?' + params.toString())
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        window.history.replaceState({}, '', link.href);
                        document.getElementById('showing-table-container').innerHTML = res.html;
                    }
                });
        });
    });
</script>
@endsection
