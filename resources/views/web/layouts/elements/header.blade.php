<header>
    <div class="top-bar bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled mb-0">
                        <li><i class="bx bx-phone me-2"></i> Mon to Sat: 09:00 am to 05:00 pm</li>
                        <li><i class="bx bx-envelope me-2"></i> <a href="mailto:needhelp@company.com">needhelp@company.com</a></li>
                    </ul>
                </div>
                <div class="col-md-6 text-md-end">
                    <ul class="list-unstyled mb-0">
                        <li><a href="{{ url('/faq') }}">Our Faqs</a></li>
                        <li><a href="{{ url('/contact') }}">Pricing</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('assets/web/img/logo.png') }}" alt="Logo" width="120">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('about*') ? 'active' : '' }}" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            About
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/about') }}">About</a>
                            <li><a class="dropdown-item" href="{{ url('/team') }}">Our Team</a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('services*') ? 'active' : '' }}" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Services
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                            <li><a class="dropdown-item" href="{{ url('/services') }}">Services</a>
                            <li><a class="dropdown-item" href="{{ url('/services-carousel') }}">Services Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/single-play-roofing') }}">Single play roofing</a>
                            <li><a class="dropdown-item" href="{{ url('/modified-roofing') }}">Modified roofing</a>
                            <li><a class="dropdown-item" href="{{ url('/built-up-roofing') }}">Built-up roofing</a>
                            <li><a class="dropdown-item" href="{{ url('/roof-inspection') }}">Roof inspection</a>
                            <li><a class="dropdown-item" href="{{ url('/roof-installation') }}">Roof installation</a>
                            <li><a class="dropdown-item" href="{{ url('/metal-roofing') }}">Metal roofing</a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('pages*') ? 'active' : '' }}" href="#" id="pagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pages
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="pagesDropdown">
                            <li><a class="dropdown-item" href="{{ url('/team') }}">Team</a>
                            <li><a class="dropdown-item" href="{{ url('/team-carousel') }}">Team Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/team-details') }}">Team Details</a>
                            <li><a class="dropdown-item" href="{{ url('/testimonials') }}">Testimonials</a>
                            <li><a class="dropdown-item" href="{{ url('/testimonials-carousel') }}">Testimonials Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/gallery') }}">Gallery</a>
                            <li><a class="dropdown-item" href="{{ url('/gallery-carousel') }}">Gallery Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/faq') }}">FAQs</a>
                            <li><a class="dropdown-item" href="{{ url('/404') }}">404 Error</a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('works*') ? 'active' : '' }}" href="#" id="worksDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Works
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="worksDropdown">
                            <li><a class="dropdown-item" href="{{ url('/work') }}">Work</a>
                            <li><a class="dropdown-item" href="{{ url('/work-carousel') }}">Work Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/work-details') }}">Work Details</a>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('blog*') ? 'active' : '' }}" href="#" id="blogDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Blog
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="blogDropdown">
                            <li><a class="dropdown-item" href="{{ url('/blog') }}">Blog</a>
                            <li><a class="dropdown-item" href="{{ url('/blog-carousel') }}">Blog Carousel</a>
                            <li><a class="dropdown-item" href="{{ url('/blog-sidebar') }}">Blog Sidebar</a>
                            <li><a class="dropdown-item" href="{{ url('/blog-details') }}">Blog Details</a>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
