@extends('layouts.main')
@section('customCSS')
@include('layouts._shared_styles')
<style>
    .domain-preview { background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:10px 15px; display:flex; align-items:center; justify-content:space-between; margin-top:10px; }
    .domain-url { font-family:monospace; color:#4f46e5; font-weight:700; font-size:0.9rem; }
    .input-group-edu { border-radius:10px !important; overflow:hidden; border:1px solid #e2e8f0; }
    .input-group-edu .form-control { border:none !important; }
    .input-group-edu .input-group-text { border:none !important; background:#f1f5f9; color:#64748b; font-weight:600; font-size:0.85rem; }
</style>
@endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li><a href="{{ route('manage.schools.all') }}">Schools</a></li>
        <li><span>/</span></li>
        <li class="active">Add New School</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-plus-circle me-2" style="color:#4f46e5;"></i> Register New School</h2>
            <p class="edu-page-sub">Onboard a new school tenant and setup their custom domain.</p>
        </div>
    </div>

    <form action="{{ route('manage.schools.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            {{-- School Info --}}
            <div class="col-lg-6">
                <div class="edu-panel h-100">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl">School Branding & Domain</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="mb-4">
                            <label class="edu-label">School Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" id="schoolNameId" class="form-control edu-input @error('school_name') is-invalid @enderror" placeholder="e.g. Greenhill International School" value="{{ old('school_name') }}" required>
                            @error('school_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="edu-label">Custom Subdomain <span class="text-danger">*</span></label>
                            <div class="input-group input-group-edu">
                                <input type="text" name="slug" id="slugId" class="form-control @error('slug') is-invalid @enderror" placeholder="greenhill" value="{{ old('slug') }}" required>
                                <span class="input-group-text">.{{ $mainDomain }}</span>
                            </div>
                            <div class="domain-preview">
                                <span style="font-size:0.75rem; color:#94a3b8; font-weight:600;">PREVIEW:</span>
                                <span class="domain-url" id="domainPreview">https://domain.{{ $mainDomain }}</span>
                            </div>
                            @error('slug') <p class="text-danger small mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin Info --}}
            <div class="col-lg-6">
                <div class="edu-panel h-100">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl">Administrator Access</h6>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="mb-3">
                            <label class="edu-label">Admin Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="admin_name" class="form-control edu-input @error('admin_name') is-invalid @enderror" placeholder="Enter name" value="{{ old('admin_name') }}" required>
                            @error('admin_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="edu-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="admin_email" class="form-control edu-input @error('admin_email') is-invalid @enderror" placeholder="admin@school.com" value="{{ old('admin_email') }}" required>
                            @error('admin_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="edu-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text" name="admin_mobile" class="form-control edu-input @error('admin_mobile') is-invalid @enderror" placeholder="017XXXXXXXX" maxlength="11" value="{{ old('admin_mobile') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="edu-label">Initial Password <span class="text-danger">*</span></label>
                                <div class="input-group input-group-edu">
                                    <input type="password" name="admin_password" id="passInput" class="form-control" placeholder="••••••••" required>
                                    <button class="input-group-text" type="button" id="togglePass" style="cursor:pointer; background:#fff; border-left:1px solid #f1f5f9;">
                                        <i data-feather="eye" style="width:14px;"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2">
                <a href="{{ route('manage.schools.index') }}" class="btn-edu btn-edu-light" style="padding:12px 30px;">Cancel</a>
                <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 40px;">
                    <i data-feather="check-circle" style="width:16px; margin-right:5px;"></i> Create School Platform
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('customJs')
<script>
    const nameInput = document.getElementById('schoolNameId');
    const slugInput = document.getElementById('slugId');
    const domainPreview = document.getElementById('domainPreview');
    const mainDomain = "{{ $mainDomain }}";

    function updatePreview() {
        domainPreview.innerText = `https://${slugInput.value || 'domain'}.${mainDomain}`;
    }

    nameInput.addEventListener('input', function() {
        let slug = this.value.toLowerCase().replace(/[^a-z0-9]/g, '').substring(0, 25);
        slugInput.value = slug;
        updatePreview();
    });

    slugInput.addEventListener('input', updatePreview);
    updatePreview();

    document.getElementById('togglePass').addEventListener('click', function() {
        const input = document.getElementById('passInput');
        const icon = this.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-feather', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-feather', 'eye');
        }
        feather.replace();
    });
</script>
@endsection