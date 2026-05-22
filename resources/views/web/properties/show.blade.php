@extends('web.layouts.app')
@section('content')
<section class='bg-primary text-white py-5'>
    <div class='container py-4'>
        <div class='row'>
            <div class='col'>
                <h1 class='display-5 fw-bold'>{{$property->title}}</h1>
                <p class='lead'>{{$property->location}}, {{$property->city}}</p>
            </div>
        </div>
    </div>
</section>

<section class='py-5'>
    <div class='container'>
        <div class='row g-4'>
            <div class='col-lg-8'>
                <div class='card border-0 shadow-sm mb-4'>
                    @if($property->property_photo)
                        <img src='{{$property->property_photo}}' class='img-fluid rounded-top' alt='{{$property->title}}' style='max-height: 400px; width: 100%; object-fit: cover;'>
                    @else
                        <div class='bg-light d-flex align-items-center justify-content-center rounded-top' style='height: 400px;'>
                            <i class='bx bx-buildings display-1 text-muted'></i>
                        </div>
                    @endif
                    <div class='card-body'>
                        <div class='d-flex gap-2 mb-3'>
                            <span class='badge bg-primary'>{{$property->property_type}}</span>
                            <span class='badge bg-secondary'>{{$property->property_category}}</span>
                            <span class='badge bg-success'>{{ ucfirst($property->status) }}</span>
                        </div>
                        <h5 class='card-title'>Property Details</h5>
                        <div class='row g-3'>
                            <div class='col-md-6'>
                                <p class='mb-1'><strong>Price:</strong> <span class='text-primary'>₹{{ number_format($property->price) }}</span></p>
                                <p class='mb-1'><strong>Area Size:</strong> {{$property->area_size}} {{$property->area_unit}}</p>
                                <p class='mb-1'><strong>Plot Number:</strong> {{$property->plot_number ?? 'N/A' }}</p>
                            </div>
                            <div class='col-md-6'>
                                <p class='mb-1'><strong>Corner Plot:</strong> {{$property->corner_plot }}</p>
                                <p class='mb-1'><strong>City:</strong> {{$property->city}}</p>
                                <p class='mb-1'><strong>State:</strong> {{$property->state}}</p>
                            </div>
                        </div>
                        <hr>
                        <h6>Address</h6>
                        <p>{{$property->address}}</p>
                        <p class='mb-0'><strong>Pin Code:</strong> {{$property->pin_code}}</p>
                        @if($property->stamp_duty)
                            <p class='mb-0'><strong>Stamp Duty:</strong> ₹{{ number_format($property->stamp_duty) }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class='col-lg-4'>
                <div class='card border-0 shadow-sm mb-4'>
                    <div class='card-header bg-primary text-white'>
                        <h5 class='mb-0'>Sales Person</h5>
                    </div>
                    <div class='card-body'>
                        @if($property->salesPerson)
                            <h6>{{$property->salesPerson->name}}</h6>
                            <p class='mb-1'><i class='bx bx-phone'></i> {{$property->salesPerson->phone}}</p>
                            <p class='mb-0'><i class='bx bx-envelope'></i> {{$property->salesPerson->email}}</p>
                        @else
                            <p class='text-muted'>Sales person information not available</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if($relatedProperties->isNotEmpty())
<section class='bg-light py-5'>
    <div class='container'>
        <h3 class='fw-bold mb-4'>Related Properties</h3>
        <div class='row g-4'>
            @foreach($relatedProperties as $prop)
            <div class='col-lg-3 col-md-6'>
                <div class='card h-100 border-0 shadow-sm'>
                    @if($prop->property_photo)
                        <img src='{{$prop->property_photo}}' class='card-img-top' alt='{{$prop->title}}' style='height: 150px; object-fit: cover;'>
                    @else
                        <div class='card-img-top bg-light d-flex align-items-center justify-content-center' style='height: 150px;'>
                            <i class='bx bx-buildings display-4 text-muted'></i>
                        </div>
                    @endif
                    <div class='card-body'>
                        <h6 class='card-title'>{{ Str::limit($prop->title, 25) }}</h6>
                        <p class='text-primary mb-1'>₹{{ number_format($prop->price) }}</p>
                        <small class='text-muted'>{{$prop->city}}</small>
                    </div>
                    <div class='card-footer bg-white border-0'>
                        <a href='{{ url('properties/' . $prop->id) }}' class='btn btn-sm btn-outline-primary w-100'>View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
