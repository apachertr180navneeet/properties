@extends('web.layouts.app')
@section('content')
<!-- Services Header -->
<section class="services-header py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="services-header-content">
                    <h2>Our services</h2>
                    <p>We’re providing quality roofing services</p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="services-header-image">
                    <img src="{{ asset('assets/web/img/services-header.jpg') }}" alt="Services" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services List -->
<section class="services-list py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-1.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/single-play-roofing') }}">Single play roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/single-play-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-2.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/modified-roofing') }}">Modified roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/modified-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-3.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/built-up-roofing') }}">Built-up roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/built-up-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-4.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/roof-inspection') }}">Roof inspection</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/roof-inspection') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-5.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/roof-installation') }}">Roof installation</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/roof-installation') }}" class="read-more">Read More</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="{{ asset('assets/web/img/service-icon-6.png') }}" alt="Service Icon">
                    </div>
                    <h3><a href="{{ url('/metal-roofing') }}">Metal roofing</a></h3>
                    <p>Nulla commodo dolor massa, vel pellen esque nulla congue quis.</p>
                    <a href="{{ url('/metal-roofing') }}" class="read-more">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection