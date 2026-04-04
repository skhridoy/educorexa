@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            {{-- Create Fee Head Form --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Create Fee Head</h6>
                        <form action="{{ route('fee-heads.store', ['tenant' => auth()->user()->school->slug]) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Admission Fee" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Fee Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="" disabled selected>Select Type</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="once">Once</option>
                                    <option value="recurring">Recurring</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Head</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Fee Heads List Table --}}
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Fee Heads List</h6>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Fee Type</th>
                                        <th width="100">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($feeHeads as $feeHead)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $feeHead->name }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ ucfirst($feeHead->type) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('fee-heads.edit', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                                   class="btn btn-sm btn-warning badge">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                {{-- Delete Button --}}
                                                <form action="{{ route('fee-heads.destroy', ['tenant' => auth()->user()->school->slug, 'fee_head' => $feeHead->id]) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)"
                                                            class="btn btn-sm btn-danger badge">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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