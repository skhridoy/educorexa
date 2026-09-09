{{-- ===== REPRESENTATIVE CTA SECTION ===== --}}
<section class="py-5" style="background: linear-gradient(135deg, #0061A8 0%, #0080d4 50%, #6366f1 100%); position: relative; overflow: hidden;">

    {{-- subtle decorative circles --}}
    <div style="position:absolute;top:-60px;right:-60px;width:220px;height:220px;border-radius:50%;background:rgba(255,255,255,0.06);pointer-events:none;"></div>
    <div style="position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.05);pointer-events:none;"></div>

    <div class="container position-relative">
        <div class="row align-items-center g-4">

            {{-- Left: Text --}}
            <div class="col-lg-8">
                <span style="display:inline-block;background:rgba(255,255,255,0.18);color:#fff;font-size:12px;font-weight:700;padding:5px 14px;border-radius:50px;letter-spacing:0.06em;margin-bottom:14px;">
                    <i class="bi bi-briefcase-fill me-1"></i> ক্যারিয়ার সুযোগ
                </span>
                <h2 style="color:#fff;font-size:clamp(1.4rem,3vw,2rem);font-weight:800;margin-bottom:12px;line-height:1.3;">
                    আমাদের সফটওয়্যারের <u style="text-decoration-color:rgba(255,255,255,0.5);">প্রতিনিধি</u> হিসেবে আপনার ক্যারিয়ার শুরু করুন
                </h2>
                <p style="color:rgba(255,255,255,0.82);font-size:15px;margin-bottom:0;max-width:560px;line-height:1.7;">
                    EduCorexa-এর অফিসিয়াল সেলস রিপ্রেজেন্টেটিভ হিসেবে যোগ দিন — আকর্ষণীয় কমিশন, নিজস্ব ড্যাশবোর্ড এবং ক্যারিয়ার গ্রোথের সুযোগ পান।
                </p>
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.85);font-size:13px;">
                        <i class="bi bi-check-circle-fill" style="color:#86efac;font-size:16px;"></i> আকর্ষণীয় কমিশন
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.85);font-size:13px;">
                        <i class="bi bi-check-circle-fill" style="color:#86efac;font-size:16px;"></i> নিজস্ব প্যানেল অ্যাক্সেস
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.85);font-size:13px;">
                        <i class="bi bi-check-circle-fill" style="color:#86efac;font-size:16px;"></i> ফ্রি ট্রেনিং সাপোর্ট
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;color:rgba(255,255,255,0.85);font-size:13px;">
                        <i class="bi bi-check-circle-fill" style="color:#86efac;font-size:16px;"></i> ক্যারিয়ার গ্রোথ
                    </div>
                </div>
            </div>

            {{-- Right: CTA Button --}}
            <div class="col-lg-4 text-lg-end text-start">
                <a href="{{ route('representative.register.form') }}"
                   style="display:inline-flex;align-items:center;gap:10px;background:#fff;color:#0061A8;font-size:15px;font-weight:800;padding:15px 32px;border-radius:14px;text-decoration:none;box-shadow:0 8px 28px rgba(0,0,0,0.2);transition:all 0.25s;"
                   onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 36px rgba(0,0,0,0.28)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 8px 28px rgba(0,0,0,0.2)'">
                    <i class="bi bi-person-plus-fill" style="font-size:18px;"></i>
                    এখনই আবেদন করুন
                </a>
                <p style="color:rgba(255,255,255,0.65);font-size:12px;margin-top:10px;margin-bottom:0;">
                    <i class="bi bi-people-fill me-1"></i> ইতিমধ্যে ১২০+ প্রতিনিধি যোগ দিয়েছেন
                </p>
            </div>

        </div>
    </div>
</section>
