@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h4 class="card-title mb-0 fw-bold text-primary">
                            <i class="fa-solid fa-gears me-2"></i> API & Professional Account Setup
                        </h4>
                        <p class="text-muted small mb-0">Configure your professional SMTP and WhatsApp settings for automated notifications.</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.school.api-setup.update') }}" method="POST">
                            @csrf
                            
                            <div class="row g-4">
                                {{-- SMTP Settings Section --}}
                                <div class="col-lg-7">
                                    <div class="p-4 bg-light rounded-4 h-100">
                                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">
                                            <i class="fa-solid fa-envelope-open-text me-2 text-primary"></i> Professional Email (SMTP)
                                        </h5>
                                        
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-semibold">Mail Mailer</label>
                                                <select name="mail_mailer" class="form-select">
                                                    <option value="smtp" {{ $school->mail_mailer == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                                    <option value="mailgun" {{ $school->mail_mailer == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                                    <option value="sendmail" {{ $school->mail_mailer == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                                </select>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label fw-semibold">Mail Host</label>
                                                <input type="text" name="mail_host" class="form-control" value="{{ $school->mail_host }}" placeholder="e.g. mail.domain.com">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Port</label>
                                                <input type="text" name="mail_port" class="form-control" value="{{ $school->mail_port }}" placeholder="465">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label fw-semibold">Encryption</label>
                                                <select name="mail_encryption" class="form-select">
                                                    <option value="ssl" {{ $school->mail_encryption == 'ssl' ? 'selected' : '' }}>SSL</option>
                                                    <option value="tls" {{ $school->mail_encryption == 'tls' ? 'selected' : '' }}>TLS</option>
                                                    <option value="" {{ $school->mail_encryption == '' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Username</label>
                                                <input type="text" name="mail_username" class="form-control" value="{{ $school->mail_username }}" placeholder="support@domain.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Password</label>
                                                <div class="input-group">
                                                    <input type="password" name="mail_password" class="form-control" value="{{ $school->mail_password }}" id="smtp_pass">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('smtp_pass')">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">From Address</label>
                                                <input type="email" name="mail_from_address" class="form-control" value="{{ $school->mail_from_address }}" placeholder="noreply@domain.com">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">From Name</label>
                                                <input type="text" name="mail_from_name" class="form-control" value="{{ $school->mail_from_name }}" placeholder="School Name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- WhatsApp Settings Section --}}
                                <div class="col-lg-5">
                                    <div class="p-4 bg-light rounded-4 h-100">
                                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-2">
                                            <i class="fa-brands fa-whatsapp me-2 text-success"></i> WhatsApp API Setup
                                        </h5>
                                        
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">API Provider</label>
                                                <select name="whatsapp_api_provider" class="form-select">
                                                    <option value="ultramsg" {{ $school->whatsapp_api_provider == 'ultramsg' ? 'selected' : '' }}>UltraMsg (Recommended)</option>
                                                    <option value="twilio" {{ $school->whatsapp_api_provider == 'twilio' ? 'selected' : '' }}>Twilio</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">Instance ID</label>
                                                <input type="text" name="whatsapp_api_instance_id" class="form-control" value="{{ $school->whatsapp_api_instance_id }}" placeholder="e.g. instance12345">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label fw-semibold">API Token / Secret</label>
                                                <div class="input-group">
                                                    <input type="password" name="whatsapp_api_key" class="form-control" value="{{ $school->whatsapp_api_key }}" id="wa_key">
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass('wa_key')">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-4">
                                                <div class="alert alert-info border-0 shadow-sm small">
                                                    <i class="fa-solid fa-circle-info me-2"></i>
                                                    Once configured, system will automatically use these credentials to send notices and attendance alerts.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 text-end">
                                <hr class="opacity-10 mb-4">
                                <button type="submit" class="btn btn-primary-gradient px-5 py-3 rounded-pill fw-bold shadow-lg">
                                    <i class="fa-solid fa-cloud-arrow-up me-2"></i> Save All API Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function togglePass(id) {
        let x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Updated!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#4f46e5',
            timer: 2500
        });
    @endif
</script>
@endsection
