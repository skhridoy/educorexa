<div class="table-responsive">
    <table class="table modern-table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-3 fw-bold text-uppercase fs-11 text-muted">{{ __('Roll') }}</th>
                <th class="fw-bold text-uppercase fs-11 text-muted">{{ __('Student Name') }}</th>
                <th class="fw-bold text-uppercase fs-11 text-muted">{{ __('Class') }}</th>
                <th class="fw-bold text-uppercase fs-11 text-muted text-end">{{ __('Amount') }}</th>
                <th class="fw-bold text-uppercase fs-11 text-muted text-center pe-3">{{ __('Status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $fee)
            <tr>
                <td class="ps-3 fw-bold text-primary">{{ $fee->student->roll ?? 'N/A' }}</td>
                <td>
                    <div class="fw-bold text-dark fs-13">{{ $fee->student->name }}</div>
                    <div class="text-muted fs-11">ID: {{ $fee->student->student_id }}</div>
                </td>
                <td>
                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill" style="font-size: 11px;">
                        {{ $fee->student->class->name ?? 'N/A' }}
                    </span>
                </td>
                <td class="text-end fw-bold text-dark fs-13">৳ {{ number_format($fee->amount, 2) }}</td>
                <td class="text-center pe-3">
                    @if($fee->isPaid())
                        <span class="badge bg-success-subtle text-success fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                            <i class="fa-solid fa-check me-1"></i> {{ __('Paid') }}
                        </span>
                    @else
                        <span class="badge bg-danger-subtle text-danger fw-bold px-3 py-1 rounded-pill" style="font-size: 11px;">
                            <i class="fa-solid fa-clock me-1"></i> {{ __('Unpaid') }}
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted small">
                    <i class="fa-solid fa-circle-info me-1 text-secondary"></i> {{ __('এই ফিল্টারে কোন তথ্য পাওয়া যায়নি।') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>