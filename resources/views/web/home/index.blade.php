@extends('web.layouts.app')
@section('content')
<!-- Hero Section -->
<section class="hero-gradient d-flex align-items-center">
    <div class="container text-center py-5">
        <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold mb-3" style="background-color: rgba(79, 70, 229, 0.1); font-size: 0.9rem; letter-spacing: 0.5px;">REAL ESTATE AGENCY</span>
        <h1 class="hero-title mb-3">Discover A Place You'll <br><span class="text-primary">Love To Live</span></h1>
        <p class="hero-subtitle mb-5">Explore a wide catalog of premium real estate options, curated with verified details and guided by elite agents.</p>
    </div>
</section>

<!-- Floating Search Console -->
<div class="container floating-search-console">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card glass-card p-4">
                <form action="{{ route('home') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-lg-4 col-md-12">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-0 pe-0 text-muted"><i class="bx bx-search fs-5"></i></span>
                                <input type="text" name="search" class="form-control border-0 bg-transparent shadow-none" placeholder="Search by location, type..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 border-start border-md-0 ps-lg-3">
                            <select name="type" class="form-select border-0 bg-transparent shadow-none">
                                <option value="">Property Type</option>
                                @foreach($types as $type)
                                    <option value="{{$type}}" {{ request('type') == $type ? 'selected' : '' }}>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 border-start border-md-0 ps-lg-3">
                            <select name="category" class="form-select border-0 bg-transparent shadow-none">
                                <option value="">Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category}}" {{ request('category') == $category ? 'selected' : '' }}>{{$category}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 border-start border-md-0 ps-lg-3">
                            <select name="city" class="form-select border-0 bg-transparent shadow-none">
                                <option value="">City</option>
                                @foreach($cities as $city)
                                    <option value="{{$city}}" {{ request('city') == $city ? 'selected' : '' }}>{{$city}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-2 col-md-12">
                            <button type="submit" class="btn btn-primary-gradient w-100 py-3">Find Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Properties Listings Section -->
<section class="py-5" style="margin-top: 50px;">
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5 gap-3">
            <div>
                <span class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px;">Recent Listings</span>
                <h2 class="fw-bold mb-0 mt-1">Available Properties</h2>
            </div>
            <span class="badge bg-light text-dark px-3 py-2 border rounded-pill">{{$properties->total()}} properties found</span>
        </div>
        
        @if($properties->isEmpty())
            <div class="text-center py-5 glass-card max-width-600 mx-auto">
                <i class="bx bx-folder-open display-1 text-muted mb-3"></i>
                <h4 class="text-muted fw-bold">No properties matched your criteria</h4>
                <p class="text-muted mb-4">Try clearing filters or checking other categories.</p>
                <a href="{{ route('home') }}" class="btn btn-primary-gradient">View All Listings</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($properties as $property)
                <div class="col-lg-4 col-md-6">
                    <div class="property-card">
                        <div class="card-img-wrapper">
                            @if($property->property_photo)
                                <img src="{{$property->property_photo}}" alt="{{$property->title}}">
                            @else
                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center">
                                    <i class="bx bx-buildings display-2 text-muted opacity-50"></i>
                                </div>
                            @endif
                            
                            <!-- Badges Overlay -->
                            <div class="badge-overlay">
                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill shadow-sm">{{$property->property_type}}</span>
                            </div>
                            <div class="badge-category">
                                <span class="badge bg-dark text-white px-3 py-2 rounded-pill shadow-sm">{{$property->property_category}}</span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <div class="d-flex align-items-center text-muted small mb-2">
                                <i class="bx bx-map me-1 text-primary"></i>
                                <span>{{$property->location}}, {{$property->city}}</span>
                            </div>
                            
                            <h5 class="fw-bold mb-3"><a href="{{ url('properties/' . $property->id) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($property->title, 36) }}</a></h5>
                            
                            <div class="row border-top border-bottom py-3 my-3 g-2 text-center text-muted small">
                                <div class="col-6 border-end">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-area fs-5 text-primary"></i>
                                        <span>{{ number_format($property->area_size, 0) }} {{$property->area_unit}}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-flex align-items-center justify-content-center gap-1">
                                        <i class="bx bx-check-shield fs-5 text-primary"></i>
                                        <span>{{ $property->corner_plot ? 'Corner Plot' : 'Regular Plot' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-2">
                                <div>
                                    <span class="text-muted small d-block">Price</span>
                                    <span class="price-tag">₹{{ number_format($property->price) }}</span>
                                </div>
                                <a href="{{ url('properties/' . $property->id) }}" class="btn btn-outline-custom px-3 py-2 btn-sm">View details</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-5 d-flex justify-content-center">
                {{ $properties->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
</section>

<!-- Why Choose Us & Stats -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="stats-section mb-5">
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <span class="stats-number">1,200+</span>
                    <h5 class="fw-bold text-white mt-2">Premium Listings</h5>
                    <p class="text-muted mb-0 small">High quality homes, flats & land parcels</p>
                </div>
                <div class="col-md-4">
                    <span class="stats-number">98%</span>
                    <h5 class="fw-bold text-white mt-2">Happy Clients</h5>
                    <p class="text-muted mb-0 small">Satisfied buyers, renters & sellers</p>
                </div>
                <div class="col-md-4">
                    <span class="stats-number">50+</span>
                    <h5 class="fw-bold text-white mt-2">Expert Specialists</h5>
                    <p class="text-muted mb-0 small">Ready to help you find the right match</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mb-5 max-width-600 mx-auto">
            <span class="text-primary fw-bold text-uppercase" style="letter-spacing: 1px;">Our Core Benefits</span>
            <h2 class="fw-bold mt-1">Why Choose Antigravity</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="icon-box text-center h-100">
                    <i class="bx bx-buildings"></i>
                    <h4 class="fw-bold mb-2">Verified Properties</h4>
                    <p class="text-muted">Every listing goes through manual checks to ensure accuracy of ownership details, title deeds and photos.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="icon-box text-center h-100">
                    <i class="bx bx-phone-call"></i>
                    <h4 class="fw-bold mb-2">Dedicated Experts</h4>
                    <p class="text-muted">Get assigned to professional sales agents who will consult you from selection to registry documentation.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="icon-box text-center h-100">
                    <i class="bx bx-lock-alt"></i>
                    <h4 class="fw-bold mb-2">Secure Transactions</h4>
                    <p class="text-muted">Benefit from streamlined paperwork, calculated stamp duties, and safe payment mechanisms.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
