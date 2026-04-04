@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        {{-- Fee Setup Form --}}
        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Set Class-wise Fee Amount</h6>
                    <form action="{{ route('fee-amounts.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Select Fee Head</label>
                            <select name="fee_head_id" class="form-control" required>
                                <option value="" disabled selected>Choose a Fee Head...</option>
                                @foreach($feeHeads as $head)
                                    <option value="{{ $head->id }}">{{ $head->name }} ({{ ucfirst($head->type) }})</option>
                                @endforeach
                            </select>
                        </div>

                        <h6 class="mb-3 text-muted">Enter Amounts for Classes:</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Class Name</th>
                                        <th width="150">Amount (৳)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>
                                            <input type="number" name="amounts[{{ $class->id }}]" 
                                                   class="form-control form-control-sm" 
                                                   placeholder="0.00" step="0.01">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 w-100">Setup Fee Amount</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Existing Setup List --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Current Fee Structures</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fee Head</th>
                                    <th>Class</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feeAmounts as $setup)
                                <tr>
                                    <td><strong>{{ $setup->feeHead->name }}</strong></td>
                                    <td>{{ $setup->class->name }}</td>
                                    <td>৳ {{ number_format($setup->amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No fee setup found yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the fee head and may affect related settings!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }

    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        timer: 1500,
        showConfirmButton: false
    });
    @endif
    
    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}'
    });
    @endif
</script>
@endsection