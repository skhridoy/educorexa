<section id="features" class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5 pb-3">
            <h2 class="fw-bold text-dark mb-2">Comprehensive Modules</h2>
            <p class="text-muted">Everything you need to manage your institution efficiently</p>
            <div class="mx-auto bg-primary rounded" style="width: 50px; height: 4px;"></div>
        </div>

        <div class="row g-4">
            @php
                $modules = [
                    ['title' => 'Admission Management', 'icon' => 'user-plus', 'desc' => 'অনলাইন ও অফলাইন অ্যাডমিশন প্রক্রিয়া।', 'color' => '#6571ff'],
                    ['title' => 'Student Attendance', 'icon' => 'calendar', 'desc' => 'অটোমেটেড উপস্থিতি ট্র্যাকিং সিস্টেম।', 'color' => '#05a34a'],
                    ['title' => 'Fees & Collection', 'icon' => 'credit-card', 'desc' => 'সহজ পেমেন্ট গেটওয়ে ও ইনভয়েস জেনারেটর।', 'color' => '#ff3366'],
                    ['title' => 'Examination & Results', 'icon' => 'award', 'desc' => 'স্মার্ট মার্কশিট ও রেজাল্ট পাবলিশিং।', 'color' => '#fbbc05'],
                    ['title' => 'Payroll & HR', 'icon' => 'users', 'desc' => 'শিক্ষক ও স্টাফদের স্যালারি ম্যানেজমেন্ট।', 'color' => '#2e3fe3'],
                    ['title' => 'Library Management', 'icon' => 'book-open', 'desc' => 'বই আদান-প্রদান ও ডিজিটাল ক্যাটালগ।', 'color' => '#00b9ff'],
                    ['title' => 'Transport & GPS', 'icon' => 'truck', 'desc' => 'স্কুল বাসের রুট ও ফি ট্র্যাকিং।', 'color' => '#727cf5'],
                    ['title' => 'Inventory System', 'icon' => 'package', 'desc' => 'স্কুল সম্পদ ও স্টোক ম্যানেজমেন্ট।', 'color' => '#fa5c7c']
                ];
            @endphp

            @foreach($modules as $m)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="module-item text-center p-4 border rounded-4 hover-shadow transition h-100 bg-white shadow-sm" style="border-top: 3px solid {{ $m['color'] }} !important;">
                    <div class="icon-box mb-3 mx-auto d-flex align-items-center justify-content-center rounded-circle" 
                         style="width: 60px; height: 60px; background-color: {{ $m['color'] }}15; color: {{ $m['color'] }};">
                        <i data-feather="{{ $m['icon'] }}" style="width: 28px; height: 28px;"></i> 
                    </div>
                    <h6 class="fw-bold text-dark mb-2">{{ $m['title'] }}</h6>
                    <p class="small text-muted mb-0 d-none d-md-block" style="line-height: 1.6;">{{ $m['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    /* হোভার ইফেক্ট */
    .module-item {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .module-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
        border-color: transparent !important;
    }
    .transition { transition: 0.3s; }
</style>