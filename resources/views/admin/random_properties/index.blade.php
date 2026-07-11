@extends('admin.layouts.app')

@section('title', 'Random Property')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Random Property</h4>
    <a href="{{ route('admin.random_properties.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bx bx-plus"></i> Add Random Property
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-bottom px-4 py-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fw-medium">SHOW:</span>
                <select class="form-select form-select-sm w-auto cursor-pointer" id="limit-select" onchange="loadTableData()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="search-box position-relative">
                    <i class="bx bx-search position-absolute top-50 translate-middle-y text-muted ms-3"></i>
                    <input type="text" class="form-control form-control-sm rounded-pill ps-5 pe-4 py-2" id="search-input" placeholder="Search Party Name..." onkeyup="debounceSearch()">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0" id="table-container">
        @include('admin.random_properties.partials.table', ['customers' => $customers])
    </div>
</div>
@endsection

@push('scripts')
<script>
    let searchTimeout;

    function debounceSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(loadTableData, 500);
    }

    function loadTableData(page = 1) {
        const limit = document.getElementById('limit-select').value;
        const search = document.getElementById('search-input').value;

        $.ajax({
            url: "{{ route('admin.random_properties.table') }}",
            data: { limit: limit, search: search, page: page },
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
@endpush
