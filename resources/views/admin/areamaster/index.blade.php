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
    .filter-item-search {
        flex: 1 1 300px;
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
    .badge-premium {
        padding: 0.5em 0.85em;
        font-weight: 500;
        font-size: 0.85rem;
        border-radius: 6px;
    }
    .action-links {
        display: flex;
        gap: 12px;
        font-weight: 500;
        font-size: 0.85rem;
    }
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
    .custom-toast {
        position: fixed; top: 20px; right: 20px; z-index: 99999;
        min-width: 280px; max-width: 400px;
        padding: 14px 20px; border-radius: 10px;
        font-size: .9rem; font-weight: 500;
        display: flex; align-items: center; gap: 10px;
        box-shadow: 0 6px 20px rgba(0,0,0,.15);
        transform: translateX(120%); transition: transform .4s ease;
        cursor: pointer;
    }
    .custom-toast.show { transform: translateX(0); }
    .custom-toast.toast-success { background: #059669; color: #fff; }
    .custom-toast.toast-error { background: #dc2626; color: #fff; }
    .custom-toast i { font-size: 1.3rem; }

    /* Premium Switch */
    .premium-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        cursor: pointer;
    }
    .premium-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .premium-switch-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
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
</style>
@endsection

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-3">
        <span class="text-muted fw-light">Management /</span> Area Master
    </h4>

    <div class="card filter-card">
        <form action="{{ route('admin.areamaster.index') }}" method="GET" id="search-form">
            <div class="filter-bar-container">
                <div class="filter-item-search">
                    <input type="text" name="search" class="form-control premium-input" id="filter-search" placeholder="Search by Area Name" value="{{ request('search') }}">
                </div>
                <div class="filter-actions">
                    <button type="button" class="btn btn-outline-secondary" id="reset-btn" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                        <i class="bx bx-reset"></i> Reset
                    </button>
                    <button type="button" class="btn btn-premium-add" onclick="resetAndFocusForm()">
                        <i class="bx bx-plus"></i> Add
                    </button>
                    <a href="{{ route('admin.areamaster.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-premium-add" style="background-color: #28a745 !important;">
                        <i class="bx bx-download"></i> Excel
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div id="custom-toast" class="custom-toast" onclick="this.classList.remove('show')"></div>

    <div id="area-table-container" class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;">
        @include('admin.areamaster.partials.table')
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal fade" id="addEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content modal-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title modal-title-premium" id="addEditModalTitle">Add Area</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.areamaster.store') }}" method="POST" id="area-form">
                    @csrf
                    <input type="hidden" name="_method" id="form-method" value="POST">
                    <div class="modal-body modal-body-premium">
                        <div id="form-error-container" class="alert alert-danger d-none"></div>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label form-label-premium" for="form_area_name">Area Name:</label>
                                    <input type="text" name="area_name" id="form_area_name" class="form-control premium-input" placeholder="Enter Area Name">
                                    <div class="invalid-feedback" id="form_area_name_error"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 text-start">
                        <button type="submit" class="btn btn-premium-add" id="form_submit_btn" style="padding: 0.75rem 2.5rem !important;">
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
@endsection

@section('script')
<script>
    function showToast(message, type) {
        var toast = document.getElementById('custom-toast');
        toast.className = 'custom-toast toast-' + type + ' show';
        toast.innerHTML = '<i class="bx ' + (type === 'success' ? 'bx-check-circle' : 'bx-x-circle') + '"></i> ' + message;
        setTimeout(function() { toast.classList.remove('show'); }, 4000);
    }

    function clearFormErrors() {
        document.querySelectorAll('.form-control').forEach(function(el) { el.classList.remove('is-invalid'); });
        document.querySelectorAll('.invalid-feedback').forEach(function(el) { el.textContent = ''; });
        var errContainer = document.getElementById('form-error-container');
        errContainer.classList.add('d-none');
        errContainer.textContent = '';
    }

    function showFormErrors(errors) {
        for (var field in errors) {
            var input = document.getElementById('form_' + field);
            var errorEl = document.getElementById('form_' + field + '_error');
            if (input) input.classList.add('is-invalid');
            if (errorEl) errorEl.textContent = errors[field].join(', ');
        }
    }

    function refreshTable() {
        var form = document.getElementById('search-form');
        var params = new URLSearchParams(new FormData(form));
        var url = "{{ route('admin.areamaster.table') }}?" + params.toString();
        var newUrl = window.location.pathname + '?' + params.toString();
        window.history.replaceState({}, '', newUrl);
        fetch(url).then(function(r) { return r.json(); }).then(function(res) {
            if (res.success) {
                document.getElementById('area-table-container').innerHTML = res.html;
            }
        });
    }

    function editAreaMaster(area) {
        clearFormErrors();
        document.getElementById('area-form').action = '/admin/areamaster/' + area.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('form_area_name').value = area.area_name;
        document.getElementById('addEditModalTitle').innerText = 'Edit Area';
        document.getElementById('form_submit_btn').innerText = 'Update';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).show();
    }

    function resetAndFocusForm() {
        clearFormErrors();
        document.getElementById('area-form').action = "{{ route('admin.areamaster.store') }}";
        document.getElementById('form-method').value = 'POST';
        document.getElementById('form_area_name').value = '';
        document.getElementById('addEditModalTitle').innerText = 'Add Area';
        document.getElementById('form_submit_btn').innerText = 'Submit';
        bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).show();
    }

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete Area "' + name + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff3e1d',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!',
            customClass: { confirmButton: 'btn btn-danger me-3', cancelButton: 'btn btn-secondary' },
            buttonsStyling: false
        }).then(function(result) {
            if (result.isConfirmed) {
                var form = document.querySelector('.delete-form-' + id);
                var formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                }).then(function(r) { return r.json(); }).then(function(res) {
                    if (res.success) { showToast(res.message, 'success'); refreshTable(); }
                    else { showToast(res.message, 'error'); }
                }).catch(function() { showToast('Error deleting area.', 'error'); });
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('area-form').addEventListener('submit', function(e) {
            e.preventDefault();
            clearFormErrors();
            var form = this;
            var formData = new FormData(form);
            var submitBtn = document.getElementById('form_submit_btn');
            var originalText = submitBtn.innerText;
            submitBtn.disabled = true;
            submitBtn.innerText = 'Saving...';
            fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            }).then(function(response) {
                return response.json().then(function(data) { return { status: response.status, data: data }; });
            }).then(function(result) {
                if (result.data.success) {
                    bootstrap.Modal.getOrCreateInstance(document.getElementById('addEditModal')).hide();
                    refreshTable();
                    showToast(result.data.message, 'success');
                } else {
                    if (result.data.errors) { showFormErrors(result.data.errors); }
                    else {
                        var errContainer = document.getElementById('form-error-container');
                        errContainer.textContent = result.data.message || 'An error occurred.';
                        errContainer.classList.remove('d-none');
                    }
                }
            }).catch(function() { showToast('Something went wrong. Please try again.', 'error'); })
            .finally(function() { submitBtn.disabled = false; submitBtn.innerText = originalText; });
        });

        document.getElementById('filter-search').addEventListener('input', function() {
            clearTimeout(this._timer);
            this._timer = setTimeout(refreshTable, 400);
        });

        document.getElementById('search-form').addEventListener('submit', function(e) { e.preventDefault(); refreshTable(); });

        document.addEventListener('click', function(e) {
            var link = e.target.closest('.pagination a');
            if (link) {
                e.preventDefault();
                var tableUrl = "{{ route('admin.areamaster.table') }}";
                var params = new URLSearchParams(new URL(link.href).search);
                fetch(tableUrl + '?' + params.toString()).then(function(r) { return r.json(); }).then(function(res) {
                    if (res.success) { window.history.replaceState({}, '', link.href); document.getElementById('area-table-container').innerHTML = res.html; }
                });
            }
        });

        document.addEventListener('change', function(e) {
            var cb = e.target.closest('.toggle-status');
            if (!cb) return;
            var id = cb.dataset.id;
            cb.disabled = true;
            fetch('/admin/areamaster/' + id + '/toggle-status', {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(function(r) { return r.json(); }).then(function(res) {
                cb.disabled = false;
                if (res.success) {
                    cb.checked = res.status === 'active';
                    showToast(res.message, 'success');
                } else { showToast(res.message, 'error'); }
            }).catch(function() { cb.disabled = false; showToast('Error toggling status.', 'error'); });
        });

        document.getElementById('reset-btn').addEventListener('click', function() {
            document.getElementById('filter-search').value = '';
            var url = new URL(window.location);
            url.searchParams.delete('search');
            window.history.replaceState({}, '', url);
            refreshTable();
        });
    });
</script>
@endsection