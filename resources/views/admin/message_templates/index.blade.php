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
        <span class="text-muted fw-light">Management /</span>
        Message Templates
    </h4>

    <!-- Filter Card -->
    <div class="card filter-card mb-4">
        <form id="search-form" method="GET" action="{{ route('admin.message-templates.index') }}">
            <div class="filter-bar-container d-flex justify-content-between align-items-center p-3">

                <div class="filter-item-search w-50">
                    <input type="text"
                           id="filter-search"
                           name="search"
                           class="form-control premium-input"
                           placeholder="Search by Template Title"
                           value="{{ request('search') }}">
                </div>

                <div class="filter-actions d-flex gap-2">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            id="reset-btn">
                        <i class="bx bx-reset"></i> Reset
                    </button>

                    <button type="button"
                            class="btn btn-primary"
                            onclick="resetAndFocusForm()">
                        <i class="bx bx-plus"></i> Add
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Toast -->
    <div id="custom-toast"
         class="custom-toast"
         onclick="this.classList.remove('show')">
    </div>

    <!-- Table -->
    <div id="template-table-container"
         class="card border-0 shadow-sm mb-5"
         style="border-radius: 12px; overflow: hidden;">
        @include('admin.message_templates.partials.table')
    </div>

    <!-- Modal -->
    <div class="modal fade"
         id="addEditModal"
         tabindex="-1"
         aria-hidden="true">

        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content modal-premium">

                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title" id="addEditModalTitle">
                        Add Template
                    </h5>

                    <button type="button"
                            class="btn-close btn-close-white"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <form id="template-form"
                      method="POST"
                      action="{{ route('admin.message-templates.store') }}"
                      enctype="multipart/form-data">

                    @csrf

                    <input type="hidden"
                           name="_method"
                           id="form-method"
                           value="POST">

                    <div class="modal-body">

                        <div id="form-error-container"
                             class="alert alert-danger d-none">
                        </div>

                        <div class="row g-3">

                            <!-- Template Name -->
                            <div class="col-md-12">
                                <label class="form-label">
                                    Template Name
                                </label>

                                <input type="text"
                                       name="template_name"
                                       id="form_template_name"
                                       class="form-control premium-input"
                                       placeholder="Enter Template Name">

                                <div class="invalid-feedback"
                                     id="form_template_name_error">
                                </div>
                            </div>

                            <!-- Days -->
                            <div class="col-md-12">
                                <label class="form-label">
                                    Day to Send from Start
                                </label>

                                <input type="number"
                                       name="days_to_send"
                                       id="form_days_to_send"
                                       class="form-control premium-input"
                                       min="0"
                                       placeholder="e.g. 5">

                                <div class="invalid-feedback"
                                     id="form_days_to_send_error">
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="col-md-12">
                                <label class="form-label">
                                    Message Template
                                </label>

                                <textarea name="message_content"
                                          id="form_message_content"
                                          class="form-control premium-input"
                                          rows="4"
                                          placeholder="WhatsApp message content"></textarea>

                                <div class="invalid-feedback"
                                     id="form_message_content_error">
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-md-12">
                                <label class="form-label">
                                    Image (optional)
                                </label>

                                <input type="file"
                                       name="image"
                                       id="form_image"
                                       class="form-control premium-input"
                                       accept="image/*">

                                <div class="invalid-feedback"
                                     id="form_image_error">
                                </div>

                                <!-- Image Preview Container -->
                                <div id="image-preview-container" class="mt-3 d-none">
                                    <label class="form-label d-block text-muted small fw-bold">Current Image</label>
                                    <div class="d-flex align-items-start gap-2">
                                        <img id="image-preview" src="" alt="Preview" class="img-thumbnail" style="max-height: 120px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.08);">
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="remove-image-btn" style="border-radius: 6px; padding: 4px 8px;">
                                            <i class="bx bx-trash"></i> Remove
                                        </button>
                                    </div>
                                    <input type="hidden" name="remove_image" id="remove-image-input" value="0">
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 pt-0">
                        <button type="submit"
                                class="btn btn-primary"
                                id="form_submit_btn">
                            Submit
                        </button>

                        <button type="button"
                                class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">
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

    /**
     * Show Toast Message
     */
    function showToast(message, type = 'success') {

        let toast = document.getElementById('custom-toast');

        toast.className = 'custom-toast toast-' + type + ' show';

        toast.innerHTML =
            '<i class="bx ' +
            (type === 'success'
                ? 'bx-check-circle'
                : 'bx-x-circle') +
            '"></i> ' + message;

        setTimeout(() => {
            toast.classList.remove('show');
        }, 4000);
    }

    /**
     * Clear Validation Errors
     */
    function clearFormErrors() {

        document
            .querySelectorAll('.form-control, .form-select')
            .forEach(function(el) {
                el.classList.remove('is-invalid');
            });

        document
            .querySelectorAll('.invalid-feedback')
            .forEach(function(el) {
                el.textContent = '';
            });

        let errContainer =
            document.getElementById('form-error-container');

        errContainer.classList.add('d-none');
        errContainer.textContent = '';
    }

    /**
     * Show Validation Errors
     */
    function showFormErrors(errors) {

        for (let field in errors) {

            let input =
                document.getElementById('form_' + field);

            let errorEl =
                document.getElementById('form_' + field + '_error');

            if (input) {
                input.classList.add('is-invalid');
            }

            if (errorEl) {
                errorEl.textContent =
                    Array.isArray(errors[field])
                    ? errors[field].join(', ')
                    : errors[field];
            }
        }
    }

    /**
     * Open Add Modal
     */
    function resetAndFocusForm() {

        clearFormErrors();

        let form =
            document.getElementById('template-form');

        form.action =
            "{{ route('admin.message-templates.store') }}";

        document.getElementById('form-method').value = 'POST';

        form.reset();



        document.getElementById('form_image').value = '';

        // Reset image preview container
        document.getElementById('image-preview-container').classList.add('d-none');
        document.getElementById('image-preview').src = '';
        document.getElementById('remove-image-input').value = '0';

        document.getElementById('addEditModalTitle').innerText =
            'Add Template';

        document.getElementById('form_submit_btn').innerText =
            'Submit';

        bootstrap.Modal
            .getOrCreateInstance(
                document.getElementById('addEditModal')
            )
            .show();
    }

    /**
     * Edit Template
     */
    function editTemplate(template) {

        clearFormErrors();

        let form =
            document.getElementById('template-form');

        form.action =
            '/admin/message-templates/' + template.id;

        document.getElementById('form-method').value = 'PUT';

        document.getElementById('form_template_name').value =
            template.template_name ?? '';

        document.getElementById('form_days_to_send').value =
            template.days_to_send ?? '';

        document.getElementById('form_message_content').value =
            template.message_content ?? '';



        document.getElementById('form_image').value = '';

        // Handle image preview
        let previewContainer = document.getElementById('image-preview-container');
        let previewImg = document.getElementById('image-preview');
        let removeImageInput = document.getElementById('remove-image-input');
        
        removeImageInput.value = '0';
        
        if (template.image) {
            previewImg.src = template.image;
            previewContainer.classList.remove('d-none');
        } else {
            previewImg.src = '';
            previewContainer.classList.add('d-none');
        }

        document.getElementById('addEditModalTitle').innerText =
            'Edit Template';

        document.getElementById('form_submit_btn').innerText =
            'Update';

        bootstrap.Modal
            .getOrCreateInstance(
                document.getElementById('addEditModal')
            )
            .show();
    }

    /**
     * Refresh Table
     */
    function refreshTable(pageUrl = null) {

        let form =
            document.getElementById('search-form');

        let params =
            new URLSearchParams(new FormData(form));

        let url =
            pageUrl ??
            "{{ route('admin.message-templates.table') }}?" +
            params.toString();

        window.history.replaceState(
            {},
            '',
            window.location.pathname + '?' + params.toString()
        );

        fetch(url)

        .then(response => response.json())

        .then(res => {

            if (res.success) {

                document.getElementById(
                    'template-table-container'
                ).innerHTML = res.html;
            }
        })

        .catch(() => {
            showToast(
                'Unable to refresh table.',
                'error'
            );
        });
    }

    /**
     * Delete Template
     */
    function confirmDelete(id, name) {

        Swal.fire({

            title: 'Are you sure?',

            text:
                'You are about to delete Template "' +
                name +
                '".',

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

        }).then(function(result) {

            if (result.isConfirmed) {

                let form =
                    document.querySelector(
                        '.delete-form-' + id
                    );

                let formData =
                    new FormData(form);

                fetch(form.action, {

                    method: 'POST',

                    headers: {
                        'X-Requested-With':
                            'XMLHttpRequest'
                    },

                    body: formData

                })

                .then(response => response.json())

                .then(res => {

                    if (res.success) {

                        showToast(
                            res.message,
                            'success'
                        );

                        refreshTable();

                    } else {

                        showToast(
                            res.message,
                            'error'
                        );
                    }
                })

                .catch(() => {

                    showToast(
                        'Error deleting template.',
                        'error'
                    );
                });
            }
        });
    }

    /**
     * Document Ready
     */
    document.addEventListener('DOMContentLoaded', function() {

        /**
         * Submit Form
         */
        document
            .getElementById('template-form')
            .addEventListener('submit', function(e) {

                e.preventDefault();

                clearFormErrors();

                let form = this;

                let formData =
                    new FormData(form);

                let submitBtn =
                    document.getElementById(
                        'form_submit_btn'
                    );

                let originalText =
                    submitBtn.innerText;

                submitBtn.disabled = true;

                submitBtn.innerText = 'Saving...';

                fetch(form.action, {

                    method: 'POST',

                    headers: {
                        'X-Requested-With':
                            'XMLHttpRequest'
                    },

                    body: formData

                })

                .then(async response => {

                    let data =
                        await response.json();

                    return {
                        status: response.status,
                        data: data
                    };
                })

                .then(result => {

                    if (result.data.success) {

                        bootstrap.Modal
                            .getOrCreateInstance(
                                document.getElementById(
                                    'addEditModal'
                                )
                            )
                            .hide();

                        refreshTable();

                        showToast(
                            result.data.message,
                            'success'
                        );

                    } else {

                        if (result.data.errors) {

                            showFormErrors(
                                result.data.errors
                            );

                        } else {

                            let errContainer =
                                document.getElementById(
                                    'form-error-container'
                                );

                            errContainer.textContent =
                                result.data.message ||
                                'An error occurred.';

                            errContainer.classList.remove(
                                'd-none'
                            );
                        }
                    }
                })

                .catch(() => {

                    showToast(
                        'Something went wrong.',
                        'error'
                    );
                })

                .finally(() => {

                    submitBtn.disabled = false;

                    submitBtn.innerText = originalText;
                });
            });

        /**
         * Search
         */
        document
            .getElementById('filter-search')
            .addEventListener('input', function() {

                clearTimeout(this._timer);

                this._timer = setTimeout(() => {
                    refreshTable();
                }, 400);
            });

        /**
         * Prevent Normal Submit
         */
        document
            .getElementById('search-form')
            .addEventListener('submit', function(e) {

                e.preventDefault();

                refreshTable();
            });

        /**
         * Pagination
         */
        document.addEventListener('click', function(e) {

            let link =
                e.target.closest('.pagination a');

            if (!link) return;

            e.preventDefault();

            refreshTable(link.href);
        });

        /**
         * Toggle Status
         */
        document.addEventListener('change', function(e) {

            let cb =
                e.target.closest('.toggle-status');

            if (!cb) return;

            let id = cb.dataset.id;

            cb.disabled = true;

            fetch(
                '/admin/message-templates/' +
                id +
                '/toggle-status',
                {

                    method: 'POST',

                    headers: {

                        'X-Requested-With':
                            'XMLHttpRequest',

                        'X-CSRF-TOKEN':
                            '{{ csrf_token() }}'
                    }
                }
            )

            .then(response => response.json())

            .then(res => {

                cb.disabled = false;

                if (res.success) {

                    cb.checked =
                        res.status === 'active';

                    showToast(
                        res.message,
                        'success'
                    );

                } else {

                    showToast(
                        res.message,
                        'error'
                    );
                }
            })

            .catch(() => {

                cb.disabled = false;

                showToast(
                    'Error toggling status.',
                    'error'
                );
            });
        });

        /**
         * Remove Image Button
         */
        document
            .getElementById('remove-image-btn')
            .addEventListener('click', function() {
                document.getElementById('remove-image-input').value = '1';
                document.getElementById('image-preview-container').classList.add('d-none');
                document.getElementById('image-preview').src = '';
            });

        /**
         * Reset Search
         */
        document
            .getElementById('reset-btn')
            .addEventListener('click', function() {

                document.getElementById(
                    'filter-search'
                ).value = '';

                let url =
                    new URL(window.location);

                url.searchParams.delete('search');

                window.history.replaceState(
                    {},
                    '',
                    url
                );

                refreshTable();
            });

    });

</script>
@endsection