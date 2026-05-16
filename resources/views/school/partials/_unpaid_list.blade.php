<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="py-2">Student ID</th>
                <th class="py-2">Student Name</th>
                <th class="py-2">Class</th>
                <th class="py-2">Due Amount</th>
                <th class="py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($unpaidList as $invoice)
            <tr>
                <td><span class="badge bg-soft-secondary text-secondary">{{ $invoice->student->student_id }}</span></td>
                <td>
                    <div class="fw-bold text-dark">{{ $invoice->student->name }}</div>
                    <small class="text-muted">{{ $invoice->feeHead->name ?? 'General Fee' }}</small>
                </td>
                <td>{{ $invoice->student->class->name ?? '-' }}</td>
                <td>
                    <span class="text-danger fw-bolder">
                        ৳ {{ number_format($invoice->amount) }}
                    </span>
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-icon btn-outline-primary btn-send-reminder" data-id="{{ $invoice->id }}" title="Send SMS/Notice">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5">
                    <i class="fa-regular fa-face-smile d-block mb-2 fa-2x text-muted"></i>
                    <span class="text-muted">এই মাসের সকল বকেয়া পরিশোধিত হয়েছে!</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Ajax Pagination Wrapper --}}
<div class="mt-4 d-flex justify-content-between align-items-center unpaid-pagination-wrapper">
    <div class="small text-muted">
        Showing {{ $unpaidList->firstItem() }} to {{ $unpaidList->lastItem() }} of {{ $unpaidList->total() }} results
    </div>
    <div id="unpaidPaginationLinks">
        {!! $unpaidList->links('pagination::bootstrap-4') !!}
    </div>
</div>

<style>
    /* পেজিনেশন ডিজাইন একটু ক্লিন করার জন্য */
    .unpaid-pagination-wrapper .pagination {
        margin-bottom: 0;
    }
    .unpaid-pagination-wrapper .page-link {
        padding: 5px 12px;
        font-size: 13px;
    }
    .bg-soft-secondary {
        background-color: rgba(108, 117, 125, 0.15);
    }
</style>