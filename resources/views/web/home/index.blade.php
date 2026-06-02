@extends('web.layouts.app')
@section('content')
<!-- Hero -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content">
                    <h1>Reliable Roofing &amp; Fixing Services</h1>
                    <p class="lead">
                        We provide a variety of roofing and maintenance services for<br>
                        all type of house makes happy.
                    </p>
                    <a href="{{ url('/about') }}" class="btn btn-primary me-3">Discover more</a>
                    <a href="{{ url('/contact') }}" class="btn btn-outline-secondary">Free estimate</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="{{ asset('assets/web/img/hero-image.jpg') }}" alt="Roofing Services" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services -->
<section class="services-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Our services</h2>
            <p>We’re providing quality roofing services</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-item text-center">
                    <img src="{{ asset('assets/web/img/service-1.jpg') }}" alt="Single play roofing" class="img-fluid mb-3">
                    <h3><a href="{{ url('/single-play-roofing') }}">Single play roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/single-play-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-item text-center">
                    <img src="{{ asset('assets/web/img/service-2.jpg') }}" alt="Modified roofing" class="img-fluid mb-3">
                    <h3><a href="{{ url('/modified-roofing') }}">Modified roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/modified-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-item text-center">
                    <img src="{{ asset('assets/web/img/service-3.jpg') }}" alt="Built-up roofing" class="img-fluid mb-3">
                    <h3><a href="{{ url('/built-up-roofing') }}">Built-up roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/built-up-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About -->
<section class="about-section bg-light py-5">
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
                    <a href="{{ url('/about') }}" class="btn btn-primary mt-4">Discover more</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose-us-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Why choose us</h2>
            <p>Few reasons to choose our company</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bx bx-building-house"></i>
                    </div>
                    <h3>Quality materials</h3>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute aboris nisi ut aliquip ex irure reprehederit.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bx bx-shield"></i>
                    </div>
                    <h3>Fully insured</h3>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute aboris nisi ut aliquip ex irure reprehederit.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bx bx-badge-check"></i>
                    </div>
                    <h3>Mission statement</h3>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute aboris nisi ut aliquip ex irure reprehederit.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-item text-center">
                    <div class="feature-icon">
                        <i class="bx bx-user"></i>
                    </div>
                    <h3>Expert engineers</h3>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute aboris nisi ut aliquip ex irure reprehederit.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Projects -->
<section class="projects-section py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Latest Projects</h2>
            <p>Explore our latest projects for your inspiration</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-1.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-2.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-3.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-4.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section bg-light py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>What they’re talking about us</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="testimonial-item">
                    <img src="{{ asset('assets/web/img/testimonial-1.jpg') }}" alt="Testimonial" class="img-fluid mb-3">
                    <h3>Jessica Brown</h3>
                    <p class="text-muted">CEO - Co Founder</p>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea ex commodo consequat duis aute aboris nisi ut aliquip irure reprehederit in voluptate velit esse .</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="testimonial-item">
                    <img src="{{ asset('assets/web/img/testimonial-2.jpg') }}" alt="Testimonial" class="img-fluid mb-3">
                    <h3>David Cooper</h3>
                    <p class="text-muted">CEO - Co Founder</p>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea ex commodo consequat duis aute aboris nisi ut aliquip irure reprehederit in voluptate velit esse .</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="testimonial-item">
                    <img src="{{ asset('assets/web/img/testimonial-3.jpg') }}" alt="Testimonial" class="img-fluid mb-3">
                    <h3>Kevin Martin</h3>
                    <p class="text-muted">CEO - Co Founder</p>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea ex commodo consequat duis aute aboris nisi ut aliquip irure reprehederit in voluptate velit esse .</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="testimonial-item">
                    <img src="{{ asset('assets/web/img/testimonial-4.jpg') }}" alt="Testimonial" class="img-fluid mb-3">
                    <h3>Mike Hardson</h3>
                    <p class="text-muted">CEO - Co Founder</p>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea ex commodo consequat duis aute aboris nisi ut aliquip irure reprehederit in voluptate velit esse .</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="cta-content">
                    <img src="{{ asset('assets/web/img/cta-image.jpg') }}" alt="CTA Image" class="img-fluid">
                </div>
            </div>
            <div class="col-md-6">
                <div class="cta-text">
                    <h2>Quality roofing provider</h2>
                    <p>Need roofing services?</p>
                    <a href="{{ url('/contact') }}" class="btn btn-primary mt-3">get free quote</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
