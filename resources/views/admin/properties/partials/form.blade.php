@csrf
@if($property->exists)
    @method('PUT')
@endif

<!-- Basic Information -->
<div class="form-section">
    <div class="form-section-title">Basic Information</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="title">Property Name <span class="text-danger">*</span></label>
            <input type="text" name="title" id="title" class="form-control premium-input @error('title') is-invalid @enderror" value="{{ old('title', $property->title) }}" placeholder="Enter property name">
            @error('title')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="owner_name">Owner Name</label>
            <input type="text" name="owner_name" id="owner_name" class="form-control premium-input @error('owner_name') is-invalid @enderror" value="{{ old('owner_name', $property->owner_name) }}" placeholder="Enter owner name">
            @error('owner_name')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="owner_phone">Owner Phone</label>
            <input type="text" name="owner_phone" id="owner_phone" class="form-control premium-input @error('owner_phone') is-invalid @enderror" value="{{ old('owner_phone', $property->owner_phone) }}" placeholder="Enter owner phone">
            @error('owner_phone')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="property_type">Property Type</label>
            <input type="text" name="property_type" id="property_type" class="form-control premium-input @error('property_type') is-invalid @enderror" value="{{ old('property_type', $property->property_type) }}" placeholder="direct, 1 broker, 2 broker">
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
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="build_type">Build Type</label>
            <select name="build_type" id="build_type" class="form-select premium-select @error('build_type') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach(['Plot', 'Villa'] as $bt)
                    <option value="{{ $bt }}" {{ old('build_type', $property->build_type) === $bt ? 'selected' : '' }}>{{ $bt }}</option>
                @endforeach
            </select>
            @error('build_type')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label form-label-premium" for="property_condition">Property Condition</label>
            <select name="property_condition" id="property_condition" class="form-select premium-select @error('property_condition') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach(['Used', 'Unused'] as $pc)
                    <option value="{{ $pc }}" {{ old('property_condition', $property->property_condition) === $pc ? 'selected' : '' }}>{{ $pc }}</option>
                @endforeach
            </select>
            @error('property_condition')<span class="error-text">{{ $message }}</span>@enderror
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

<!-- Size & Facing -->
<div class="form-section">
    <div class="form-section-title">Size & Facing</div>
    <div class="row g-3">
        <div class="col">
            <label class="form-label form-label-premium" for="length">Length</label>
            <input type="number" step="0.01" min="0" name="length" id="length" class="form-control premium-input @error('length') is-invalid @enderror" value="{{ old('length', $property->length) }}" placeholder="L">
            @error('length')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="size_separator">X</label>
            <input type="number" step="0.01" min="0" name="size_separator" id="size_separator" class="form-control premium-input @error('size_separator') is-invalid @enderror" value="{{ old('size_separator', is_numeric($property->size_separator) ? $property->size_separator : '') }}" placeholder="X">
            @error('size_separator')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="width">Width</label>
            <input type="number" step="0.01" min="0" name="width" id="width" class="form-control premium-input @error('width') is-invalid @enderror" value="{{ old('width', $property->width) }}" placeholder="W">
            @error('width')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="area_unit">Unit</label>
            <select name="area_unit" id="area_unit" class="form-select premium-select @error('area_unit') is-invalid @enderror">
                @foreach(['Sq.ft', 'Sq.yard', 'Bigha', 'Acre'] as $unit)
                    <option value="{{ $unit }}" {{ old('area_unit', $property->area_unit ?? 'Sq.ft') === $unit ? 'selected' : '' }}>{{ $unit }}</option>
                @endforeach
            </select>
            @error('area_unit')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="area_size">Area Size <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" name="area_size" id="area_size" class="form-control premium-input @error('area_size') is-invalid @enderror" value="{{ old('area_size', $property->area_size) }}" placeholder="e.g. 900">
            @error('area_size')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="facing">Facing</label>
            <select name="facing" id="facing" class="form-select premium-select @error('facing') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach(['East', 'West', 'North', 'South'] as $f)
                    <option value="{{ $f }}" {{ old('facing', $property->facing) === $f ? 'selected' : '' }}>{{ $f }}</option>
                @endforeach
            </select>
            @error('facing')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col">
            <label class="form-label form-label-premium" for="corner_plot">Corner Plot</label>
            <select name="corner_plot" id="corner_plot" class="form-select premium-select @error('corner_plot') is-invalid @enderror">
                <option value="Yes" {{ old('corner_plot', $property->corner_plot ?? 'No') === 'Yes' ? 'selected' : '' }}>Yes</option>
                <option value="No" {{ old('corner_plot', $property->corner_plot ?? 'No') === 'No' ? 'selected' : '' }}>No</option>
            </select>
            @error('corner_plot')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Pricing -->
<div class="form-section">
    <div class="form-section-title">Pricing</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="price">Full Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" name="price" id="price" class="form-control premium-input @error('price') is-invalid @enderror" value="{{ old('price', $property->price) }}" placeholder="e.g. 5000000">
            @error('price')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="sq_yard_rate">Sq. Yard Rate</label>
            <input type="number" step="0.01" min="0" name="sq_yard_rate" id="sq_yard_rate" class="form-control premium-input @error('sq_yard_rate') is-invalid @enderror" value="{{ old('sq_yard_rate', $property->sq_yard_rate) }}" placeholder="e.g. 50000">
            @error('sq_yard_rate')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="stamp_duty">Stamp Duty</label>
            <input type="number" step="0.01" min="0" name="stamp_duty" id="stamp_duty" class="form-control premium-input @error('stamp_duty') is-invalid @enderror" value="{{ old('stamp_duty', $property->stamp_duty) }}" placeholder="e.g. 50000">
            @error('stamp_duty')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Property Details -->
<div class="form-section">
    <div class="form-section-title">Property Details</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="construction_type">Construction Type</label>
            <select name="construction_type" id="construction_type" class="form-select premium-select @error('construction_type') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach(['New', 'Old'] as $ct)
                    <option value="{{ $ct }}" {{ old('construction_type', $property->construction_type) === $ct ? 'selected' : '' }}>{{ $ct }}</option>
                @endforeach
            </select>
            @error('construction_type')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="property_age">Property Age</label>
            <input type="text" name="property_age" id="property_age" class="form-control premium-input @error('property_age') is-invalid @enderror" value="{{ old('property_age', $property->property_age) }}" placeholder="e.g. 5 years">
            @error('property_age')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="setup_type">Setup Type</label>
            <select name="setup_type" id="setup_type" class="form-select premium-select @error('setup_type') is-invalid @enderror">
                <option value="">— Select —</option>
                @foreach(['Fully Furnished', 'Semi Furnished', 'Maintained'] as $st)
                    <option value="{{ $st }}" {{ old('setup_type', $property->setup_type) === $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
            @error('setup_type')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="add_on_date">Add On Date</label>
            <input type="date" name="add_on_date" id="add_on_date" class="form-control premium-input @error('add_on_date') is-invalid @enderror" value="{{ old('add_on_date', $property->add_on_date ?? date('Y-m-d')) }}">
            @error('add_on_date')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Additional Info -->
<div class="form-section">
    <div class="form-section-title">Additional Info</div>
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="via">Via</label>
            <input type="text" name="via" id="via" class="form-control premium-input @error('via') is-invalid @enderror" value="{{ old('via', $property->via) }}" placeholder="e.g. Direct, Reference">
            @error('via')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="plot_number">Plot Number</label>
            <input type="text" name="plot_number" id="plot_number" class="form-control premium-input @error('plot_number') is-invalid @enderror" value="{{ old('plot_number', $property->plot_number) }}" placeholder="e.g. A-12">
            @error('plot_number')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label form-label-premium" for="registry_owner">Registry Owner</label>
            <input type="text" name="registry_owner" id="registry_owner" class="form-control premium-input @error('registry_owner') is-invalid @enderror" value="{{ old('registry_owner', $property->registry_owner) }}" placeholder="Owner, Power of attorney etc..">
            @error('registry_owner')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        <div class="col-12">
            <label class="form-label form-label-premium" for="remarks">Remarks</label>
            <textarea name="remarks" id="remarks" rows="3" class="form-control premium-input @error('remarks') is-invalid @enderror" placeholder="Enter any remarks">{{ old('remarks', $property->remarks) }}</textarea>
            @error('remarks')<span class="error-text">{{ $message }}</span>@enderror
        </div>
    </div>
</div>

<!-- Assignment & Documents -->
<div class="form-section">
    <div class="form-section-title">Assignment & Documents</div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label form-label-premium" for="sales_person_ids">Sales Persons</label>
            <select name="sales_person_ids[]" id="sales_person_ids" class="form-select premium-select @error('sales_person_ids') is-invalid @enderror" multiple>
                @foreach($salespersons as $sp)
                    <option value="{{ $sp->id }}" @if(in_array($sp->id, old('sales_person_ids', $property->exists ? $property->salesPersons->pluck('id')->toArray() : []))) selected @endif>{{ $sp->name }}</option>
                @endforeach
            </select>
            @error('sales_person_ids')<span class="error-text">{{ $message }}</span>@enderror
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
