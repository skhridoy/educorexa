@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        {{-- Page Header --}}
        <div class="page-header-card mb-4">
            <div class="page-header-content">
                <h1 class="page-title"><i class="fa-solid fa-building-circle-gear me-2"></i> {{ __('School Settings') }}</h1>
                <p style="margin: 0; opacity: 0.85;">{{ __('Update and manage your institution\'s profile and credentials') }}</p>
            </div>
        </div>

        <div class="settings-tabs mb-4">
            <a href="{{ route('admin.school.info-edit', ['tenant' => auth()->user()->school->slug]) }}" class="settings-tab active">
                <i class="fa-solid fa-sliders me-2"></i> General
            </a>
            <a href="{{ route('admin.school.api-setup', ['tenant' => auth()->user()->school->slug]) }}" class="settings-tab">
                <i class="fa-solid fa-plug me-2"></i> API Setup
            </a>
            <a href="{{ route('admin.school.communication', ['tenant' => auth()->user()->school->slug]) }}" class="settings-tab">
                <i class="fa-solid fa-comments me-2"></i> Communication
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-card">
                    <form action="{{ route('admin.school.info-update', ['tenant' => auth()->user()->school->slug]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            {{-- Basic Info --}}
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-school me-2 text-primary opacity-50"></i> {{ __('School\'s Name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ $school->name }}" placeholder="Institutional Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-fingerprint me-2 text-primary opacity-50"></i> {{ __('EIN Number') }}</label>
                                <input type="text" name="ein_number" class="form-control" value="{{ $school->ein_number }}" placeholder="Institution EIN">
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-code me-2 text-primary opacity-50"></i> {{ __('EMIS Code') }}</label>
                                <input type="text" name="emis_code" class="form-control" value="{{ $school->emis_code }}" placeholder="Institution EMIS Code">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-qrcode me-2 text-primary opacity-50"></i> {{ __('App Code (Auto Generated)') }}</label>
                                <input type="text" class="form-control bg-light" value="{{ $school->app_code ?? 'N/A' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-envelope me-2 text-primary opacity-50"></i> {{ __('Official Email') }}</label>
                                <input type="email" name="email" class="form-control" value="{{ $school->email }}" placeholder="contact@school.edu">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-phone me-2 text-primary opacity-50"></i> {{ __('Phone Number') }}</label>
                                <input type="text" name="phone" class="form-control" value="{{ $school->phone }}" placeholder="+880 1XXX XXXXXX">
                            </div>

                            <div class="col-md-12">
                                <div class="section-divider"></div>
                            </div>

                            <div class="col-12">
                                <h6 class="fw-bold text-dark mb-1"><i class="fa-solid fa-map-location-dot me-2 text-primary"></i>School Location</h6>
                                <p class="text-muted small mb-3">Set the division, district and upazila for regional reporting.</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Division</label>
                                <select name="division" id="division" class="form-select" data-selected="{{ $school->division }}" >
                                    <option value="">Select division</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">District</label>
                                <select name="district" id="district" class="form-select" data-selected="{{ $school->district }}" disabled>
                                    <option value="">Select district</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Upazila</label>
                                <select name="upazila" id="upazila" class="form-select" data-selected="{{ $school->upazila }}" disabled>
                                    <option value="">Select upazila</option>
                                </select>
                            </div>

                            {{-- Assets --}}
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-image me-2 text-primary opacity-50"></i> {{ __('School Logo') }}</label>
                                <input type="file" name="logo" class="form-control">
                                @if($school->logo)
                                    <div class="img-preview-box mt-3">
                                        <img src="{{ asset($school->logo) }}" alt="Logo" style="height: 60px; width: auto; border-radius: 4px;">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fa-solid fa-icons me-2 text-primary opacity-50"></i> {{ __('Favicon (32x32)') }}</label>
                                <input type="file" name="favicon" class="form-control">
                                @if($school->favicon)
                                    <div class="img-preview-box mt-3">
                                        <img src="{{ asset($school->favicon) }}" alt="Favicon" style="height: 32px; width: 32px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label class="form-label"><i class="fa-solid fa-location-dot me-2 text-primary opacity-50"></i> {{ __('Institutional Address') }}</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Full street address, city, and zip code">{{ $school->address }}</textarea>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-primary-gradient px-5 py-3 shadow-lg" style="border-radius: 12px; font-weight: 700;">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> {{ __('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const division = document.getElementById('division');
    const district = document.getElementById('district');
    const upazila = document.getElementById('upazila');
    const routes = {
        divisions: @json(route('school.locations.divisions', ['tenant' => auth()->user()->school->slug])),
        districts: `${window.location.origin}/locations/districts`,
        upazilas: `${window.location.origin}/locations/upazilas`
    };

    const reset = (select, label) => {
        select.innerHTML = `<option value="">${label}</option>`;
        select.disabled = true;
    };
    const fill = (select, items, key, label, selected) => {
        reset(select, label);
        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item[key];
            option.textContent = item[`${key}_bn`] || item[key];
            option.selected = option.value === selected;
            select.appendChild(option);
        });
        select.disabled = false;
    };
    const request = url => fetch(url).then(response => {
        if (!response.ok) throw new Error('Location request failed');
        return response.json();
    });

    request(routes.divisions).then(data => {
        fill(division, data, 'name', 'Select division', division.dataset.selected);
        if (division.value) division.dispatchEvent(new Event('change'));
    });
    division.addEventListener('change', function () {
        reset(district, 'Select district');
        reset(upazila, 'Select upazila');
        if (!this.value) return;
        request(`${routes.districts}/${encodeURIComponent(this.value)}`).then(data => {
            fill(district, data, 'name', 'Select district', district.dataset.selected);
            if (district.value) district.dispatchEvent(new Event('change'));
        }).catch(error => console.error('District loading failed:', error));
    });
    district.addEventListener('change', function () {
        reset(upazila, 'Select upazila');
        if (!this.value) return;
        request(`${routes.upazilas}/${encodeURIComponent(this.value)}`).then(data => {
            fill(upazila, data, 'name', 'Select upazila', upazila.dataset.selected);
        }).catch(error => console.error('Upazila loading failed:', error));
    });
});
</script>
<style>
.settings-tabs { display:flex; gap:8px; padding:7px; background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; overflow-x:auto; }
.settings-tab { white-space:nowrap; padding:11px 18px; border-radius:10px; color:#64748b; font-size:.875rem; font-weight:700; text-decoration:none; transition:all .2s ease; }
.settings-tab:hover { color:#4f46e5; background:#eef2ff; }
.settings-tab.active { color:#fff; background:linear-gradient(135deg,#4f46e5,#7c3aed); box-shadow:0 4px 12px rgba(79,70,229,.25); }
</style>
@endsection