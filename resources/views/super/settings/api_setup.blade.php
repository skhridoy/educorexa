@extends('layouts.main')
@section('customCSS') @include('layouts._shared_styles') @endsection

@section('content')
<div class="page-content">
    <ul class="edu-bc">
        <li><a href="{{ route('super.dashboard') }}">Dashboard</a></li>
        <li><span>/</span></li>
        <li class="active">API Setup</li>
    </ul>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="edu-page-title"><i class="fa-solid fa-plug me-2" style="color:#4f46e5;"></i> System API Setup</h2>
            <p class="edu-page-sub">Configure global APIs like SMTP, SMS gateways, and other 3rd party integrations.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="edu-alert-success">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="edu-panel">
        <div class="edu-panel-hd">
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">This replaces the .env file configurations for global email sending.</p>
        </div>
        <div class="edu-panel-bd">
            <form id="global-api-form" action="{{ route('settings.api.update') }}" method="POST">
                @csrf
                
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="edu-label">Mail Mailer</label>
                        <select name="mail_mailer" class="form-select edu-input">
                            <option value="smtp" {{ ($setting->mail_mailer ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                            <option value="sendmail" {{ ($setting->mail_mailer ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                            <option value="log" {{ ($setting->mail_mailer ?? '') == 'log' ? 'selected' : '' }}>Log</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">Mail Host</label>
                        <input type="text" name="mail_host" class="form-control edu-input" value="{{ $setting->mail_host ?? '' }}" placeholder="mail.educorexa.com">
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">Mail Port</label>
                        <input type="number" name="mail_port" class="form-control edu-input" value="{{ $setting->mail_port ?? 465 }}" placeholder="465">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Mail Username</label>
                        <input type="text" name="mail_username" class="form-control edu-input" value="{{ $setting->mail_username ?? '' }}" placeholder="support@educorexa.com">
                    </div>
                    <div class="col-md-6">
                        <label class="edu-label">Mail Password</label>
                        <div class="input-group">
                            <input type="password" name="mail_password" class="form-control edu-input" value="{{ $setting->mail_password ?? '' }}" placeholder="Leave empty to keep current password">
                            <button class="btn btn-outline-secondary" type="button" onclick="const p = this.previousElementSibling; p.type = p.type === 'password' ? 'text' : 'password';"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">Mail Encryption</label>
                        <select name="mail_encryption" class="form-select edu-input">
                            <option value="ssl" {{ ($setting->mail_encryption ?? 'ssl') == 'ssl' ? 'selected' : '' }}>SSL</option>
                            <option value="tls" {{ ($setting->mail_encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="" {{ ($setting->mail_encryption ?? '') == '' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">From Address</label>
                        <input type="email" name="mail_from_address" class="form-control edu-input" value="{{ $setting->mail_from_address ?? '' }}" placeholder="support@educorexa.com">
                    </div>
                    <div class="col-md-4">
                        <label class="edu-label">From Name</label>
                        <input type="text" name="mail_from_name" class="form-control edu-input" value="{{ $setting->mail_from_name ?? '' }}" placeholder="EduCorexa">
                    </div>
                </div>

                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd">
                        <h6 class="edu-panel-ttl">Company Incoming Email Webhook</h6>
                        <p class="mb-0 text-muted" style="font-size: 0.85rem;">Receive emails sent to the company main email in the Super Admin inbox.</p>
                    </div>
                    <div class="edu-panel-bd">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="inbound_webhook_enabled" value="1" form="global-api-form" {{ $setting->inbound_webhook_enabled ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold">Enable company inbox</label>
                        </div>
                        <label class="edu-label">Webhook Secret</label>
                        <input type="password" name="inbound_webhook_secret" class="form-control edu-input" form="global-api-form" placeholder="Leave empty to keep current secret">
                        <small class="text-muted d-block mt-2">Webhook URL: {{ url('/webhooks/inbound-email') }} | Header: <code>X-Inbound-Mail-Secret</code></small>
                    </div>
                </div>

                <div class="edu-panel mb-4">
                    <div class="edu-panel-hd"><h6 class="edu-panel-ttl">Company IMAP Inbox</h6><p class="mb-0 text-muted" style="font-size:0.85rem;">Fetch incoming company email from an IMAP mailbox.</p></div>
                    <div class="edu-panel-bd"><div class="form-check form-switch mb-3"><input class="form-check-input" type="checkbox" name="imap_enabled" value="1" form="global-api-form" {{ $setting->imap_enabled ? 'checked' : '' }}><label class="form-check-label fw-semibold">Enable IMAP polling</label></div><div class="row g-3"><div class="col-md-6"><label class="edu-label">Incoming Server</label><input type="text" name="imap_host" form="global-api-form" class="form-control edu-input" value="{{ $setting->imap_host ?? 'mail.educorexa.com' }}" placeholder="mail.educorexa.com"></div><div class="col-md-2"><label class="edu-label">Port</label><input type="number" name="imap_port" form="global-api-form" class="form-control edu-input" value="{{ $setting->imap_port ?? 993 }}"></div><div class="col-md-4"><label class="edu-label">Security</label><select name="imap_encryption" form="global-api-form" class="form-select edu-input"><option value="ssl" @selected(($setting->imap_encryption ?? 'ssl') === 'ssl')>SSL/TLS</option><option value="tls" @selected($setting->imap_encryption === 'tls')>TLS</option><option value="none" @selected($setting->imap_encryption === 'none')>None</option></select></div><div class="col-md-6"><label class="edu-label">Username</label><input type="email" name="imap_username" form="global-api-form" class="form-control edu-input" value="{{ $setting->imap_username ?? 'info@educorexa.com' }}"></div><div class="col-md-6"><label class="edu-label">Password</label><input type="password" name="imap_password" form="global-api-form" class="form-control edu-input" placeholder="Enter the email account password"></div><div class="col-md-6"><label class="edu-label">Folder</label><input type="text" name="imap_folder" form="global-api-form" class="form-control edu-input" value="{{ $setting->imap_folder ?? 'INBOX' }}"></div></div></div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn-edu btn-edu-primary" style="padding:12px 36px;">
                        <i data-feather="save" style="width:16px; height:16px;"></i> Save API Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
