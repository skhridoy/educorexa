@extends('layouts.school')
@section('title', 'Communication Settings')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center">
        <div class="col-lg-8">
            <h3 class="mb-1 fw-bold text-dark">Communication Settings</h3>
            <p class="text-muted mb-0">Control email, SMS, and WhatsApp notifications dynamically for your school.</p>
        </div>
    </div>

    @php
        $canSendEmail = $school->hasPackagePermission('email.send') || $school->hasPackagePermission('professional_email'); // using common permission strings, adjust if needed
        $canSendSms = $school->hasPackagePermission('sms.send');
        $canSendWhatsapp = $school->hasPackagePermission('whatsapp.send');
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom p-4">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-list-check text-primary me-2"></i>Message Services</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush rounded-bottom-4">
                        @foreach($events as $key => $eventData)
                        <div class="list-group-item p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="d-flex align-items-center mb-3 mb-md-0">
                                <div class="icon-box bg-{{ $eventData['color'] }}-subtle text-{{ $eventData['color'] }} rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-size: 1.25rem;">
                                    <i class="fa-solid {{ $eventData['icon'] }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $eventData['title'] }}</h6>
                                    <p class="mb-0 text-muted small">{{ $eventData['description'] }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-wrap gap-3">
                                <!-- Quick Toggles -->
                                <div class="d-flex align-items-center gap-3 border-end pe-3">
                                    <div class="form-check form-switch mb-0" title="Email {{ $canSendEmail ? '' : '(Premium)' }}">
                                        <input class="form-check-input list-toggle" type="checkbox" data-event="{{ $key }}" data-type="email" {{ $setting->email_enabled ? 'checked' : '' }} {{ !$canSendEmail ? 'disabled' : '' }} style="cursor: pointer;">
                                        <label class="form-check-label small"><i class="fa-solid fa-envelope {{ $canSendEmail ? 'text-primary' : 'text-muted' }}"></i></label>
                                    </div>
                                    <div class="form-check form-switch mb-0" title="SMS {{ $canSendSms ? '' : '(Premium)' }}">
                                        <input class="form-check-input list-toggle" type="checkbox" data-event="{{ $key }}" data-type="sms" {{ $setting->sms_enabled ? 'checked' : '' }} {{ !$canSendSms ? 'disabled' : '' }} style="cursor: pointer;">
                                        <label class="form-check-label small"><i class="fa-solid fa-comment-sms {{ $canSendSms ? 'text-success' : 'text-muted' }}"></i></label>
                                    </div>
                                    <div class="form-check form-switch mb-0" title="WhatsApp {{ $canSendWhatsapp ? '' : '(Premium)' }}">
                                        <input class="form-check-input list-toggle" type="checkbox" data-event="{{ $key }}" data-type="whatsapp" {{ $setting->whatsapp_enabled ? 'checked' : '' }} {{ !$canSendWhatsapp ? 'disabled' : '' }} style="cursor: pointer;">
                                        <label class="form-check-label small"><i class="fa-brands fa-whatsapp {{ $canSendWhatsapp ? 'text-success' : 'text-muted' }}"></i></label>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#modal_{{ $key }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit Settings
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

<!-- Modals -->
@foreach($events as $key => $eventData)
@php $setting = $settings[$key]; @endphp
<div class="modal fade" id="modal_{{ $key }}" tabindex="-1" aria-labelledby="modalLabel_{{ $key }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="modalLabel_{{ $key }}"><i class="fa-solid {{ $eventData['icon'] }} text-{{ $eventData['color'] }} me-2"></i>{{ $eventData['title'] }} Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 position-relative">
                
                @if(!$canSendEmail && !$canSendSms)
                <!-- Premium Overlay -->
                <div class="position-absolute top-0 start-0 w-100 h-100 bg-white rounded-bottom-4 d-flex align-items-center justify-content-center" style="opacity: 0.95; z-index: 10;">
                    <div class="text-center p-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-crown fa-3x text-warning"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Premium Feature</h5>
                        <p class="text-muted mb-4 small">Upgrade your plan to unlock automated Email, SMS, and WhatsApp reminders.</p>
                        <a href="{{ route('school.pricing', ['tenant' => app('currentSchool')->slug]) }}" class="btn btn-primary btn-sm rounded-pill px-4 py-2">
                            <i class="fa-solid fa-rocket me-2"></i>Upgrade Plan
                        </a>
                    </div>
                </div>
                @endif

                <form class="communication-form" id="form_{{ $key }}">
                    @csrf
                    <input type="hidden" name="event" value="{{ $key }}">
                    
                    <!-- Channels Toggle -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center px-0">
                                    <label class="form-check-label fw-bold mb-0 small" for="emailToggle_{{ $key }}">
                                        <i class="fa-solid fa-envelope text-primary me-1"></i>Email
                                    </label>
                                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="emailToggle_{{ $key }}" name="email_enabled" value="1" {{ $setting->email_enabled ? 'checked' : '' }} {{ !$canSendEmail ? 'disabled' : '' }}>
                                </div>
                                @if(!$canSendEmail)
                                    <small class="text-danger mt-2 d-block" style="font-size: 0.75rem;"><i class="fa-solid fa-lock me-1"></i>Upgrade to enable</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center px-0">
                                    <label class="form-check-label fw-bold mb-0 small" for="smsToggle_{{ $key }}">
                                        <i class="fa-solid fa-comment-sms text-success me-1"></i>SMS
                                    </label>
                                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="smsToggle_{{ $key }}" name="sms_enabled" value="1" {{ $setting->sms_enabled ? 'checked' : '' }} {{ !$canSendSms ? 'disabled' : '' }}>
                                </div>
                                @if(!$canSendSms)
                                    <small class="text-danger mt-2 d-block" style="font-size: 0.75rem;"><i class="fa-solid fa-lock me-1"></i>Upgrade to enable</small>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-3 bg-light h-100">
                                <div class="form-check form-switch d-flex justify-content-between align-items-center px-0">
                                    <label class="form-check-label fw-bold mb-0 small" for="whatsappToggle_{{ $key }}">
                                        <i class="fa-brands fa-whatsapp text-success me-1"></i>WhatsApp
                                    </label>
                                    <input class="form-check-input ms-0" type="checkbox" role="switch" id="whatsappToggle_{{ $key }}" name="whatsapp_enabled" value="1" {{ $setting->whatsapp_enabled ? 'checked' : '' }} {{ !$canSendSms ? 'disabled' : '' }}>
                                </div>
                                @if(!$canSendSms)
                                    <small class="text-danger mt-2 d-block" style="font-size: 0.75rem;"><i class="fa-solid fa-lock me-1"></i>Upgrade to enable</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Variables Info -->
                    <div class="alert border-0 rounded-3 mb-4 bg-info-subtle text-info-emphasis">
                        <h6 class="fw-bold mb-2 small"><i class="fa-solid fa-circle-info me-2"></i>Dynamic Variables</h6>
                        <p class="small mb-2">Use the following tags in your templates. They will be automatically replaced when sending:</p>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($eventData['variables'] as $variable)
                            <span class="badge bg-white text-dark border">{{ $variable }}</span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Templates -->
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label fw-bold small">Email Template</label>
                            <textarea class="form-control" name="email_template" rows="4" placeholder="Enter email description..." {{ !$canSendEmail ? 'disabled' : '' }}>{{ $setting->email_template }}</textarea>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label fw-bold small">SMS Template</label>
                            <textarea class="form-control" name="sms_template" rows="3" placeholder="Enter short SMS message..." {{ !$canSendSms ? 'disabled' : '' }}>{{ $setting->sms_template }}</textarea>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label fw-bold small">WhatsApp Template</label>
                            <textarea class="form-control" name="whatsapp_template" rows="3" placeholder="Enter WhatsApp message..." {{ !$canSendSms ? 'disabled' : '' }}>{{ $setting->whatsapp_template }}</textarea>
                        </div>
                    </div>
                    
                    <div class="text-end mt-2">
                        <button type="button" class="btn btn-light px-4 py-2 rounded-pill fw-bold me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold btn-save" {{ (!$canSendEmail && !$canSendSms) ? 'disabled' : '' }}>
                            <i class="fa-solid fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Handle list quick toggles
        $('.list-toggle').on('change', function() {
            let eventKey = $(this).data('event');
            let type = $(this).data('type');
            let isChecked = $(this).is(':checked');
            
            // Sync the corresponding checkbox in the modal form
            $(`#${type}Toggle_${eventKey}`).prop('checked', isChecked);
            
            // Trigger the form submission
            $(`#form_${eventKey}`).submit();
        });

        // Handle form submissions
        $('.communication-form').on('submit', function(e) {
            e.preventDefault();
            
            let form = $(this);
            let btn = form.find('.btn-save');
            let originalText = btn.html();
            btn.html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...').prop('disabled', true);
            
            $.ajax({
                url: "{{ route('admin.school.communication.update', ['tenant' => app('currentSchool')->slug]) }}",
                type: 'POST',
                data: form.serialize(),
                success: function(res) {
                    btn.html(originalText).prop('disabled', false);
                    if(res.success) {
                        // Close modal if it's open
                        if (form.closest('.modal').hasClass('show')) {
                            form.closest('.modal').modal('hide');
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: res.message,
                            timer: 3000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end'
                        });
                    }
                },
                error: function(xhr) {
                    btn.html(originalText).prop('disabled', false);
                    let errorMsg = 'Failed to update settings.';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMsg
                    });
                }
            });
        });
    });
</script>
@endpush
