@extends('web.layouts.app')
@section('content')
<!-- Work Details -->
<section class="work-details py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="work-content">
                    <h2>Modern roofing style</h2>
                    <div class="work-image">
                        <img src="{{ asset('assets/web/img/work-detail-1.jpg') }}" alt="Work Detail" class="img-fluid mb-4">
                    </div>
                    <p>
                        Nulla commodo dolor massa, vel pellen esque nulla congue quis. 
                        Fusce ut convallis diam. Nam id tortor et nunc tempor faucibus. 
                        Sed eu leo egestas, imperdiet felis sed, vestibulum ligula.
                    </p>
                    <p>
                        Exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum 
                        dolore eu fugiat nulla pariatur.
                    </p>
                    <div class="work-image">
                        <img src="{{ asset('assets/web/img/work-detail-2.jpg') }}" alt="Work Detail" class="img-fluid mb-4">
                    </div>
                    <blockquote class="blockquote">
                        <p class="mb-0">"Exercitation ullamco laboris nisi ut aliquip ex ea ex commodo consequat duis aute aboris nisi ut aliquip irure reprehederit in voluptate velit esse ."</p>
                        <footer class="blockquote-footer">Client Name</footer>
                    </blockquote>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="work-sidebar">
                    <h3>Project Info</h3>
                    <ul class="list-unstyled project-info">
                        <li><i class="bx bx-map me-2"></i> <strong>Location:</strong> New York, USA</li>
                        <li><i class="bx bx-calendar me-2"></i> <strong>Date:</strong> January 2022</li>
                        <li><i class="bx bx-time-five me-2"></i> <strong>Duration:</strong> 3 weeks</li>
                        <li><i class="bx bx-buildings me-2"></i> <strong>Type:</strong> Residential</li>
                        <li><i class="bx bx-badge-check me-2"></i> <strong>Status:</strong> Completed</li>
                    </ul>
                    
                    <h3 class="mt-4">Related Projects</h3>
                    <div class="related-projects">
                        <div class="related-item">
                            <img src="{{ asset('assets/web/img/related-1.jpg') }}" alt="Related Project" class="img-fluid mb-3">
                            <h4><a href="{{ url('/work-details') }}">Modern roofing style</a></h4>
                        </div>
                        <div class="related-item">
                            <img src="{{ asset('assets/web/img/related-2.jpg') }}" alt="Related Project" class="img-fluid mb-3">
                            <h4><a href="{{ url('/work-details') }}">Modern roofing style</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection