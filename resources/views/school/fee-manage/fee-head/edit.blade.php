@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        
                        <h6 class="card-title">Update Fee Head</h6>
                        <form action="{{ route('fee-heads.update', ['tenant' => auth()->user()->school->slug, 'fee_head' => $fee_head->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ex: Admission Fee" value="{{ $fee_head->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Fee Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="" default selected>Select Type</option>
                                    <option value="monthly" {{ $fee_head->type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="once" {{ $fee_head->type == 'once' ? 'selected' : '' }}>Once</option>
                                    <option value="recurring" {{ $fee_head->type == 'recurring' ? 'selected' : '' }}>Recurring</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-end">Update</button>
                            <a href="{{ route('fee-heads.index', ['tenant' => auth()->user()->school->slug]) }}" class="btn btn-secondary btn-end">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Fee Head List</h6>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Fee Type</th>
                                        <th>Description</th>
                                        <th width="150">Action</th>
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
        text: "Do you want to delete this subject?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel',

    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form
            button.closest('form').submit();

        }
    })
}
@if(session('success'))
Swal.fire({
    icon: '{{ session('type', 'success') }}',
    title: 'Success!',
    text: '{{ session('success') }}',
    timer: 1500,
    showConfirmButton: false
});
@endif
</script>
@endsection