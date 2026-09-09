@extends('layouts.main')
@section('customCSS')
    @include('layouts._shared_styles')
    @include('layouts._section_edit_styles')
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') ?? '#' }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.frontend.index') }}">Frontend Sections</a></li>
        <li><span>/</span></li>
        <li class="active">Features</li>
    </ul>

    <div class="se-header">
        <div class="se-header__left">
            <div class="se-header__icon" style="background:linear-gradient(135deg,#ca8a04,#f59e0b);">
                <i class="bi bi-stars"></i>
            </div>
            <div>
                <h2 class="se-header__title">Features Section — Edit</h2>
                <p class="se-header__sub">ফিচার কার্ডগুলোর কন্টেন্ট ও আইকন কাস্টমাইজ করুন</p>
            </div>
        </div>
        <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="fms-alert fms-alert--success mb-3"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
    @endif

    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
        @csrf
        <div class="se-card">
            <div class="se-card__head">
                <span class="se-card__head-dot"></span>
                <h6 class="se-card__head-title">Section Header</h6>
                <span class="se-card__head-badge">Features</span>
            </div>
            <div class="se-card__body">
                <div class="row g-3 mb-2">
                    <div class="col-md-6">
                        <label class="se-label">Main Title <span>*</span></label>
                        <input type="text" name="title" class="se-input" value="{{ $content['title'] ?? '' }}" placeholder="Features section শিরোনাম">
                    </div>
                    <div class="col-md-6">
                        <label class="se-label">Description</label>
                        <input type="text" name="description" class="se-input" value="{{ $content['description'] ?? '' }}" placeholder="ছোট বিবরণ...">
                    </div>
                </div>

                <div class="se-section-label">
                    <span class="se-section-label__text">Feature Items — সর্বোচ্চ ৬টি</span>
                    <div class="se-section-label__line"></div>
                </div>

                @php $items = $content['items'] ?? []; @endphp
                <div class="row g-3">
                @for($i = 0; $i < 6; $i++)
                    @php $it = $items[$i] ?? ['icon'=>'language','title'=>'','desc'=>'']; @endphp
                    <div class="col-12">
                        <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 16px;background:#f8fbff;border-radius:12px;border:1px solid rgba(0,97,168,0.08);">
                            <div style="width:28px;height:28px;background:linear-gradient(135deg,#ca8a04,#f59e0b);color:#fff;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;flex-shrink:0;margin-top:24px;">{{ $i+1 }}</div>
                            <div class="row g-2 flex-grow-1" style="flex:1;">
                                <div class="col-sm-3">
                                    <label class="se-label">Icon (Material Symbol)</label>
                                    <input type="text" name="items[{{ $i }}][icon]" class="se-input" value="{{ $it['icon'] }}" placeholder="e.g. language">
                                    <span class="se-hint"><a href="https://fonts.google.com/icons" target="_blank" style="color:#0061A8;font-size:11px;">Icon নাম দেখুন →</a></span>
                                </div>
                                <div class="col-sm-4">
                                    <label class="se-label">Title</label>
                                    <input type="text" name="items[{{ $i }}][title]" class="se-input" value="{{ $it['title'] }}" placeholder="Feature শিরোনাম">
                                </div>
                                <div class="col-sm-5">
                                    <label class="se-label">Short Description</label>
                                    <input type="text" name="items[{{ $i }}][desc]" class="se-input" value="{{ $it['desc'] }}" placeholder="ছোট বিবরণ...">
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
                </div>
            </div>
            <div class="se-action-bar">
                <button type="submit" class="se-btn se-btn--primary"><i class="bi bi-floppy-fill"></i> Save Changes</button>
                <a href="{{ route('manage.frontend.index') }}" class="se-btn se-btn--secondary"><i class="bi bi-x-lg"></i> Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
