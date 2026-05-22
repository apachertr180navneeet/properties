@extends('web.layouts.app')
@section('content')
<!-- Hero Section -->
<section class='bg-primary text-white py-5'>
    <div class='container py-4'>
        <div class='row justify-content-center'>
            <div class='col-lg-8 text-center'>
                <h1 class='display-4 fw-bold mb-3'>Find Your Dream Property</h1>
                <p class='lead mb-4'>Discover the best properties in your area with our comprehensive listings</p>
                
                <!-- Search Form -->
                <form action='{{ route('home') }}' method='GET' class='bg-white p-4 rounded shadow-sm'>
                    <div class='row g-3'>
                        <div class='col-md-4'>
                            <input type='text' name='search' class='form-control' placeholder='Location, Property Type...' value='{{ request('search') }}'>
                        </div>
                        <div class='col-md-2'>
                            <select name='type' class='form-select'>
                                <option value=''>Property Type</option>
                                @foreach($types as $type)
                                    <option value='{{$type}}' {{ request('type') == $type ? 'selected' : '' }}>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-2'>
                            <select name='category' class='form-select'>
                                <option value=''>Category</option>
                                @foreach($categories as $category)
                                    <option value='{{$category}}' {{ request('category') == $category ? 'selected' : '' }}>{{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-2'>
                            <select name='city' class='form-select'>
                                <option value=''>City</option>
                                @foreach($cities as $city)
                                    <option value='{{$city}}' {{ request('city') == $city ? 'selected' : '' }}>{{$city}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class='col-md-2'>
                            <button type='submit' class='btn btn-primary w-100'>Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Properties Section -->
<section class='py-5'>
    <div class='container'>
        <div class='d-flex justify-content-between align-items-center mb-4'>
            <h2 class='fw-bold'>Available Properties</h2>
            <span class='text-muted'>{{$properties->total()}} properties found</span>
        </div>
        
        @if($properties->isEmpty())
            <div class='text-center py-5'>
                <h4 class='text-muted'>No properties found matching your criteria</h4>
                <a href='{{ route('home') }}' class='btn btn-outline-primary mt-3'>View All Properties</a>
            </div>
        @else
            <div class='row g-4'>
                @foreach($properties as $property)
                <div class='col-lg-4 col-md-6'>
                    <div class='card h-100 shadow-sm border-0'>
                        @if($property->property_photo)
                            <img src='{{$property->property_photo}}' class='card-img-top' alt='{{$property->title}}' style='height: 200px; object-fit: cover;'>
                        @else
                            <div class='card-img-top bg-light d-flex align-items-center justify-content-center' style='height: 200px;'>
                                <i class='bx bx-buildings display-1 text-muted'></i>
                            </div>
                        @endif
                        <div class='card-body'>
                            <div class='d-flex justify-content-between mb-2'>
                                <span class='badge bg-primary'>{{$property->property_type}}</span>
                                <span class='badge bg-secondary'>{{$property->property_category}}</span>
                            </div>
                            <h5 class='card-title'>{{ Str::limit($property->title, 30) }}</h5>
                            <p class='text-muted small mb-2'>
                                <i class='bx bx-map'></i> {{$property->location}}, {{$property->city}}
                            </p>
                            <div class='d-flex justify-content-between align-items-center'>
                                <h5 class='text-primary mb-0'>₹{{ number_format($property->price) }}</h5>
                                <small class='text-muted'>{{$property->area_size}} {{$property->area_unit}}</small>
                            </div>
                            @if($property->salesPerson)
                                <p class='text-muted small mt-2 mb-0'>
                                    <i class='bx bx-user'></i> {{$property->salesPerson->name}}
                                </p>
                            @endif
                        </div>
                        <div class='card-footer bg-white border-0'>
                            <a href='{{ url('properties/' . $property->id) }}' class='btn btn-outline-primary w-100'>View Details</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class='mt-5'>
                {{ $properties->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class='bg-light py-5'>
    <div class='container'>
        <div class='row text-center'>
            <div class='col-md-4 mb-4'>
                <div class='card border-0 bg-transparent'>
                    <div class='card-body'>
                        <i class='bx bx-building-house display-3 text-primary'></i>
                        <h5 class='mt-3'>Verified Properties</h5>
                        <p class='text-muted'>All properties are verified by our team</p>
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-4'>
                <div class='card border-0 bg-transparent'>
                    <div class='card-body'>
                        <i class='bx bx-support display-3 text-primary'></i>
                        <h5 class='mt-3'>24/7 Support</h5>
                        <p class='text-muted'>Our team is always ready to help you</p>
                    </div>
                </div>
            </div>
            <div class='col-md-4 mb-4'>
                <div class='card border-0 bg-transparent'>
                    <div class='card-body'>
                        <i class='bx bx-shield display-3 text-primary'></i>
                        <h5 class='mt-3'>Secure Transactions</h5>
                        <p class='text-muted'>Safe and secure property transactions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
