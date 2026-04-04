@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Newsletter Subscribers</h6>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email Address</th>
                            <th>Subscribed At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscribers as $key => $row)
                        <tr>
                            <td>{{ $subscribers->firstItem() + $key }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->created_at->format('d M, Y') }}</td>
                            <td>
                                <form action="{{ route('admin.newsletter.destroy', ['tenant' => $tenant, 'id' => $row->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon btn-sm">
                                        <i data-feather="trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $subscribers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection