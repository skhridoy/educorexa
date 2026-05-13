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
                                        <th>ডিস্ট্রিবিউশন</th>
                                        <th width="100">অ্যাকশন</th>
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
                                                <div class="btn-group gap-1">
                                                    {{-- ইমেইল পাঠানোর বাটন --}}
                                                    <form action="{{ route('notices.send', ['tenant' => auth()->user()->school->slug, 'id' => $notice->id]) }}" method="POST" class="send-form">
                                                        @csrf
                                                        <input type="hidden" name="method_type" value="email">
                                                        <button type="button" onclick="confirmSend(this, 'Email')" class="btn btn-sm btn-outline-primary" style="padding: 2px 8px;" title="Send via Email">
                                                            <i class="fa-solid fa-envelope"></i>
                                                        </button>
                                                    </form>
                                                    
                                                    {{-- হোয়াটসঅ্যাপ পাঠানোর বাটন --}}
                                                    <form action="{{ route('notices.send', ['tenant' => auth()->user()->school->slug, 'id' => $notice->id]) }}" method="POST" class="send-form">
                                                        @csrf
                                                        <input type="hidden" name="method_type" value="whatsapp">
                                                        <button type="button" onclick="confirmSend(this, 'WhatsApp')" class="btn btn-sm btn-outline-success" style="padding: 2px 8px;" title="Send via WhatsApp">
                                                            <i class="fa-brands fa-whatsapp"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
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
                text: "Do you want to delete this notice?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',

            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            })
        }

        function confirmSend(button, type) {
            Swal.fire({
                title: 'পিক করুন!',
                text: "আপনি কি সকল শিক্ষার্থীর " + type + " এ এই নোটিশটি পাঠাতে চান?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: type === 'Email' ? '#4f46e5' : '#25d366',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'হ্যাঁ, পাঠান',
                cancelButtonText: 'না, থাক'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show Loading
                    Swal.fire({
                        title: 'পাঠানো হচ্ছে...',
                        html: 'অনুগ্রহ করে অপেক্ষা করুন।',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    button.closest('form').submit();
                }
            })
        }

        @if(session('success'))
            Swal.close(); // Close any loading alert
            Swal.fire({
                icon: '{{ session('type', 'success') }}',
                title: 'সফল!',
                text: '{{ session('success') }}',
                confirmButtonText: 'ঠিক আছে'
            });
        @endif
    </script>
@endsection