<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top main-navigation shadow-sm">
    <div class="container px-lg-5"> 
        <a href="{{ url('/') }}" class="navbar-brand me-4">
            @if(isset($setting) && $setting->logo_wide)
                <img src="{{ asset($setting->logo_wide) }}" alt="{{ $setting->site_name }}" class="logo-img">
            @else
                <span class="fw-bolder text-primary fs-3" style="letter-spacing: -1px;">
                    Edu<span class="text-dark">Corexa</span>
                </span>
            @endif
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 pe-lg-4 text-center text-lg-start">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="#features" class="nav-link">Modules</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('about.details') }}" class="nav-link {{ Request::routeIs('about.details') ? 'active' : '' }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="#pricing" class="nav-link">Pricing</a>
                </li>
                <li class="nav-item">
                    <a href="#contact" class="nav-link">Contact</a>
                </li>
            </ul>

            <div class="nav-btns d-flex flex-column flex-lg-row align-items-center gap-3 mt-3 mt-lg-0">
                <a href="{{ route('login') }}" class="btn btn-outline-primary border-0 fw-bold px-4 order-2 order-lg-1 rounded-pill">
                    Login
                </a>
                <a href="{{ route('school.register.form') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-sm order-1 order-lg-2 w-100 w-lg-auto btn-register">
                    Register School
                </a>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar রেসপন্সিভ ফিক্স */
    .navbar-brand .logo-img {
        height: 35px; /* মোবাইলে লোগো ছোট করা হয়েছে */
        width: auto;
    }

    @media (max-width: 991px) {
        .main-navigation {
            padding: 10px 0;
        }
        .navbar-collapse {
            margin-top: 10px;
            border-radius: 15px;
            padding: 20px;
            border: 1px solid rgba(0,0,0,0.05);
        }
        /* মোবাইলে বাটন যেন ফুল উইডথ হয় */
        .nav-btns {
            width: 100%;
            flex-direction: column !important;
        }
        .nav-btns .btn {
            width: 100% !important;
            margin-bottom: 5px;
        }
    }

    /* Hero Section টাইপোগ্রাফি ফিক্স */
    .display-4 {
        font-size: calc(1.5rem + 1.5vw); /* রেসপন্সিভ ফন্ট সাইজ */
        font-weight: 800;
    }

    .hero-subtitle {
        font-size: 0.9rem;
        letter-spacing: 2px;
        font-weight: 700;
    }
    /* ১. মেইন নেভিগেশন স্টাইল */
    .main-navigation {
        padding: 15px 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1050;
    }
    
    .navbar.scrolled {
        padding: 8px 0;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(15px);
        box-shadow: 0 4px 20px rgba(0,0,0,0.05) !important;
    }

    /* ২. ডাইনামিক লিঙ্ক ও আন্ডারলাইন */
    .nav-link {
        color: #4b5563 !important; /* NobleUI Slate Color */
        font-weight: 600;
        font-size: 15px;
        padding: 10px 18px !important;
        transition: 0.3s;
    }

    .nav-link:hover, .nav-link.active {
        color: #6571ff !important;
    }

    @media (min-width: 992px) {
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            left: 50%;
            background-color: #6571ff;
            transition: all 0.3s;
            transform: translateX(-50%);
            border-radius: 10px;
        }
        .nav-link:hover::after, .nav-link.active::after {
            width: 20px;
        }
    }

    /* ৩. প্রফেশনাল বাটন ডিজাইন */
    .btn-register {
        background: linear-gradient(45deg, #6571ff, #4d59e6);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(101, 113, 255, 0.3) !important;
        background: linear-gradient(45deg, #4d59e6, #6571ff);
    }

    .btn-outline-primary:hover {
        background-color: rgba(101, 113, 255, 0.08);
        color: #6571ff !important;
    }

    /* ৪. মোবাইল রেসপন্সিভ */
    @media (max-width: 991px) {
        .navbar-collapse {
            background: #fff;
            padding: 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .nav-link.active {
            background-color: rgba(101, 113, 255, 0.05);
            border-radius: 12px;
        }
    }
</style>

<script>
    // ১. স্ক্রল ইফেক্ট
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    });

    // ২. স্মুথ স্ক্রল এবং একটিভ লিঙ্ক হ্যান্ডলিং (On-Page Sections-এর জন্য)
    const sections = document.querySelectorAll('section[id]');
    window.addEventListener('scroll', () => {
        let scrollY = window.pageYOffset;
        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 100;
            const sectionId = current.getAttribute('id');
            
            if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                document.querySelector('.navbar-nav a[href*=' + sectionId + ']')?.classList.add('active');
            } else {
                document.querySelector('.navbar-nav a[href*=' + sectionId + ']')?.classList.remove('active');
            }
        });
    });
</script>