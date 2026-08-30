<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-3 fw-bold">{{ __('Roll') }}</th>
                <th class="fw-bold">{{ __('Student Name') }}</th>
                <th class="fw-bold">{{ __('Class') }}</th>
                <th class="fw-bold text-end">{{ __('Amount') }}</th>
                <th class="fw-bold text-center pe-3">{{ __('Status') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($fees as $fee)
            <tr>
                <td class="ps-3 fw-600 text-indigo">{{ $fee->student->roll ?? 'N/A' }}</td>
                <td>
                    <div class="fw-bold text-dark">{{ $fee->student->name }}</div>
                    <div class="text-muted small">ID: {{ $fee->student->student_id }}</div>
                </td>
                <td><span class="badge bg-soft-secondary text-secondary">{{ $fee->student->class->name ?? 'N/A' }}</span></td>
                <td class="text-end fw-bold text-dark">৳ {{ number_format($fee->amount, 2) }}</td>
                <td class="text-center pe-3">
                    @if($fee->isPaid())
                        <span class="badge bg-soft-success text-success px-3">{{ __('Paid') }}</span>
                    @else
                        <span class="badge bg-soft-danger text-danger px-3">{{ __('Unpaid') }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5 text-muted italic small">
                    <i class="fa-solid fa-circle-info me-1"></i> এই ফিল্টারে কোন তথ্য পাওয়া যায়নি।
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>