<footer class="footer-section pt-5 pb-4" style="background-color: #0b1324; color: #adb5bd;">
    <div class="container px-lg-5">
        <div class="row g-4 pb-5">
            <div class="col-md-6 col-lg-3">
                <div class="mb-4">
                    <h3 class="text-white fw-bolder mb-0" style="letter-spacing: -1px;">EduCorexa</h3>
                </div>
                <p class="small lh-lg mb-4" style="color: #8a94ad;">
                    আমাদের লক্ষ্য শিক্ষা প্রতিষ্ঠানগুলোকে আধুনিক প্রযুক্তির মাধ্যমে আরও গতিশীল এবং স্মার্ট করে তোলা। একটি সমন্বিত ইআরপি সমাধান যা আপনার কাজকে করবে সহজ।
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="social-icon-btn"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon-btn"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-icon-btn"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6 class="footer-title mb-4">Contact Info</h6>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-center small">
                        <i class="bi bi-geo-alt-fill text-primary me-3 fs-5"></i>
                        <span>Dhaka, Bangladesh</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center small">
                        <i class="bi bi-telephone-fill text-primary me-3 fs-5"></i>
                        <span>+880123456789</span>
                    </li>
                    <li class="mb-3 d-flex align-items-center small">
                        <i class="bi bi-envelope-at-fill text-primary me-3 fs-5"></i>
                        <span>support@educorexa.com</span>
                    </li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6 class="footer-title mb-4">Quick Links</h6>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="#features" class="footer-link">Our Modules</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Privacy Policy</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Terms & Conditions</a></li>
                    <li class="mb-2"><a href="{{ route('login.form') }}" class="footer-link">Admin Login</a></li>
                </ul>
            </div>

            <div class="col-md-6 col-lg-3">
                <h6 class="footer-title mb-4">Newsletter</h6>
                <p class="small mb-3" style="color: #8a94ad;">নতুন আপডেট পেতে সাবস্ক্রাইব করুন।</p>
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Email Address">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="pt-4 border-top border-secondary border-opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small" style="color: #8a94ad;">
                        &copy; 2026 <span class="text-white fw-bold">EduCorexa</span>. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <p class="mb-0 small" style="color: #8a94ad;">
                        Developed with <span class="text-danger">❤</span> by <a href="#" class="text-primary text-decoration-none fw-bold">Kajol Ray</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    /* টাইটেল স্টাইল */
    .footer-title {
        color: #ffffff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        position: relative;
        padding-left: 15px;
    }
    .footer-title::before {
        content: "";
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 3px;
        height: 15px;
        background-color: #6571ff;
        border-radius: 2px;
    }

    /* সোশ্যাল বাটন */
    .social-icon-btn {
        width: 36px;
        height: 36px;
        background-color: rgba(255, 255, 255, 0.05);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.3s ease;
        text-decoration: none;
    }
    .social-icon-btn:hover {
        background-color: #6571ff;
        color: #ffffff;
        transform: translateY(-3px);
    }

    /* লিংক স্টাইল */
    .footer-link {
        color: #8a94ad;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .footer-link:hover {
        color: #6571ff;
        padding-left: 5px;
    }

    /* নিউজলেটার ইনপুট */
    .newsletter-form .form-control {
        background-color: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        font-size: 0.85rem;
        padding: 10px 15px;
    }
    .newsletter-form .form-control:focus {
        box-shadow: none;
        border-color: #6571ff;
        background-color: rgba(255, 255, 255, 0.08);
    }
</style>