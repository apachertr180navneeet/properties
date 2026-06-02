@extends('web.layouts.app')
@section('content')
<!-- About -->
<section class="about-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-image">
                    <img src="{{ asset('assets/web/img/about-image.jpg') }}" alt="About Us" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <h2>Experienced &amp; quality roofing services providers</h2>
                    <p>
                        Nulla commodo dolor massa, vel pellentesque nulla congue quis. 
                        Fusce ut convallis diam. Nam id tortor et nunc tempor faucibus. 
                        Sed eu leo egestas, imperdiet felis sed, vestibulum ligula.
                    </p>
                    <ul class="list-unstyled about-features">
                        <li><i class="bx bx-check-circle me-2"></i> Innovative work</li>
                        <li><i class="bx bx-check-circle me-2"></i> Certified company</li>
                    </ul>
                    <a href="{{ url('/contact') }}" class="btn btn-primary mt-4">Get Free Quote</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quality Materials -->
<section class="quality-section bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="quality-content">
                    <h2>Quality materials</h2>
                    <p>Nullam neque augue, maximus id nulla id, dignissim tristique nunc.</p>
                    <a href="{{ url('/about') }}" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="quality-image">
                    <img src="{{ asset('assets/web/img/quality-image.jpg') }}" alt="Quality Materials" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Professional Workers -->
<section class="workers-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-lg-2">
                <div class="workers-image">
                    <img src="{{ asset('assets/web/img/workers-image.jpg') }}" alt="Professional Workers" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6 order-lg-1">
                <div class="workers-content">
                    <h2>Professional workers</h2>
                    <p>Nullam neque augue, maximus id nulla id, dignissim tristique nunc.</p>
                    <a href="{{ url('/team') }}" class="btn btn-outline-primary">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Free Estimates -->
<section class="estimates-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="estimates-image">
                    <img src="{{ asset('assets/web/img/estimates-image.jpg') }}" alt="Free Estimates" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="estimates-content">
                    <h2>Free estimates</h2>
                    <p>Nullam neque augue, maximus id nulla id, dignissim tristique nunc.</p>
                    <a href="{{ url('/contact') }}" class="btn btn-light mt-3">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Satisfied Customers -->
<section class="satisfied-section text-center py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="satisfied-content">
                    <div class="counter">
                        <span>00</span>
                        <span>%</span>
                    </div>
                    <h3>Satisfied customers</h3>
                    <p>roofing</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection