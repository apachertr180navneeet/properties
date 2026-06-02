@extends('web.layouts.app')
@section('content')
<!-- 404 Error -->
<section class="error-404 py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="error-content">
                    <h1>404</h1>
                    <h2>Page Not Found</h2>
                    <p>It looks like nothing was found at this location. Maybe try a search?</p>
                    <a href="{{ url('/') }}" class="btn btn-primary mt-4">Return to Homepage</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection