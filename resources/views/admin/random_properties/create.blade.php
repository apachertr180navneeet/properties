@extends('admin.layouts.app')

@section('title', isset($selectedCustomer) ? 'Edit Random Property' : 'Add Random Property')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">{{ isset($selectedCustomer) ? 'Edit Random Property' : 'Add Random Property' }}</h4>
    <a href="{{ route('admin.random_properties.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
        <i class="bx bx-arrow-back"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">
        <form action="{{ route('admin.random_properties.store') }}" method="POST">
            @csrf
            
            <div class="row mb-4 align-items-center">
                <div class="col-md-2">
                    <label class="form-label mb-0 fw-semibold">Customer Name</label>
                </div>
                <div class="col-md-10">
                    <select name="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required {{ isset($selectedCustomer) ? 'readonly' : '' }}>
                        <option value="">Select Customer Name</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ (isset($selectedCustomer) && $selectedCustomer->id == $customer->id) ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div id="properties-container">
                @foreach($randomProperties as $index => $prop)
                <div class="property-row row align-items-end mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="properties[{{ $index }}][date]" class="form-control" value="{{ old('properties.'.$index.'.date', optional($prop->date)->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Property Name</label>
                        <input type="text" name="properties[{{ $index }}][property_name]" class="form-control" placeholder="Enter Property Name" value="{{ old('properties.'.$index.'.property_name', $prop->property_name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Remark</label>
                        <input type="text" name="properties[{{ $index }}][remark]" class="form-control" placeholder="Enter Remark" value="{{ old('properties.'.$index.'.remark', $prop->remark) }}">
                    </div>
                    <div class="col-md-1">
                        @if($index === count($randomProperties) - 1)
                            <button type="button" class="btn btn-primary add-row-btn w-100"><i class="bx bx-plus"></i></button>
                        @else
                            <button type="button" class="btn btn-danger remove-row-btn w-100"><i class="bx bx-trash"></i></button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2">{{ isset($selectedCustomer) ? 'Update' : 'Save' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('properties-container');
        
        container.addEventListener('click', function(e) {
            const addBtn = e.target.closest('.add-row-btn');
            const removeBtn = e.target.closest('.remove-row-btn');
            
            if (addBtn) {
                // Change current plus to trash
                addBtn.classList.remove('btn-primary', 'add-row-btn');
                addBtn.classList.add('btn-danger', 'remove-row-btn');
                addBtn.innerHTML = '<i class="bx bx-trash"></i>';
                
                // Add new row with plus
                const rows = container.querySelectorAll('.property-row');
                const nextIndex = rows.length;
                
                const newRow = document.createElement('div');
                newRow.className = 'property-row row align-items-end mb-3';
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input type="date" name="properties[${nextIndex}][date]" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Property Name</label>
                        <input type="text" name="properties[${nextIndex}][property_name]" class="form-control" placeholder="Enter Property Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Remark</label>
                        <input type="text" name="properties[${nextIndex}][remark]" class="form-control" placeholder="Enter Remark">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-primary add-row-btn w-100"><i class="bx bx-plus"></i></button>
                    </div>
                `;
                container.appendChild(newRow);
            }
            
            if (removeBtn) {
                // Prevent removing if it's the only row
                if (container.querySelectorAll('.property-row').length > 1) {
                    removeBtn.closest('.property-row').remove();
                } else {
                    alert("You must have at least one property row.");
                }
            }
        });
    });
</script>
@endpush
