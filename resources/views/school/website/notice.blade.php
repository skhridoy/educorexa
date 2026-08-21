@extends('school.website.layouts.app')

@section('customCSS')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* ══════════════════════════════════════
       PUBLIC NOTICE PAGE — PREMIUM DESIGN
    ══════════════════════════════════════ */
    *, *::before, *::after { box-sizing: border-box; }
    body { font-family: 'Inter', 'Heebo', sans-serif !important; }

    /* ── Page Hero Banner ── */
    .pub-notice-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 45%, #1d4ed8 100%);
        padding: 70px 0 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .pub-notice-hero::before {
        content: '';
        position: absolute;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: rgba(59,130,246,0.10);
        top: -150px; right: -100px;
    }
    .pub-notice-hero::after {
        content: '';
        position: absolute;
        width: 320px; height: 320px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
        bottom: -100px; left: -60px;
    }
    .pub-notice-hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.22);
        color: #93c5fd; font-size: 0.78rem; font-weight: 700;
        padding: 5px 14px; border-radius: 20px; margin-bottom: 16px;
        letter-spacing: 0.04em;
    }
    .pub-notice-hero h1 {
        font-size: 2.4rem; font-weight: 900;
        color: #fff; margin-bottom: 12px; line-height: 1.2;
    }
    .pub-notice-hero p {
        color: rgba(255,255,255,0.68); font-size: 1rem; margin: 0;
        max-width: 500px; margin-inline: auto;
    }
    .pub-notice-stats {
        display: flex; justify-content: center; gap: 24px;
        margin-top: 32px; flex-wrap: wrap;
    }
    .pub-notice-stat {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        border-radius: 14px; padding: 14px 24px;
        text-align: center; min-width: 90px;
    }
    .pub-notice-stat-num { font-size: 1.8rem; font-weight: 800; color: #fff; line-height: 1; }
    .pub-notice-stat-lbl { font-size: 0.70rem; color: rgba(255,255,255,0.60); font-weight: 600; margin-top: 3px; }

    /* ── Main Content ── */
    .pub-notice-wrap { padding: 64px 0; background: #f8fafc; min-height: 60vh; }

    /* Search/Filter Bar */
    .pub-notice-toolbar {
        display: flex; align-items: center; gap: 12px;
        background: #fff; border: 1px solid #e2e8f0; border-radius: 14px;
        padding: 14px 18px; margin-bottom: 36px;
        box-shadow: 0 2px 10px rgba(15,23,42,0.05);
    }
    .pub-notice-search {
        flex: 1; border: none; outline: none; background: transparent;
        font-size: 0.9rem; color: #1e293b;
    }
    .pub-notice-search::placeholder { color: #94a3b8; }
    .pub-notice-search-icon { color: #94a3b8; font-size: 1rem; }
    .pub-notice-count-pill {
        background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        color: #fff; font-size: 0.72rem; font-weight: 700;
        padding: 4px 12px; border-radius: 20px; white-space: nowrap;
    }

    /* Notice Card */
    .pn-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 0;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 2px 12px rgba(15,23,42,0.05);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        display: flex;
        position: relative;
    }
    .pn-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 32px rgba(15,23,42,0.12);
        border-color: #bfdbfe;
    }
    /* Left accent bar */
    .pn-card::before {
        content: '';
        position: absolute;
        left: 0; top: 0; bottom: 0;
        width: 4px;
        background: linear-gradient(180deg, #1d4ed8, #7c3aed);
        border-radius: 16px 0 0 16px;
    }
    .pn-date-col {
        flex: 0 0 88px;
        display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        padding: 22px 10px;
        border-right: 1px solid #f1f5f9;
        background: linear-gradient(180deg, #eff6ff, #dbeafe);
        gap: 2px;
    }
    .pn-date-day { font-size: 2rem; font-weight: 900; color: #1d4ed8; line-height: 1; }
    .pn-date-mon { font-size: 0.72rem; font-weight: 700; color: #3b82f6; text-transform: uppercase; letter-spacing: 0.08em; }
    .pn-date-yr  { font-size: 0.64rem; color: #93c5fd; font-weight: 600; }
    .pn-body {
        flex: 1; padding: 20px 22px; min-width: 0;
    }
    .pn-title {
        font-size: 1.05rem; font-weight: 800; color: #0f172a;
        margin: 0 0 8px; line-height: 1.35;
    }
    .pn-desc {
        font-size: 0.87rem; color: #64748b;
        line-height: 1.6; margin: 0 0 12px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .pn-footer {
        display: flex; align-items: center; gap: 10px; flex-wrap: wrap;
    }
    .pn-tag {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 0.72rem; font-weight: 600;
        padding: 3px 10px; border-radius: 20px;
    }
    .pn-tag.new   { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .pn-tag.file  { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .pn-date-text { font-size: 0.72rem; color: #94a3b8; display: flex; align-items: center; gap: 4px; }

    /* Download btn */
    .pn-download {
        display: inline-flex; align-items: center; gap: 6px;
        background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        color: #fff !important; text-decoration: none;
        font-size: 0.78rem; font-weight: 700;
        padding: 7px 16px; border-radius: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 3px 8px rgba(29,78,216,0.25);
        flex-shrink: 0;
    }
    .pn-download:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(29,78,216,0.38);
        background: linear-gradient(135deg, #1e40af, #2563eb);
    }
    .pn-right-col {
        display: flex; align-items: center; justify-content: center;
        padding: 20px 18px 20px 8px;
        flex-shrink: 0;
    }

    /* Empty State */
    .pn-empty {
        text-align: center;
        padding: 80px 20px;
    }
    .pn-empty-icon {
        width: 80px; height: 80px; margin: 0 auto 20px;
        border-radius: 20px;
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        color: #3b82f6; font-size: 2.2rem;
        display: flex; align-items: center; justify-content: center;
    }
    .pn-empty h3 { font-size: 1.2rem; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .pn-empty p  { color: #94a3b8; font-size: 0.9rem; }

    /* Pagination */
    .pn-pagination { display: flex; justify-content: center; margin-top: 36px; }
    .pn-pagination .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 3px;
        border: 1px solid #e2e8f0;
        color: #1e293b;
        font-size: 0.84rem;
        padding: 7px 13px;
        transition: all 0.18s ease;
    }
    .pn-pagination .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #1d4ed8, #3b82f6);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 3px 8px rgba(29,78,216,0.3);
    }
    .pn-pagination .pagination .page-link:hover {
        background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8;
    }

    /* "NEW" pulse for recent notices (within 3 days) */
    @keyframes pulseDot { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.4)} }
    .new-pulse { display: inline-block; width: 7px; height: 7px; background: #f59e0b; border-radius: 50%; animation: pulseDot 1.6s ease infinite; }

    /* Breadcrumb */
    .pub-breadcrumb {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.14);
        display: inline-flex; align-items: center; gap: 8px;
        padding: 6px 16px; border-radius: 20px;
        font-size: 0.76rem; color: rgba(255,255,255,0.65);
        margin-bottom: 20px;
        text-decoration: none;
    }
    .pub-breadcrumb span { color: rgba(255,255,255,0.45); }
    .pub-breadcrumb .cur { color: #93c5fd; font-weight: 600; }

    /* Mobile */
    @media (max-width: 576px) {
        .pub-notice-hero h1 { font-size: 1.7rem; }
        .pn-date-col { flex: 0 0 70px; }
        .pn-date-day { font-size: 1.5rem; }
        .pn-right-col { display: none; }
        .pn-footer .pn-download { display: inline-flex; }
    }
</style>
@endsection

@section('content')

{{-- ══ HERO BANNER ══ --}}
<section class="pub-notice-hero">
    <div class="container position-relative" style="z-index:1;">
        {{-- Breadcrumb --}}
        <a href="/" class="pub-breadcrumb">
            <i class="fas fa-home"></i>
            <span>›</span>
            <span class="cur">সকল নোটিশ</span>
        </a>

        <div class="pub-notice-badge">
            <span class="pub-notice-hero-badge">
                <i class="fas fa-bullhorn"></i> Official Notices
            </span>
        </div>

        <h1>স্কুলের সকল <span style="color:#93c5fd;">নোটিশ</span></h1>
        <p>সর্বশেষ বিজ্ঞপ্তি, পরীক্ষার সময়সূচি ও গুরুত্বপূর্ণ তথ্যাবলী একসাথে দেখুন।</p>

    @php
        $totalCount  = $notices->count();
        $weeklyCount = $notices->filter(fn($n) => \Carbon\Carbon::parse($n->created_at)->diffInDays(now()) <= 7)->count();
        $fileCount   = $notices->filter(fn($n) => !empty($n->file))->count();
    @endphp
        <div class="pub-notice-stats">
            <div class="pub-notice-stat">
                <div class="pub-notice-stat-num">{{ $totalCount }}</div>
                <div class="pub-notice-stat-lbl">মোট নোটিশ</div>
            </div>
            <div class="pub-notice-stat">
                <div class="pub-notice-stat-num">{{ $weeklyCount }}</div>
                <div class="pub-notice-stat-lbl">এই সপ্তাহে</div>
            </div>
            <div class="pub-notice-stat">
                <div class="pub-notice-stat-num">{{ $fileCount }}</div>
                <div class="pub-notice-stat-lbl">ফাইল সহ</div>
            </div>
        </div>
    </div>
</section>

{{-- ══ NOTICE LIST ══ --}}
<section class="pub-notice-wrap">
    <div class="container">

        {{-- Search / Filter Toolbar --}}
        <div class="pub-notice-toolbar">
            <i class="fas fa-search pub-notice-search-icon"></i>
            <input type="text" class="pub-notice-search" id="noticeSearch"
                   placeholder="নোটিশ খুঁজুন… (শিরোনাম লিখুন)" />
            <span class="pub-notice-count-pill">{{ $notices->count() }}টি নোটিশ</span>
        </div>

        {{-- Notice Cards --}}
        @if($notices->isEmpty())
            <div class="pn-empty">
                <div class="pn-empty-icon"><i class="fas fa-bell-slash"></i></div>
                <h3>কোনো নোটিশ নেই</h3>
                <p>এই মুহূর্তে কোনো নোটিশ প্রকাশিত হয়নি। পরে আবার দেখুন।</p>
            </div>
        @else
            <div id="noticeList">
                @foreach($notices as $notice)
                    @php
                        $isNew = \Carbon\Carbon::parse($notice->created_at)->diffInDays(now()) <= 3;
                    @endphp
                    <div class="pn-card notice-item-searchable"
                         data-title="{{ strtolower($notice->title) }} {{ strtolower($notice->description ?? '') }}">
                        {{-- Date Column --}}
                        <div class="pn-date-col">
                            <span class="pn-date-day">{{ \Carbon\Carbon::parse($notice->notice_date)->format('d') }}</span>
                            <span class="pn-date-mon">{{ \Carbon\Carbon::parse($notice->notice_date)->format('M') }}</span>
                            <span class="pn-date-yr">{{ \Carbon\Carbon::parse($notice->notice_date)->format('Y') }}</span>
                        </div>

                        {{-- Body --}}
                        <div class="pn-body">
                            <h2 class="pn-title">{{ $notice->title }}</h2>
                            @if($notice->description)
                                <p class="pn-desc">{{ $notice->description }}</p>
                            @endif
                            <div class="pn-footer">
                                @if($isNew)
                                    <span class="pn-tag new"><span class="new-pulse"></span> নতুন</span>
                                @endif
                                @if($notice->file)
                                    <span class="pn-tag file"><i class="fas fa-paperclip"></i> সংযুক্তি আছে</span>
                                @endif
                                <span class="pn-date-text">
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($notice->created_at)->diffForHumans() }}
                                </span>
                                {{-- Mobile download --}}
                                @if($notice->file)
                                    <a href="{{ asset($notice->file) }}" target="_blank" class="pn-download d-inline-flex d-sm-none ms-auto" style="font-size:0.72rem; padding:5px 12px;">
                                        <i class="fas fa-download"></i> ডাউনলোড
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Right: Download Button (desktop) --}}
                        <div class="pn-right-col d-none d-sm-flex">
                            @if($notice->file)
                                <a href="{{ asset($notice->file) }}" target="_blank" class="pn-download">
                                    <i class="fas fa-download"></i> ডাউনলোড
                                </a>
                            @else
                                <span style="font-size:0.72rem; color:#cbd5e1; text-align:center; max-width:70px; line-height:1.4;">কোনো<br>ফাইল নেই</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- No results message --}}
            <div id="noSearchResult" class="pn-empty" style="display:none;">
                <div class="pn-empty-icon"><i class="fas fa-search"></i></div>
                <h3>কোনো ফলাফল পাওয়া যায়নি</h3>
                <p>ভিন্ন কীওয়ার্ড দিয়ে আবার চেষ্টা করুন।</p>
            </div>

            {{-- Pagination --}}
            {{-- Collection doesn't paginate; pagination hidden for plain collection --}}
        @endif

    </div>
</section>

@endsection

@push('customJs')
<script>
    /* Live notice search */
    document.getElementById('noticeSearch')?.addEventListener('input', function() {
        const q = this.value.trim().toLowerCase();
        const items = document.querySelectorAll('.notice-item-searchable');
        let visible = 0;
        items.forEach(el => {
            const match = !q || el.dataset.title.includes(q);
            el.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        const noResult = document.getElementById('noSearchResult');
        if (noResult) noResult.style.display = (visible === 0 && q) ? '' : 'none';
    });
</script>
@endpush
