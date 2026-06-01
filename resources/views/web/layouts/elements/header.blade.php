<nav class="navbar navbar-expand-lg navbar-light glass-nav sticky-top py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="bx bx-home-alt fs-3 me-2 text-primary"></i>
            <h5 class="mb-0 fw-bold">{{ config('app.name', 'Antigravity Properties') }}</h5>
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') || request()->is('home') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('properties*') ? 'active' : '' }}" href="{{ url('/') }}">Properties</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
