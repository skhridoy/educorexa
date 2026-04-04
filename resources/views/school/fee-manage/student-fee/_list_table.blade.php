<table class="table table-hover table-bordered border-light">
    <thead class="bg-light text-dark">
        <tr>
            <th class="fw-bold">Roll</th>
            <th class="fw-bold">Student Name</th>
            <th class="fw-bold">Class</th>
            <th class="fw-bold text-end">Amount</th>
            <th class="fw-bold text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fees as $fee)
        <tr>
            <td>{{ $fee->student->roll ?? 'N/A' }}</td>
            <td>{{ $fee->student->name }}</td>
            <td>{{ $fee->student->class->name ?? 'N/A' }}</td>
            <td class="text-end">৳ {{ number_format($fee->amount, 2) }}</td>
            <td class="text-center">
                @if($fee->isPaid())
                    <span class="badge bg-success-subtle text-success border border-success px-3">Paid</span>
                @else
                    <span class="badge bg-danger-subtle text-danger border border-danger px-3">Unpaid</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center py-4 text-muted">
                <i class="fa-solid fa-circle-info me-1"></i> এই ফিল্টারে কোন তথ্য পাওয়া যায়নি।
            </td>
        </tr>
        @endforelse
    </tbody>
</table>