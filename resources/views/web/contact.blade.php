@extends('web.layouts.app')
@section('content')
<!-- Contact Info -->
<section class="contact-info py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-item">
                    <i class="bx bx-phone"></i>
                    <div>
                        <h4>Call Anytime</h4>
                        <p><a href="tel:9200368090">+92 (003) 68-090</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-item">
                    <i class="bx bx-envelope"></i>
                    <div>
                        <h4>Email Us</h4>
                        <p><a href="mailto:needhelp@company.com">needhelp@company.com</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-item">
                    <i class="bx bx-time-five"></i>
                    <div>
                        <h4>Working Hours</h4>
                        <p>Mon to Sat: 09:00 am to 05:00 pm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="contact-form py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2>Get In Touch</h2>
            <p>Have a question? We'd love to hear from you.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ url('/contact') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                                <label for="email">Email Address</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Your Phone" required>
                                <label for="phone">Phone Number</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" required>
                                <label for="subject">Subject</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control" id="message" name="message" placeholder="Your Message" style="height: 150px" required></textarea>
                                <label for="message">Message</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">Our Location</h2>
        <div class="ratio ratio-16x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12097.433213460943!2d-74.0060152!3d40.7127281!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d:0xb89d1fe6bc499443!2sNew%20York,%20NY,%20USA!5e0!3m2!1sen!2sbd!4v1600000000000" 
                    allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
@endsection