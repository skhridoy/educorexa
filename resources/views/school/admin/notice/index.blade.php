@extends('layouts.school')

@section('content')
    <div class="page-content">
        <div class="row">
            {{-- ক্রিয়েট নোটিশ ফর্ম --}}
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">নতুন নোটিশ তৈরি করুন</h6>
                        <form action="{{ route('notices.store') }}"
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">নোটিশের শিরোনাম</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" placeholder="Enter Notice Title" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="notice_date" class="form-label">তারিখ</label>
                                <input type="date" class="form-control" id="notice_date" name="notice_date" 
                                       value="{{ date('Y-m-d') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">বিস্তারিত (ঐচ্ছিক)</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="4" placeholder="Enter Notice Description"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="file" class="form-label">সংযুক্ত ফাইল (PDF/Image)</label>
                                <input type="file" class="form-control @error('file') is-invalid @enderror" 
                                       id="file" name="file">
                                <small class="text-muted">সর্বোচ্চ সাইজ: ২ এমবি</small>
                                @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">তৈরি করুন</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- নোটিশ লিস্ট টেবিল --}}
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">নোটিশ সমূহ</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>তারিখ</th>
                                        <th>শিরোনাম</th>
                                        <th>ফাইল</th>
                                        <th width="120">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notices as $notice)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($notice->notice_date)->format('d M, Y') }}</td>
                                            <td class="text-wrap" style="max-width: 250px;">{{ $notice->title }}</td>
                                            <td>
                                                @if($notice->file)
                                                    <a href="{{ asset($notice->file) }}" target="_blank" class="badge bg-info text-decoration-none">
                                                        <i class="fa-solid fa-download me-1"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted">No File</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{-- এডিট বাটন --}}
                                                <a href="{{ route('notices.edit', ['tenant' => auth()->user()->school->slug, 'notice' => $notice->id]) }}"
                                                   class="btn btn-sm btn-warning badge">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                {{-- ডিলিট বাটন --}}
                                                <form action="{{ route('notices.destroy', ['tenant' => auth()->user()->school->slug, 'notice' => $notice->id]) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)"
                                                            class="btn btn-sm btn-danger badge">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
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
                text: "Do you want to delete this notice?",
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