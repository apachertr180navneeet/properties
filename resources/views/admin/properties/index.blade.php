@extends('admin.layouts.app')

@section('style')
<style>
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
    .filter-item-limit {
        flex: 0 0 120px;
    }
    .filter-item-search {
        flex: 1 1 280px;
    }
    .filter-actions {
        display: flex;
        gap: 8px;
        flex-wrap: nowrap;
    }
    .premium-input,
    .premium-select {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc !important;
        padding: 0.6rem 1rem !important;
        font-size: 0.9rem !important;
        background-color: #fcfdfd !important;
    }
    .premium-select {
        padding-right: 2rem !important;
    }
    .premium-input:focus,
    .premium-select:focus {
        border-color: #696cff !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.15) !important;
    }
    .btn-premium {
        background-color: #3b71ca !important;
        color: #ffffff !important;
        border: none !important;
        padding: 0.6rem 1.5rem !important;
        border-radius: 8px !important;
        font-weight: 500 !important;
        font-size: 0.9rem !important;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-premium:hover {
        background-color: #2b559b !important;
        color: #fff !important;
    }
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
    .table-premium tbody tr:hover {
        background-color: #f9faff !important;
    }
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
    .action-btn-edit,
    .action-btn-delete {
        border-radius: 6px !important;
        font-size: 0.8rem !important;
        font-weight: 500 !important;
        padding: 0.35rem 0.85rem !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
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
    .pagination { gap: 4px; }
    .pagination .page-item .page-link {
        border-radius: 8px !important;
        border: 1.5px solid #e4e6fc;
        padding: 0.5rem 0.9rem;
        font-size: 0.85rem;
        font-weight: 500;
        color: #566a7f;
        background: #fff;
        margin: 0;
    }
    .pagination .page-item.active .page-link {
        background: #696cff;
        border-color: #696cff;
        color: #fff;
    }
    @media (max-width: 767.98px) {
        .filter-item-limit,
        .filter-item-search,
        .filter-actions {
            flex: 1 1 100%;
        }
        .filter-actions .btn {
            flex: 1;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light">Management /</span> Properties
    </h4>

    <div class="card filter-card">
        <form action="{{ route('admin.properties.index') }}" method="GET" id="search-form">
            <div class="filter-bar-container">
                <div class="filter-item-limit">
                    <select name="limit" id="filter-limit" class="form-select premium-select">
                        @foreach([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}" {{ (int) request('limit', 10) === $limit ? 'selected' : '' }}>Show: {{ $limit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item-search">
                    <input type="text" name="search" class="form-control premium-input" id="filter-search" placeholder="Search here" value="{{ request('search') }}">
                </div>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-premium">
                        <i class="bx bx-search"></i> Search
                    </button>
                    <a href="{{ route('admin.properties.create') }}" class="btn btn-premium">
                        <i class="bx bx-plus"></i> Add
                    </a>
                    <a href="{{ route('admin.properties.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-premium" style="background-color: #28a745 !important;">
                        <i class="bx bx-download"></i> Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

    <div id="property-table-container" class="card border-0 shadow-sm mb-4" style="border-radius: 12px; overflow: hidden;">
        @include('admin.properties.partials.table')
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
        const url = "{{ route('admin.properties.table') }}?" + params.toString();
        const newUrl = window.location.pathname + '?' + params.toString();
        window.history.replaceState({}, '', newUrl);
        fetch(url)
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    document.getElementById('property-table-container').innerHTML = res.html;
                }
            });
    }

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
                    showToast(res.message, 'success');
                } else {
                    showToast(res.message || 'Error.', 'error');
                }
            })
            .catch(() => showToast('Error changing status.', 'error'));
    }

    function confirmDelete(id, title) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete Property "' + title + '". This action cannot be undone!',
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
                        showToast(res.message || 'Error deleting property.', 'error');
                    }
                })
                .catch(() => showToast('Error deleting property.', 'error'));
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

        document.getElementById('filter-limit').addEventListener('change', refreshTable);

        document.addEventListener('click', function(e) {
            const link = e.target.closest('.pagination a');
            if (!link) return;

            e.preventDefault();
            const tableUrl = "{{ route('admin.properties.table') }}";
            const params = new URLSearchParams(new URL(link.href).search);
            fetch(tableUrl + '?' + params.toString())
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        window.history.replaceState({}, '', link.href);
                        document.getElementById('property-table-container').innerHTML = res.html;
                    }
                });
        });
    });
</script>
@endsection