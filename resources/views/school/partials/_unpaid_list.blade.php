<div class="table-responsive">
    <table class="table align-middle mb-0" style="font-size: 13.5px;">
        <thead style="background: #fafbfc; border-bottom: 2px solid #f1f5f9;">
            <tr>
                <th class="ps-4 py-3 fw-bold text-uppercase" style="font-size: 11px; color: #64748b; letter-spacing: .5px;">{{ __('Student ID') }}</th>
                <th class="py-3 fw-bold text-uppercase" style="font-size: 11px; color: #64748b; letter-spacing: .5px;">{{ __('Student Name') }}</th>
                <th class="py-3 fw-bold text-uppercase" style="font-size: 11px; color: #64748b; letter-spacing: .5px;">{{ __('Class') }}</th>
                <th class="py-3 fw-bold text-uppercase" style="font-size: 11px; color: #64748b; letter-spacing: .5px;">{{ __('Due Amount') }}</th>
                <th class="py-3 fw-bold text-uppercase text-center pe-4" style="font-size: 11px; color: #64748b; letter-spacing: .5px;">{{ __('Action') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unpaidList as $invoice)
            <tr style="border-bottom: 1px solid #f8fafc; transition: background .15s;" onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background='transparent'">
                <td class="ps-4 py-3">
                    <span style="background: #eef2ff; color: #4f46e5; font-size: 11px; font-weight: 700; padding: 4px 12px; border-radius: 50px; border: 1px solid rgba(79,70,229,0.15);">
                        <i class="fa-solid fa-id-badge me-1 opacity-75"></i>{{ $invoice->student->student_id }}
                    </span>
                </td>
                <td class="py-3">
                    <div class="fw-bold text-dark" style="font-size: 13.5px;">
                        {{ (app()->getLocale() === 'bn' && $invoice->student->name_bn) ? $invoice->student->name_bn : $invoice->student->name }}
                    </div>
                    <div style="font-size: 11px; color: #94a3b8;">{{ $invoice->feeHead->name ?? __('General Fee') }}</div>
                </td>
                <td class="py-3">
                    <span style="background: #f5f3ff; color: #7c3aed; font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 50px;">
                        {{ $invoice->student->class->name ?? '-' }}
                    </span>
                </td>
                <td class="py-3">
                    <span class="fw-extrabold" style="color: #ef4444; font-size: 14px; font-weight: 800;">
                        ৳ {{ number_format($invoice->amount) }}
                    </span>
                </td>
                <td class="text-center pe-4 py-3">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                        <a href="{{ route('payment.index', ['tenant' => auth()->user()->school->slug, 'student_id' => $invoice->student->student_id]) }}"
                           class="btn btn-sm d-inline-flex align-items-center gap-1"
                           style="background: linear-gradient(135deg, #10b981, #059669); color: #fff; border: none; border-radius: 8px; padding: 5px 12px; font-size: 11.5px; font-weight: 700; box-shadow: 0 2px 8px rgba(16,185,129,0.3); text-decoration: none;"
                           title="{{ __('Collect Payment') }}">
                            <i class="fa-solid fa-hand-holding-dollar" style="font-size: 11px;"></i> {{ __('Collect') }}
                        </a>
                        <button class="btn btn-sm btn-send-reminder d-inline-flex align-items-center justify-content-center"
                                data-id="{{ $invoice->id }}"
                                style="width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #4f46e5; border: 1.5px solid #e2e8f0; transition: all .2s;"
                                onmouseover="this.style.background='#eef2ff';this.style.borderColor='#4f46e5'"
                                onmouseout="this.style.background='#f1f5f9';this.style.borderColor='#e2e8f0'"
                                title="Send SMS/Notice">
                            <i class="fa-solid fa-paper-plane" style="font-size: 11px;"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #dcfce7, #f0fdf4); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; box-shadow: 0 4px 14px rgba(16,185,129,0.15);">
                        <i class="fa-solid fa-circle-check" style="font-size: 26px; color: #10b981;"></i>
                    </div>
                    <h6 class="fw-bold text-dark mb-1" style="font-size: 15px;">{{ __('All Dues Cleared!') }}</h6>
                    <p class="text-muted small mb-0" style="font-size: 12.5px;">{{ __('All dues for this month have been paid successfully.') }}</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Ajax Pagination Wrapper --}}
@if($unpaidList->total() > 0)
<div class="pt-3 pb-2 px-3 d-flex flex-wrap justify-content-between align-items-center unpaid-pagination-wrapper gap-2" style="border-top: 1.5px solid #f1f5f9;">
    <div style="font-size: 12px; color: #64748b; font-weight: 500;">
        {{ __('Showing') }} <span class="fw-bold text-dark">{{ $unpaidList->firstItem() ?? 0 }}</span> {{ __('to') }} <span class="fw-bold text-dark">{{ $unpaidList->lastItem() ?? 0 }}</span> {{ __('of') }} <span class="fw-bold text-dark">{{ $unpaidList->total() }}</span> {{ __('results') }}
    </div>
    <div id="unpaidPaginationLinks">
        {!! $unpaidList->links('pagination::bootstrap-4') !!}
    </div>
</div>
@endif

<style>
    .unpaid-pagination-wrapper .pagination {
        margin-bottom: 0;
    }
    .unpaid-pagination-wrapper .page-link {
        padding: 4px 10px;
        font-size: 12px;
        border-radius: 8px;
        margin: 0 2px;
        border: 1.5px solid #e2e8f0;
        color: #475569;
    }
    .unpaid-pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-color: #4f46e5;
        color: #fff;
        box-shadow: 0 2px 8px rgba(79,70,229,0.3);
    }
</style>