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
    .filter-item-salesperson {
        flex: 0 0 200px;
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
    
    .btn-premium-search,
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
    .btn-premium-search:hover,
    .btn-premium-add:hover {
        background-color: #2b559b !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(59, 113, 202, 0.2);
    }
    .btn-premium-search:active,
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

    .badge-premium {
        padding: 0.5em 0.85em;
        font-weight: 500;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    .action-btn-edit,
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
    .action-btn-edit:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(255, 171, 0, 0.2);
    }
    .action-btn-delete:hover {
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(255, 62, 29, 0.2);
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
        background-color: #ffe9e6;
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
        background-color: #ff3e1d;
        transition: .3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(255, 62, 29, 0.2);
    }
    .premium-switch input:checked + .premium-switch-slider {
        background-color: #e8fadf;
        border-color: #c7ebc1;
    }
    .premium-switch input:checked + .premium-switch-slider:before {
        transform: translateX(22px);
        background-color: #2d7a1e;
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

    @media (max-width: 767.98px) {
        .filter-item-search,
        .filter-item-salesperson,
        .filter-actions {
            flex: 1 1 100%;
        }
        .filter-actions .btn,
        .filter-actions a {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light">Management /</span> Customers
    </h4>

    <div class="card filter-card">
        <form action="{{ route('admin.customers.index') }}" method="GET" id="search-form">
            <div class="filter-bar-container">
                <div class="filter-item-search">
                    <input type="text" name="search" class="form-control premium-input" id="filter-search" placeholder="Search Here" value="{{ request('search') }}">
                </div>
                <div class="filter-item-salesperson">
                    <select name="sales_person_id" id="filter-salesperson" class="form-control premium-input">
                        <option value="">All Sales Persons</option>
                        @foreach($salespersons as $sp)
                            <option value="{{ $sp->id }}" {{ request('sales_person_id') == $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="button" class="btn btn-outline-secondary" id="reset-btn" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-premium-add">
                        <i class="bx bx-plus"></i> Add
                    </a>
                    <a href="{{ route('admin.customers.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-premium-add" style="background-color: #28a745 !important;">
                        <i class="bx bx-download"></i> Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

    <div id="customer-table-container" class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        @include('admin.customers.partials.table')
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
        const url = "{{ route('admin.customers.table') }}?" + params.toString();
        const newUrl = window.location.pathname + '?' + params.toString();
        window.history.replaceState({}, '', newUrl);
        fetch(url)
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    document.getElementById('customer-table-container').innerHTML = res.html;
                }
            });
    }

    function sendWhatsapp(id) {
        fetch('/admin/customers/' + id + '/send-whatsapp', {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    showToast(res.message, 'success');
                    refreshTable();
                } else {
                    showToast(res.message || 'Unable to update WhatsApp count.', 'error');
                }
            })
            .catch(() => showToast('Unable to update WhatsApp count.', 'error'));
    }

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete Customer "' + name + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!',
            customClass: { confirmButton: 'btn btn-danger me-3', cancelButton: 'btn btn-secondary' },
            buttonsStyling: false
        }).then((result) => {
            if (!result.isConfirmed) return;

            const form = document.querySelector('.delete-form-' + id);
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
                        showToast(res.message || 'Error deleting customer.', 'error');
                    }
                })
                .catch(() => showToast('Error deleting customer.', 'error'));
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('search-form').addEventListener('submit', function(e) {
            e.preventDefault();
            refreshTable();
        });

        document.getElementById('filter-search').addEventListener('input', function() {
            clearTimeout(this._timer);
            this._timer = setTimeout(refreshTable, 400);
        });

        document.getElementById('filter-salesperson').addEventListener('change', refreshTable);

        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('filter-search').value = '';
            document.getElementById('filter-salesperson').value = '';
            const url = new URL(window.location);
            url.searchParams.delete('search');
            url.searchParams.delete('sales_person_id');
            window.history.replaceState({}, '', url);
            refreshTable();
        });

        document.addEventListener('change', function(e) {
            const checkbox = e.target.closest('.toggle-status');
            if (!checkbox) return;
            const id = checkbox.dataset.id;
            checkbox.disabled = true;
            fetch('/admin/customers/' + id + '/toggle-status', {
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

        document.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination a');
            if (!link) return;

            e.preventDefault();
            const tableUrl = "{{ route('admin.customers.table') }}";
            const params = new URLSearchParams(new URL(link.href).search);
            fetch(tableUrl + '?' + params.toString())
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        window.history.replaceState({}, '', link.href);
                        document.getElementById('customer-table-container').innerHTML = res.html;
                    }
                });
        });
    });
</script>
@endsection
