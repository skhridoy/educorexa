@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">

    {{-- Breadcrumb --}}
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">Frontend Sections</li>
    </ul>

    {{-- Page Header --}}
    <div class="fms-page-header">
        <div class="fms-page-header__left">
            <div class="fms-page-header__icon">
                <i class="bi bi-layout-text-window-reverse"></i>
            </div>
            <div>
                <h2 class="fms-page-header__title">Frontend Sections</h2>
                <p class="fms-page-header__sub">ওয়েবসাইটের হোমপেজের প্রতিটি সেকশন ম্যানেজ ও কাস্টমাইজ করুন</p>
            </div>
        </div>
        <div class="fms-page-header__right">
            <span class="fms-count-badge">
                <i class="bi bi-layers"></i>
                {{ $sections->count() }} টি সেকশন
            </span>
        </div>
    </div>

    {{-- Alert messages --}}
    @if(session('success'))
    <div class="fms-alert fms-alert--success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Sections Grid --}}
    <div class="fms-grid">
        @foreach($sections as $section)
        @php
            $icons = [
                'hero'         => 'bi-display',
                'about'        => 'bi-info-circle',
                'features'     => 'bi-stars',
                'why_choose_us'=> 'bi-patch-check',
                'testimonials' => 'bi-chat-quote',
                'pricing'      => 'bi-tags',
                'blogs'        => 'bi-newspaper',
                'contact'      => 'bi-envelope',
                'client'       => 'bi-people',
            ];
            $colors = [
                'hero'         => ['bg'=>'#dbeafe','color'=>'#2563eb'],
                'about'        => ['bg'=>'#dcfce7','color'=>'#16a34a'],
                'features'     => ['bg'=>'#fef9c3','color'=>'#ca8a04'],
                'why_choose_us'=> ['bg'=>'#e0f2fe','color'=>'#0284c7'],
                'testimonials' => ['bg'=>'#f3e8ff','color'=>'#9333ea'],
                'pricing'      => ['bg'=>'#ffedd5','color'=>'#ea580c'],
                'blogs'        => ['bg'=>'#fce7f3','color'=>'#db2777'],
                'contact'      => ['bg'=>'#dcfce7','color'=>'#16a34a'],
                'client'       => ['bg'=>'#e0f2fe','color'=>'#0284c7'],
            ];
            $icon  = $icons[$section->key]  ?? 'bi-layout-split';
            $color = $colors[$section->key] ?? ['bg'=>'#f1f5f9','color'=>'#64748b'];
        @endphp

        <div class="fms-card {{ $section->status ? '' : 'fms-card--inactive' }}">
            {{-- Card top line --}}
            <div class="fms-card__topline" style="background: {{ $color['color'] }};"></div>

            <div class="fms-card__body">
                {{-- Icon --}}
                <div class="fms-card__icon" style="background: {{ $color['bg'] }}; color: {{ $color['color'] }};">
                    <i class="bi {{ $icon }}"></i>
                </div>

                {{-- Info --}}
                <div class="fms-card__info">
                    <h4 class="fms-card__title">{{ $section->title }}</h4>
                    <code class="fms-card__key">{{ $section->key }}</code>
                </div>

                {{-- Order badge --}}
                <span class="fms-card__order">#{{ $section->order }}</span>
            </div>

            {{-- Footer --}}
            <div class="fms-card__footer">
                {{-- Status toggle --}}
                <label class="fms-toggle" title="{{ $section->status ? 'Active' : 'Inactive' }}">
                    <input type="checkbox"
                           class="fms-toggle__input status-toggle"
                           data-id="{{ $section->id }}"
                           {{ $section->status ? 'checked' : '' }}>
                    <span class="fms-toggle__slider"></span>
                    <span class="fms-toggle__label">{{ $section->status ? 'Active' : 'Inactive' }}</span>
                </label>

                {{-- Edit button --}}
                <a href="{{ route('manage.frontend.edit', $section->id) }}"
                   class="fms-edit-btn" title="Edit Section">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

</div>

<style>
/* ============================================================
   FRONTEND MANAGE SECTIONS — Premium Card Grid Design
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap');

.fms-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}
.fms-page-header__left {
    display: flex; align-items: center; gap: 14px;
}
.fms-page-header__icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff;
    box-shadow: 0 6px 18px rgba(0,97,168,0.3);
    flex-shrink: 0;
}
.fms-page-header__title {
    font-family: 'Poppins', sans-serif;
    font-size: 1.4rem; font-weight: 800;
    color: #1e293b; margin: 0;
    letter-spacing: -0.3px;
}
.fms-page-header__sub {
    font-size: 0.83rem; color: #64748b;
    margin: 3px 0 0; font-weight: 400;
}
.fms-count-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: #e8f3fb;
    color: #0061A8;
    font-size: 13px; font-weight: 700;
    padding: 7px 16px; border-radius: 50px;
    border: 1px solid rgba(0,97,168,0.2);
    white-space: nowrap;
}

.fms-alert {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 18px; border-radius: 12px;
    font-size: 0.875rem; font-weight: 600;
    margin-bottom: 22px;
}
.fms-alert--success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a;
}

/* ---- Card Grid ---- */
.fms-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 18px;
}

/* ---- Section Card ---- */
.fms-card {
    background: #fff;
    border-radius: 18px;
    border: 1.5px solid rgba(0,97,168,0.08);
    box-shadow: 0 4px 20px rgba(0,97,168,0.06);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
    display: flex; flex-direction: column;
    font-family: 'Poppins', sans-serif;
    position: relative;
}
.fms-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 44px rgba(0,97,168,0.14);
    border-color: rgba(0,97,168,0.18);
}
.fms-card--inactive {
    opacity: 0.65;
    filter: grayscale(0.35);
}
.fms-card--inactive:hover { opacity: 0.85; filter: none; }

/* Top accent line */
.fms-card__topline {
    height: 3px;
    width: 100%;
}

.fms-card__body {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 20px 20px 14px;
    flex: 1;
}

.fms-card__icon {
    width: 48px; height: 48px;
    border-radius: 13px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    transition: transform 0.3s;
}
.fms-card:hover .fms-card__icon {
    transform: scale(1.12) rotate(-5deg);
}

.fms-card__info { flex: 1; min-width: 0; }
.fms-card__title {
    font-size: 14.5px; font-weight: 700;
    color: #1e293b; margin: 0 0 5px;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.fms-card__key {
    background: #f1f5f9;
    color: #64748b;
    font-size: 10.5px;
    padding: 2px 7px;
    border-radius: 5px;
    font-weight: 600;
    font-family: 'Courier New', monospace;
}

.fms-card__order {
    font-size: 11px; font-weight: 800;
    color: #cbd5e1;
    letter-spacing: 0.5px;
    flex-shrink: 0;
}

/* Card footer */
.fms-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px 18px;
    border-top: 1px solid #f8fafc;
    gap: 10px;
}

/* Toggle switch */
.fms-toggle {
    display: flex; align-items: center; gap: 8px;
    cursor: pointer; user-select: none;
    margin: 0;
}
.fms-toggle__input { display: none; }
.fms-toggle__slider {
    width: 40px; height: 22px;
    background: #e2e8f0;
    border-radius: 50px;
    position: relative;
    transition: background 0.28s;
    flex-shrink: 0;
}
.fms-toggle__slider::after {
    content: '';
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 4px rgba(0,0,0,0.2);
    transition: transform 0.28s;
}
.fms-toggle__input:checked + .fms-toggle__slider {
    background: #0061A8;
}
.fms-toggle__input:checked + .fms-toggle__slider::after {
    transform: translateX(18px);
}
.fms-toggle__label {
    font-size: 12px; font-weight: 600;
    color: #64748b;
    min-width: 44px;
}

/* Edit button — icon only */
.fms-edit-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 36px; height: 36px;
    background: linear-gradient(135deg, #0061A8, #0080d4);
    color: #fff !important;
    border-radius: 10px;
    font-size: 15px;
    text-decoration: none;
    transition: all 0.25s;
    box-shadow: 0 3px 10px rgba(0,97,168,0.28);
    flex-shrink: 0;
}
.fms-edit-btn:hover {
    background: linear-gradient(135deg, #004c84, #0061A8);
    transform: translateY(-2px) scale(1.08);
    box-shadow: 0 6px 18px rgba(0,97,168,0.4);
    color: #fff !important; text-decoration: none;
}

/* ---- Responsive ---- */
@media (max-width: 767px) {
    .fms-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .fms-page-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .fms-card__body { padding: 16px 14px 10px; gap: 10px; }
    .fms-card__icon { width: 40px; height: 40px; font-size: 18px; border-radius: 10px; }
    .fms-card__title { font-size: 13px; }
    .fms-card__footer { padding: 10px 14px 14px; }
}
@media (max-width: 479px) {
    .fms-grid { grid-template-columns: 1fr; }
}
</style>
@endsection

@section('customJs')
<script>
$(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Toggle status-label text on checkbox change
    function updateLabel($toggle) {
        const $label = $toggle.closest('.fms-toggle').find('.fms-toggle__label');
        $label.text($toggle.is(':checked') ? 'Active' : 'Inactive');
    }

    $('.status-toggle').on('change', function() {
        const $toggle  = $(this);
        const isChecked = $toggle.prop('checked');
        updateLabel($toggle);

        $.ajax({
            type: 'POST',
            url: "{{ route('manage.frontend.update.status') }}",
            data: { id: $toggle.data('id'), status: isChecked ? 1 : 0 },
            success: function(data) {
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end',
                    showConfirmButton: false, timer: 3000, timerProgressBar: true,
                });
                Toast.fire({ icon: 'success', title: data.message });
            },
            error: function() {
                $toggle.prop('checked', !isChecked);
                updateLabel($toggle);
                Swal.fire({ icon: 'error', title: 'Error!', text: 'Status update failed.' });
            }
        });
    });
});
</script>
@endsection