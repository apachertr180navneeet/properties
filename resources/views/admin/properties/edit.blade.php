@extends('admin.layouts.app')

@include('admin.properties.partials.form_styles')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-between py-3 mb-3">
        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Management / Properties /</span> Edit</h4>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="form-card mb-5">
        <div class="form-card-header">
            <h5 class="form-card-title">Edit Property</h5>
        </div>
        <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
            @include('admin.properties.partials.form')
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('#location').select2({
        placeholder: '— Select —',
        allowClear: true,
        width: '100%'
    });
    $('#sales_person_ids').select2({
        placeholder: '— Select Sales Person —',
        allowClear: true,
        width: '100%'
    });
    $('#owner_name').select2({
        placeholder: '— Select Seller —',
        allowClear: true,
        width: '100%'
    }).on('change', function() {
        var phone = $(this).find(':selected').data('phone') || '';
        $('#owner_phone').val(phone);
    });
</script>
@endsection
