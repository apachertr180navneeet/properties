<div class="form-card-body">
@csrf
@if($customer->exists)
    @method('PUT')
@endif

<!-- Personal Details -->
<div class="mb-5 pb-1" style="border-bottom: 1px solid #f5f6ff;">
    <div style="font-size: .85rem; font-weight: 700; color: #3b71ca; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 1.25rem; padding-bottom: .5rem; border-bottom: 2px solid #eef0ff;">
        Personal Details
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="name">Customer Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control premium-input @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" placeholder="Enter customer name">
            @error('name')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="phone">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" name="phone" id="phone" class="form-control premium-input @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}" placeholder="Enter mobile number">
            @error('phone')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="customer_phone_2">Phone 2</label>
            <input type="text" name="customer_phone_2" id="customer_phone_2" class="form-control premium-input @error('customer_phone_2') is-invalid @enderror" value="{{ old('customer_phone_2', $customer->customer_phone_2) }}" placeholder="Enter alternate phone number">
            @error('customer_phone_2')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="city">City</label>
            <input type="text" name="city" id="city" class="form-control premium-input @error('city') is-invalid @enderror" value="{{ old('city', $customer->city) }}" placeholder="Enter city">
            @error('city')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="via">Via</label>
            <input type="text" name="via" id="via" class="form-control premium-input @error('via') is-invalid @enderror" value="{{ old('via', $customer->via) }}" placeholder="Enter source">
            @error('via')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="customer_type">Type</label>
            <select name="customer_type" id="customer_type" class="form-select premium-select @error('customer_type') is-invalid @enderror">
                <option value="buyer" {{ old('customer_type', $customer->customer_type) === 'buyer' ? 'selected' : '' }}>Buyer</option>
                <option value="seller" {{ old('customer_type', $customer->customer_type) === 'seller' ? 'selected' : '' }}>Seller</option>
                <option value="both" {{ old('customer_type', $customer->customer_type) === 'both' ? 'selected' : '' }}>Both</option>
            </select>
            @error('customer_type')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="sales_person_id">Sales Person</label>
            <select name="sales_person_id" id="sales_person_id" class="form-select premium-select @error('sales_person_id') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach($salespersons as $salesperson)
                    <option value="{{ $salesperson->id }}" {{ (int) old('sales_person_id', $customer->sales_person_id) === $salesperson->id ? 'selected' : '' }}>{{ $salesperson->name }}</option>
                @endforeach
            </select>
            @error('sales_person_id')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Requirement & Visit -->
<div class="mb-5 pb-1" style="border-bottom: 1px solid #f5f6ff;">
    <div style="font-size: .85rem; font-weight: 700; color: #3b71ca; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 1.25rem; padding-bottom: .5rem; border-bottom: 2px solid #eef0ff;">
        Requirement & Visit
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="base_requirement">Base Requirement</label>
            <textarea name="base_requirement" id="base_requirement" class="form-control premium-input @error('base_requirement') is-invalid @enderror" rows="4" placeholder="Describe requirement">{{ old('base_requirement', $customer->base_requirement) }}</textarea>
            @error('base_requirement')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="visit_date">Visit Date</label>
            <input type="date" name="visit_date" id="visit_date" class="form-control premium-input @error('visit_date') is-invalid @enderror" value="{{ old('visit_date', optional($customer->visit_date)->format('Y-m-d')) }}">
            @error('visit_date')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Submit -->
<div class="d-flex gap-2 pt-1">
    <button type="submit" class="btn btn-premium">{{ $customer->exists ? 'Update Customer' : 'Create Customer' }}</button>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary" style="padding: .6rem 1.5rem; border-radius: 8px;">
        <i class="bx bx-x"></i> Cancel
    </a>
</div>

</div>