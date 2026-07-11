@extends('admin.layouts.app')

@section('title', 'Random Property')

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
        <span class="text-muted fw-light">Management /</span> Random Property
    </h4>

    <div class="card filter-card">
        <div class="filter-bar-container">
            <div class="filter-item-search">
                <input type="text" class="form-control premium-input" id="search-input" placeholder="Search by Party Name..." onkeyup="debounceSearch()">
            </div>
            <div class="filter-actions">
                <button type="button" class="btn btn-outline-secondary" id="reset-btn" onclick="document.getElementById('search-input').value=''; loadTableData();" style="padding: 0.6rem 1.5rem; border-radius: 8px; font-weight: 500;">
                    <i class="bx bx-reset"></i> Reset
                </button>
                <a href="{{ route('admin.random_properties.create') }}" class="btn btn-premium-add">
                    <i class="bx bx-plus"></i> Add
                </a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 12px; overflow: hidden;" id="table-container">
        @include('admin.random_properties.partials.table', ['customers' => $customers])
    </div>
</div>
@endsection

@section('script')
<script>
    let searchTimeout;

    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(loadTableData, 500);
    }

    function loadTableData(page = 1) {
        const search = document.getElementById('search-input').value;

        $.ajax({
            url: "{{ route('admin.random_properties.table') }}",
            data: { limit: 10, search: search, page: page },
            success: function(response) {
                if (response.success) {
                    $('#table-container').html(response.html);
                }
            },
            error: function(xhr) {
                console.error("Error loading table data");
            }
        });
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        loadTableData(page);
    });
</script>
@endsection
