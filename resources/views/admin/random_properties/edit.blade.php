@extends('admin.layouts.app')

@include('admin.customers.partials.form_styles')

@section('title', isset($selectedCustomer) ? 'Edit Random Property' : 'Add Random Property')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-between py-3 mb-3">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Management / Random Property /</span> 
            {{ isset($selectedCustomer) ? 'Edit' : 'Add' }}
        </h4>
        <a href="{{ route('admin.random_properties.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="form-card mb-5">
        <div class="form-card-header">
            <h5 class="form-card-title">{{ isset($selectedCustomer) ? 'Edit Random Property' : 'Add Random Property' }}</h5>
        </div>
        
        <div class="form-card-body">
            <form action="{{ route('admin.random_properties.store') }}" method="POST">
                @csrf
                
                <div class="row mb-4 align-items-center">
                    <div class="col-md-2">
                        <label class="form-label-premium mb-0">Customer Name</label>
                    </div>
                    <div class="col-md-10">
                        <select name="customer_id" class="form-select premium-select @error('customer_id') is-invalid @enderror" required {{ isset($selectedCustomer) ? 'readonly' : '' }}>
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

                <hr class="my-4" style="border-color: #f0f2f9;">

                <div id="properties-container">
                    @foreach($randomProperties as $index => $prop)
                    <div class="property-row row align-items-end mb-3">
                        <div class="col-md-3">
                            <label class="form-label-premium">Date</label>
                            <input type="date" name="properties[{{ $index }}][date]" class="form-control premium-input" value="{{ old('properties.'.$index.'.date', optional($prop->date)->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-premium">Property Name</label>
                            <input type="text" name="properties[{{ $index }}][property_name]" class="form-control premium-input" placeholder="Enter Property Name" value="{{ old('properties.'.$index.'.property_name', $prop->property_name) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-premium">Remark</label>
                            <input type="text" name="properties[{{ $index }}][remark]" class="form-control premium-input" placeholder="Enter Remark" value="{{ old('properties.'.$index.'.remark', $prop->remark) }}">
                        </div>
                        <div class="col-md-1">
                            @if($index === count($randomProperties) - 1)
                                <button type="button" class="btn btn-premium add-row-btn w-100 p-0" style="height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bx bx-plus"></i></button>
                            @else
                                <button type="button" class="btn btn-danger remove-row-btn w-100 p-0" style="height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px;"><i class="bx bx-trash"></i></button>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-5 pt-4 border-top" style="border-color: #f0f2f9 !important;">
                    <button type="submit" class="btn btn-premium px-5">{{ isset($selectedCustomer) ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('properties-container');
        const customerSelect = document.querySelector('select[name="customer_id"]');

        if (customerSelect && !customerSelect.hasAttribute('readonly')) {
            customerSelect.addEventListener('change', function() {
                const customerId = this.value;
                if (customerId) {
                    fetch(`{{ url('admin/random_properties/get-by-customer') }}/${customerId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                renderProperties(data.data);
                            }
                        })
                        .catch(err => console.error(err));
                } else {
                    renderProperties([]);
                }
            });
        }

        function renderProperties(properties) {
            container.innerHTML = '';
            
            if (!properties || properties.length === 0) {
                properties = [{ id: '', date: '', property_name: '', remark: '' }];
            }
            
            properties.forEach((prop, index) => {
                const isLast = index === properties.length - 1;
                const newRow = document.createElement('div');
                newRow.className = 'property-row row align-items-end mb-3';
                
                let dateVal = '';
                if (prop.date) {
                    const d = new Date(prop.date);
                    if (!isNaN(d.getTime())) {
                        dateVal = d.toISOString().split('T')[0];
                    }
                }
                
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <label class="form-label-premium">Date</label>
                        <input type="date" name="properties[${index}][date]" class="form-control premium-input" value="${dateVal}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium">Property Name</label>
                        <input type="text" name="properties[${index}][property_name]" class="form-control premium-input" placeholder="Enter Property Name" value="${prop.property_name || ''}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium">Remark</label>
                        <input type="text" name="properties[${index}][remark]" class="form-control premium-input" placeholder="Enter Remark" value="${prop.remark || ''}">
                    </div>
                    <div class="col-md-1">
                        ${isLast 
                            ? `<button type="button" class="btn btn-premium add-row-btn w-100 p-0" style="height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bx bx-plus"></i></button>`
                            : `<button type="button" class="btn btn-danger remove-row-btn w-100 p-0" style="height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px;"><i class="bx bx-trash"></i></button>`
                        }
                    </div>
                `;
                container.appendChild(newRow);
            });
        }

        container.addEventListener('click', function(e) {
            const addBtn = e.target.closest('.add-row-btn');
            const removeBtn = e.target.closest('.remove-row-btn');
            
            if (addBtn) {
                // Change current plus to trash
                addBtn.classList.remove('btn-premium', 'add-row-btn');
                addBtn.classList.add('btn-danger', 'remove-row-btn');
                addBtn.style.borderRadius = '8px';
                addBtn.innerHTML = '<i class="bx bx-trash"></i>';
                
                // Add new row with plus
                const rows = container.querySelectorAll('.property-row');
                const nextIndex = rows.length;
                
                const newRow = document.createElement('div');
                newRow.className = 'property-row row align-items-end mb-3';
                newRow.innerHTML = `
                    <div class="col-md-3">
                        <label class="form-label-premium">Date</label>
                        <input type="date" name="properties[${nextIndex}][date]" class="form-control premium-input" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium">Property Name</label>
                        <input type="text" name="properties[${nextIndex}][property_name]" class="form-control premium-input" placeholder="Enter Property Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-premium">Remark</label>
                        <input type="text" name="properties[${nextIndex}][remark]" class="form-control premium-input" placeholder="Enter Remark">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-premium add-row-btn w-100 p-0" style="height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bx bx-plus"></i></button>
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
@endsection
