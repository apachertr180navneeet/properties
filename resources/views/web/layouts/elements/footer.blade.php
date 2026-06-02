<footer class="bg-dark text-white">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <h5>About {{ config('app.name') }}</h5>
                <p class="mb-0">Find your dream property with our trusted real estate platform. We provide verified listings, expert guidance, and seamless transactions.</p>
            </div>
            <div class="col-md-2">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/properties') }}">Properties</a></li>
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5>Company</h5>
                <ul class="list-unstyled">
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <ul class="list-unstyled">
                    <li><i class="bx bx-map me-2"></i> 123 Real Estate Street, City</li>
                    <li><i class="bx bx-phone me-2"></i> +1 (555) 123-4567</li>
                    <li><i class="bx bx-envelope me-2"></i> info@realestate.com</li>
                </ul>
                <div class="social-icons mt-3">
                    <a href="#" title="Facebook"><i class="bx bxl-facebook"></i></a>
                    <a href="#" title="Twitter"><i class="bx bxl-twitter"></i></a>
                    <a href="#" title="Instagram"><i class="bx bxl-instagram"></i></a>
                    <a href="#" title="LinkedIn"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="border-top border-secondary-subtle pt-4">
            <div class="row align-items-center">
                <div class="col text-center">
                    <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> <a href="javascript:void(0)" class="text-white-50">{{ config('app.name') }}</a>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
