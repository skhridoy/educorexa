@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Messages</h6> 
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th width="150">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $message)
                                    <tr>
                                        <td>{{ $message->id }}</td>
                                        <td>{{ $message->name }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->phone }}</td>
                                        <td>{{ $message->message }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <button type="button" class="btn btn-primary btn-icon btn-sm me-2" 
                                                        data-bs-toggle="modal" data-bs-target="#viewMessage{{ $message->id }}" title="View">
                                                    <i class="link-icon" data-feather="eye"></i>
                                                </button>

                                                <form action="{{ route('admin.message.destroy', ['tenant' => auth()->user()->school->slug, 'id' => $message->id]) }}" 
                                                    method="POST" 
                                                    id="delete-form-{{ $message->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-icon btn-sm" title="Delete" onclick="confirmDelete({{ $message->id }})">
                                                        <i class="link-icon" data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <div class="modal fade" id="viewMessage{{ $message->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Message from {{ $message->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><strong>Phone:</strong> {{ $message->phone }}</p>
                                                            <p><strong>Email:</strong> {{ $message->email }}</p>
                                                            <hr>
                                                            <p><strong>Message:</strong></p>
                                                            <p class="text-muted">{{ $message->message }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
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
    function confirmDelete(id) {
        Swal.fire({
            title: 'আপনি কি নিশ্চিত?',
            text: "এটি ডিলিট করলে আর ফিরে পাওয়া যাবে না!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'হ্যাঁ, ডিলিট করুন!',
            cancelButtonText: 'বাতিল'
        }).then((result) => {
            if (result.isConfirmed) {
                // নির্দিষ্ট আইডি অনুযায়ী ফর্ম সাবমিট
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection