@extends('web.layouts.app')
@section('content')
<!-- Projects Header -->
<section class="projects-header py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="projects-header-content">
                    <h2>Latest Projects</h2>
                    <p>Explore our latest projects for your inspiration</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ url('/work-details') }}" class="btn btn-outline-primary">View All Projects</a>
            </div>
        </div>
    </div>
</section>

<!-- Projects Grid -->
<section class="projects-grid py-5">
    <div class="container">
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
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-5.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-6.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-7.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="project-item">
                    <img src="{{ asset('assets/web/img/project-8.jpg') }}" alt="Project" class="img-fluid">
                    <h3><a href="{{ url('/work-details') }}">Modern roofing style</a></h3>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection