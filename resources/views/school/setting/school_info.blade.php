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