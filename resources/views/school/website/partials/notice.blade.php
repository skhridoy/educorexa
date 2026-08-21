{{-- ══ LATEST NOTICES — Homepage Partial ══ --}}
<style>
    .home-notice-section {
        padding: 70px 0;
        background: linear-gradient(180deg, #f8fafc 0%, #eff6ff 100%);
        position: relative;
    }
    .home-notice-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1d4ed8, #7c3aed, #1d4ed8);
        background-size: 200% 100%;
        animation: borderFlow 3s linear infinite;
    }
    @keyframes borderFlow { 0%{background-position:0%} 100%{background-position:200%} }

    .home-notice-header { text-align: center; margin-bottom: 44px; }
    .home-notice-chip {
        display: inline-flex; align-items: center; gap: 7px;
        background: #eff6ff; color: #1d4ed8;
        border: 1px solid #bfdbfe; border-radius: 20px;
        font-size: 0.74rem; font-weight: 700;
        padding: 5px 14px; margin-bottom: 14px;
        letter-spacing: 0.04em;
    }
    .home-notice-header h2 {
        font-size: 2rem; font-weight: 900;
        color: #0f172a; margin: 0 0 10px; line-height: 1.2;
    }
    .home-notice-header p { color: #64748b; font-size: 0.92rem; margin: 0; }

    /* Notice Item */
    .hn-item {
        display: flex; align-items: flex-start; gap: 16px;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 16px 18px;
        margin-bottom: 14px;
        box-shadow: 0 2px 10px rgba(15,23,42,0.05);
        transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
        position: relative;
        overflow: hidden;
        text-decoration: none !important;
        display: flex !important;
    }
    .hn-item::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #1d4ed8, #7c3aed);
        border-radius: 14px 0 0 14px;
    }
    .hn-item:hover {
        transform: translateX(4px);
        box-shadow: 0 8px 28px rgba(29,78,216,0.12);
        border-color: #bfdbfe;
    }
    .hn-date {
        flex: 0 0 52px; width: 52px; height: 56px;
        background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        border-radius: 12px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(29,78,216,0.22);
    }
    .hn-date-day { font-size: 1.2rem; font-weight: 900; color: #fff; line-height: 1; }
    .hn-date-mon { font-size: 0.58rem; font-weight: 700; color: rgba(255,255,255,0.78); text-transform: uppercase; letter-spacing: 0.06em; }
    .hn-body { flex: 1; min-width: 0; }
    .hn-title {
        font-size: 0.94rem; font-weight: 700; color: #0f172a;
        margin: 0 0 5px; white-space: nowrap;
        overflow: hidden; text-overflow: ellipsis;
        line-height: 1.35;
    }
    .hn-meta {
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .hn-meta-text { font-size: 0.70rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }
    .hn-new-tag {
        display: inline-flex; align-items: center; gap: 3px;
        background: #fef3c7; color: #d97706;
        border: 1px solid #fde68a; border-radius: 20px;
        font-size: 0.62rem; font-weight: 700; padding: 1px 7px;
    }
    .hn-file-tag {
        display: inline-flex; align-items: center; gap: 3px;
        background: #eff6ff; color: #1d4ed8;
        border: 1px solid #bfdbfe; border-radius: 20px;
        font-size: 0.62rem; font-weight: 700; padding: 1px 7px;
    }
    .hn-arrow {
        flex-shrink: 0; width: 30px; height: 30px;
        border-radius: 8px; background: #eff6ff; color: #1d4ed8;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; transition: all 0.2s ease;
    }
    .hn-item:hover .hn-arrow { background: #1d4ed8; color: #fff; }

    /* View All button */
    .hn-view-all {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        color: #fff !important; text-decoration: none;
        font-size: 0.88rem; font-weight: 700;
        padding: 11px 28px; border-radius: 10px;
        box-shadow: 0 4px 14px rgba(29,78,216,0.3);
        transition: all 0.25s ease;
    }
    .hn-view-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(29,78,216,0.42);
        background: linear-gradient(135deg, #1e40af, #2563eb);
    }

    @keyframes pulseDot2 { 0%,100%{opacity:1} 50%{opacity:.5} }
    .live-dot { display: inline-block; width: 7px; height: 7px; background: #ef4444; border-radius: 50%; animation: pulseDot2 1.4s ease infinite; }
</style>

<section class="home-notice-section">
    <div class="container">
        <div class="home-notice-header">
            <div class="home-notice-chip">
                <span class="live-dot"></span> সর্বশেষ আপডেট
            </div>
            <h2>গুরুত্বপূর্ণ <span style="color:#1d4ed8;">নোটিশ</span></h2>
            <p>স্কুলের সকল গুরুত্বপূর্ণ বিজ্ঞপ্তি ও তথ্য এখানে পাওয়া যাবে।</p>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                @forelse($notices as $notice)
                    @php
                        $isNew = \Carbon\Carbon::parse($notice->created_at)->diffInDays(now()) <= 3;
                    @endphp
                    <div class="hn-item">
                        <div class="hn-date">
                            <span class="hn-date-day">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d') }}</span>
                            <span class="hn-date-mon">{{ \Carbon\Carbon::parse($notice->notice_date)->format('M') }}</span>
                        </div>
                        <div class="hn-body">
                            <p class="hn-title">{{ $notice->title }}</p>
                            <div class="hn-meta">
                                @if($isNew)<span class="hn-new-tag"><i class="fas fa-star" style="font-size:0.55rem;"></i> নতুন</span>@endif
                                @if($notice->file)<span class="hn-file-tag"><i class="fas fa-paperclip" style="font-size:0.6rem;"></i> সংযুক্তি</span>@endif
                                <span class="hn-meta-text">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="hn-arrow">
                            @if($notice->file)
                                <a href="{{ asset($notice->file) }}" target="_blank" style="color:inherit; display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                                    <i class="fas fa-download"></i>
                                </a>
                            @else
                                <i class="fas fa-chevron-right"></i>
                            @endif
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:40px 20px; color:#94a3b8;">
                        <i class="fas fa-bell-slash" style="font-size:2rem; margin-bottom:12px; display:block;"></i>
                        এই মুহূর্তে কোনো নোটিশ নেই।
                    </div>
                @endforelse

                @if(isset($notices) && $notices->count() > 0)
                <div class="text-center mt-4">
                    <a href="{{ url('/notices') }}" class="hn-view-all">
                        সকল নোটিশ দেখুন <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>