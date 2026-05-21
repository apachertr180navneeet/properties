@csrf
@if($property->exists)
    @method('PUT')
@endif

<!-- Basic Information -->
<div class="form-section">
    <div class="form-section-title">Basic Information</div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="title">Property Name <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control premium-input @error('title') is-invalid @enderror" value="{{ old('title', $property->title) }}" placeholder="Enter property name">
            @error('title')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="property_type">Type <span class="text-danger">*</span></label>
            <select name="property_type" id="property_type" class="form-select premium-select @error('property_type') is-invalid @enderror">
                @foreach(['Plot', 'Flat', 'Villa'] as $type)
                    <option value="{{ $type }}" {{ old('property_type', $property->property_type ?? 'Plot') === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            @error('property_type')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="property_category">Category <span class="text-danger">*</span></label>
            <select name="property_category" id="property_category" class="form-select premium-select @error('property_category') is-invalid @enderror">
                @foreach(['Residential', 'Commercial'] as $cat)
                    <option value="{{ $cat }}" {{ old('property_category', $property->property_category ?? 'Residential') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                @endforeach
            </select>
            @error('property_category')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Location Details -->
<div class="form-section">
    <div class="form-section-title">Location Details</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="city">City <span class="text-danger">*</span></label>
            <input type="text" name="city" id="city" class="form-control premium-input @error('city') is-invalid @enderror" value="{{ old('city', $property->city) }}" placeholder="Enter city">
            @error('city')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="state">State <span class="text-danger">*</span></label>
            <input type="text" name="state" id="state" class="form-control premium-input @error('state') is-invalid @enderror" value="{{ old('state', $property->state) }}" placeholder="Enter state">
            @error('state')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="pin_code">Pin Code <span class="text-danger">*</span></label>
            <input type="text" name="pin_code" id="pin_code" class="form-control premium-input @error('pin_code') is-invalid @enderror" value="{{ old('pin_code', $property->pin_code) }}" placeholder="Enter pin code">
            @error('pin_code')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="location">Location <span class="text-danger">*</span></label>
            <select name="location" id="location" class="form-select premium-select @error('location') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach($areas as $area)
                    <option value="{{ $area->area_name }}" {{ old('location', $property->location) === $area->area_name ? 'selected' : '' }}>{{ $area->area_name }}</option>
                @endforeach
            </select>
            @error('location')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="address">Address <span class="text-danger">*</span></label>
            <input type="text" name="address" id="address" class="form-control premium-input @error('address') is-invalid @enderror" value="{{ old('address', $property->address) }}" placeholder="Enter full address">
            @error('address')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Area & Pricing -->
<div class="form-section">
    <div class="form-section-title">Area & Pricing Details</div>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="plot_number">Plot Number</label>
            <input type="text" name="plot_number" id="plot_number" class="form-control premium-input @error('plot_number') is-invalid @enderror" value="{{ old('plot_number', $property->plot_number) }}" placeholder="e.g. A-12">
            @error('plot_number')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="area_size">Area Size <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" name="area_size" id="area_size" class="form-control premium-input @error('area_size') is-invalid @enderror" value="{{ old('area_size', $property->area_size) }}" placeholder="e.g. 1500">
            @error('area_size')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="area_unit">Area Unit <span class="text-danger">*</span></label>
            <select name="area_unit" id="area_unit" class="form-select premium-select @error('area_unit') is-invalid @enderror">
                @foreach(['Sq.ft', 'Sq.yard', 'Bigha', 'Acre'] as $unit)
                    <option value="{{ $unit }}" {{ old('area_unit', $property->area_unit ?? 'Sq.ft') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
            @error('area_unit')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="corner_plot">Corner Plot</label>
            <select name="corner_plot" id="corner_plot" class="form-select premium-select @error('corner_plot') is-invalid @enderror">
                <option value="Yes" {{ old('corner_plot', $property->corner_plot ?? 'No') === 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('corner_plot', $property->corner_plot ?? 'No') === 'No' ? 'selected' : '' }}>No</option>
            </select>
            @error('corner_plot')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="price">Property Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" name="price" id="price" class="form-control premium-input @error('price') is-invalid @enderror" value="{{ old('price', $property->price) }}" placeholder="e.g. 5000000">
            @error('price')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="stamp_duty">Stamp Duty</label>
            <input type="number" step="0.01" min="0" name="stamp_duty" id="stamp_duty" class="form-control premium-input @error('stamp_duty') is-invalid @enderror" value="{{ old('stamp_duty', $property->stamp_duty) }}" placeholder="e.g. 50000">
            @error('stamp_duty')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Assignment & Documents -->
<div class="form-section">
    <div class="form-section-title">Assignment & Documents</div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="sales_person_id">Sales Person <span class="text-danger">*</span></label>
            <select name="sales_person_id" id="sales_person_id" class="form-select premium-select @error('sales_person_id') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach($salespersons as $sp)
                    <option value="{{ $sp->id }}" {{ (int) old('sales_person_id', $property->sales_person_id) === $sp->id ? 'selected' : '' }}>{{ $sp->name }}</option>
                @endforeach
            </select>
            @error('sales_person_id')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="property_photo">Property Photo</label>
            <input type="file" name="property_photo" id="property_photo" class="form-control premium-input @error('property_photo') is-invalid @enderror" accept="image/*">
            @error('property_photo')<span class="error-text">{{ $message }}</span>@enderror
            @if($property->property_photo)
                <div class="mt-2">
                    <img src="{{ $property->property_photo }}" alt="Property Photo" class="rounded" style="max-width: 140px; max-height: 100px; object-fit: cover; border: 1px solid #e4e6fc;">
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="registry_document">Registry Document</label>
            <input type="file" name="registry_document" id="registry_document" class="form-control premium-input @error('registry_document') is-invalid @enderror" accept=".pdf,image/*">
            @error('registry_document')<span class="error-text">{{ $message }}</span>@enderror
            @if($property->registry_document)
                <div class="mt-2">
                    @if(pathinfo($property->registry_document, PATHINFO_EXTENSION) === 'pdf')
                        <a href="{{ $property->registry_document }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-file"></i> View PDF
                        </a>
                    @else
                        <img src="{{ $property->registry_document }}" alt="Registry Document" class="rounded" style="max-width: 140px; max-height: 100px; object-fit: cover; border: 1px solid #e4e6fc;">
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Submit -->
<div class="form-section">
    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-premium">{{ $property->exists ? 'Update Property' : 'Create Property' }}</button>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary" style="padding: .6rem 1.5rem; border-radius: 8px;">
            <i class="bx bx-x"></i> Cancel
        </a>
    </div>
</div>