<style>
.unpaid-table-wrap {
    width: 100%;
}
.student-avatar-ring {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 1.5px solid #e2e8f0;
    flex-shrink: 0;
}
.student-name-text {
    font-weight: 700;
    font-size: 0.84rem;
    color: #1e293b;
    line-height: 1.25;
}
[data-bs-theme="dark"] .student-name-text, body.dark-mode .student-name-text {
    color: #f8fafc !important;
}
.student-id-text {
    font-weight: 600;
    font-size: 0.78rem;
    color: #4f46e5;
}
[data-bs-theme="dark"] .student-id-text, body.dark-mode .student-id-text {
    color: #818cf8 !important;
}
.student-meta-sub {
    font-size: 0.72rem;
    color: #64748b;
}
[data-bs-theme="dark"] .student-meta-sub, body.dark-mode .student-meta-sub {
    color: #94a3b8 !important;
}
.unpaid-table {
    min-width: 620px !important;
    display: table !important;
}
</style>

@if($unpaidList->count() > 0)
<div class="table-responsive unpaid-table-wrap">
    <table class="table edu-table unpaid-table align-middle mb-0 text-nowrap">
        <thead>
            <tr>
                <th class="ps-3">{{ __('Student Info') }}</th>
                <th>{{ __('ID & Roll') }}</th>
                <th>{{ __('Class & Section') }}</th>
                <th>{{ __('Due Amount') }}</th>
                <th class="text-center pe-3">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unpaidList as $invoice)
            <tr>
                <td class="ps-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $invoice->student->photo ? asset($invoice->student->photo) : asset('assets/images/profile.webp') }}" 
                             alt="{{ $invoice->student->name }}" class="student-avatar-ring me-2.5">
                        <div>
                            <div class="student-name-text">
                                {{ (app()->getLocale() === 'bn' && $invoice->student->name_bn) ? $invoice->student->name_bn : $invoice->student->name }}
                            </div>
                            <div class="student-meta-sub">
                                {{ $invoice->feeHead->name ?? __('General Fee') }}
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="student-id-text mb-0.5">{{ $invoice->student->student_id }}</div>
                    <div class="student-meta-sub">Roll: {{ $invoice->student->roll ?? 'N/A' }}</div>
                </td>
                <td>
                    <div class="fw-bold text-primary mb-0.5" style="font-size: 0.8rem;">
                        <i class="fa-solid fa-graduation-cap me-1 opacity-75"></i>{{ $invoice->student->class?->name ?? '-' }}
                    </div>
                    <div class="student-meta-sub">
                        Sec: {{ $invoice->student->section?->name ?? 'N/A' }}
                    </div>
                </td>
                <td>
                    <div class="fw-bold text-danger mb-0.5" style="font-size: 0.86rem;">
                        ৳{{ number_format($invoice->amount) }}
                    </div>
                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-1.5 py-0.5" style="font-size:9.5px; font-weight:600;">Unpaid</span>
                </td>
                <td class="text-center pe-3">
                    <div class="d-flex justify-content-center align-items-center gap-1.5">
                        <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug, 'student_id' => $invoice->student->student_id]) }}"
                           class="btn-collect-outline"
                           style="border: 1.5px solid #10b981 !important; color: #10b981 !important; background: transparent !important; border-radius: 5px !important; font-weight: 600 !important; font-size: 0.78rem !important; height: 30px !important; padding: 0 10px !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; text-decoration: none !important; gap: 5px;"
                           title="{{ __('Collect Payment') }}">
                            <i class="fa-solid fa-hand-holding-dollar" style="color: #10b981;"></i> {{ __('Collect') }}
                        </a>
                        <button class="btn-icon-sm btn-reminder-outline btn-send-reminder"
                                data-id="{{ $invoice->id }}"
                                style="width: 30px !important; height: 30px !important; border-radius: 5px !important; border: 1.5px solid #cbd5e1 !important; color: #64748b !important; background: transparent !important; display: inline-flex !important; align-items: center !important; justify-content: center !important;"
                                title="Send SMS/Notice">
                            <i class="fa-solid fa-paper-plane" style="font-size: 11px;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Ajax Pagination Wrapper --}}
<div class="pt-3 pb-2 px-3 d-flex flex-wrap justify-content-between align-items-center unpaid-pagination-wrapper gap-2 border-top">
    <div style="font-size: 0.74rem; color: #64748b; font-weight: 500;">
        {{ __('Showing') }} <span class="fw-bold text-dark">{{ $unpaidList->firstItem() ?? 0 }}</span> {{ __('to') }} <span class="fw-bold text-dark">{{ $unpaidList->lastItem() ?? 0 }}</span> {{ __('of') }} <span class="fw-bold text-dark">{{ $unpaidList->total() }}</span> {{ __('results') }}
    </div>
    <div id="unpaidPaginationLinks">
        {!! $unpaidList->links('pagination::bootstrap-4') !!}
    </div>
</div>

@else
{{-- Empty State --}}
<div class="text-center py-5">
    <div style="width: 50px; height: 50px; background: rgba(16,185,129,0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
        <i class="fa-solid fa-circle-check" style="font-size: 22px; color: #10b981;"></i>
    </div>
    <h6 class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">{{ __('All Dues Cleared!') }}</h6>
    <p class="text-muted small mb-0">{{ __('All dues for this month have been paid successfully.') }}</p>
</div>
@endif

<style>
    .unpaid-pagination-wrapper .pagination {
        margin-bottom: 0;
    }
    .unpaid-pagination-wrapper .page-link {
        padding: 3px 8px;
        font-size: 0.74rem;
        border-radius: 5px;
        margin: 0 2px;
        border: 1.5px solid #e2e8f0;
        color: #475569;
        background: transparent;
    }
    .unpaid-pagination-wrapper .page-item.active .page-link {
        background: transparent !important;
        border: 1.5px solid #4f46e5 !important;
        color: #4f46e5 !important;
        box-shadow: none !important;
    }
</style>