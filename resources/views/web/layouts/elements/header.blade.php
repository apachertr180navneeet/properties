<nav class='navbar navbar-expand-lg navbar-dark bg-primary'>
    <div class='container-fluid'>
        <a class='navbar-brand' href='{{ url('/') }}'>
            <h5 class='pt-1 mb-0'>{{ config('app.name') }}</h5>
        </a>
        
        <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        
        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
            <ul class='navbar-nav me-auto mb-2 mb-lg-0'>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->is('/') ? 'active' : '' }}' href='{{ url('/') }}'>Home</a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link {{ request()->is('properties*') ? 'active' : '' }}' href='{{ url('/') }}'>Properties</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
