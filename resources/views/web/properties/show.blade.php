@extends('web.layouts.app')
@section('content')
<!-- Page Header -->
<section class="bg-primary text-white py-4">
    <div class="container">
        <h1 class="fw-bold mb-1">{{$property->title}}</h1>
        <p class="lead mb-0 opacity-75"><i class="bx bx-map"></i> {{$property->location}}, {{$property->city}}</p>
    </div>
</section>

<!-- Detail -->
<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                @if($property->property_photo)
                    <img src="{{$property->property_photo}}" class="card-img-top rounded-top" alt="{{$property->title}}" style="max-height: 400px;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bx bx-buildings display-1 text-muted"></i>
                    </div>
                @endif
                <div class="card-body p-4">
                    <div class="mb-3">
                        <span class="badge bg-primary me-1">{{$property->property_type}}</span>
                        <span class="badge bg-secondary me-1">{{$property->property_category}}</span>
                        <span class="badge bg-success">{{ ucfirst($property->status) }}</span>
                    </div>
                    <h5 class="fw-bold mb-4">Property Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Price:</strong> <span class="text-primary fw-bold">₹{{ number_format($property->price) }}</span></p>
                            <p class="mb-1"><strong>Area Size:</strong> {{$property->area_size}} {{$property->area_unit}}</p>
                            <p class="mb-1"><strong>Plot Number:</strong> {{$property->plot_number ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Corner Plot:</strong> {{$property->corner_plot }}</p>
                            <p class="mb-1"><strong>City:</strong> {{$property->city}}</p>
                            <p class="mb-1"><strong>State:</strong> {{$property->state}}</p>
                        </div>
                    </div>
                    <hr>
                    <h6 class="fw-bold">Address</h6>
                    <p class="text-muted">{{$property->address}}</p>
                    <p class="mb-0"><strong>Pin Code:</strong> {{$property->pin_code}}</p>
                    @if($property->stamp_duty)
                        <p class="mb-0"><strong>Stamp Duty:</strong> ₹{{ number_format($property->stamp_duty) }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Sales Person</h5>
                </div>
                <div class="card-body p-4">
                    @if($property->salesPerson)
                        <h6 class="fw-bold">{{$property->salesPerson->name}}</h6>
                        <p class="mb-2 text-muted"><i class="bx bx-phone text-primary me-1"></i> {{$property->salesPerson->phone}}</p>
                        <p class="mb-0 text-muted"><i class="bx bx-envelope text-primary me-1"></i> {{$property->salesPerson->email}}</p>
                    @else
                        <p class="text-muted mb-0">Sales person information not available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedProperties->isNotEmpty())
<section class="bg-light py-5">
    <div class="container">
        <h3 class="fw-bold mb-4">Related Properties</h3>
        <div class="row g-4">
            @foreach($relatedProperties as $prop)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 shadow-sm border-0">
                    @if($prop->property_photo)
                        <img src="{{$prop->property_photo}}" class="card-img-top" alt="{{$prop->title}}" style="height: 150px;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                            <i class="bx bx-buildings display-4 text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ Str::limit($prop->title, 25) }}</h6>
                        <p class="price mb-1">₹{{ number_format($prop->price) }}</p>
                        <small class="text-muted"><i class="bx bx-map"></i> {{$prop->city}}</small>
                    </div>
                    <div class="card-footer bg-white border-top-0 pt-0">
                        <a href="{{ url('properties/' . $prop->id) }}" class="btn btn-sm btn-outline-primary w-100">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
