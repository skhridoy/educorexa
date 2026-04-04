{{-- resources/views/school/partials/_unpaid_list.blade.php --}}
<div class="table-responsive">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Class</th>
                <th>Due</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unpaidList as $invoice)
            <tr>
                <td>{{ $invoice->student->student_id }}</td>
                <td>{{ $invoice->student->name }}</td>
                <td>{{ $invoice->student->class->name ?? '-' }}</td>
                <td class="text-danger fw-bold">৳{{ number_format($invoice->amount - $invoice->paid_amount) }}</td>
                <td>
                    <button class="btn btn-xs btn-outline-primary">
                        <i class="fa-solid fa-paper-plane me-1"></i>Notice
                    </button>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center py-4">No unpaid records found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>