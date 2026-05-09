<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-3 fw-bold">Roll</th>
                <th class="fw-bold">Student Name</th>
                <th class="fw-bold">Class</th>
                <th class="fw-bold text-end">Amount</th>
                <th class="fw-bold text-center pe-3">Status</th>
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
                        <span class="badge bg-soft-success text-success px-3">Paid</span>
                    @else
                        <span class="badge bg-soft-danger text-danger px-3">Unpaid</span>
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