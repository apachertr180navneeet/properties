<footer class="footer mt-auto py-5">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center mb-3">
                    <i class="bx bx-home-alt fs-2 text-primary me-2"></i>
                    <h4 class="mb-0 text-white fw-bold">{{ config('app.name', 'Antigravity Properties') }}</h4>
                </div>
                <p class="mb-4">Simplifying your real estate journey. Find, buy, or rent your dream properties with trusted listings, verified agents, and comprehensive support at every step.</p>
                <div class="d-flex">
                    <a href="javascript:void(0)" class="footer-social-icon"><i class="bx bxl-facebook"></i></a>
                    <a href="javascript:void(0)" class="footer-social-icon"><i class="bx bxl-twitter"></i></a>
                    <a href="javascript:void(0)" class="footer-social-icon"><i class="bx bxl-instagram"></i></a>
                    <a href="javascript:void(0)" class="footer-social-icon"><i class="bx bxl-linkedin"></i></a>
                </div>
            </div>
            
            <div class="col-lg-2 col-md-6">
                <h5 class="footer-title">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}">Home</a></li>
                    <li class="mb-2"><a href="{{ url('/') }}">Available Properties</a></li>
                    <li class="mb-2"><a href="{{ url('admin/login') }}">Admin Portal</a></li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <h5 class="footer-title">Newsletter</h5>
                <p class="mb-3">Subscribe to our newsletter to receive the latest updates, market trends, and featured listings.</p>
                <div class="input-group mb-3">
                    <input type="email" class="form-control bg-transparent border-secondary text-white py-2" placeholder="Your Email Address" style="border-radius: 10px 0 0 10px;">
                    <button class="btn btn-primary-gradient px-4" type="button" style="border-radius: 0 10px 10px 0;">Join</button>
                </div>
            </div>
        </div>
        
        <div class="row footer-bottom">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> {{ config('app.name', 'Antigravity Properties') }}. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item me-3"><a href="javascript:void(0)">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="javascript:void(0)">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>