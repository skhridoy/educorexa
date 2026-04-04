@extends('layouts.school')

@section('content')
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">ওয়েবসাইট "আমাদের সম্পর্কে" সেকশন আপডেট করুন</h6>
                    
                    <form action="{{ route('about.update', ['tenant' => auth()->user()->school->slug]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            {{-- বাম পাশ: মূল কন্টেন্ট --}}
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">মূল শিরোনাম (Title)</label>
                                    <input type="text" name="title" class="form-control" value="{{ $about->title ?? '' }}" placeholder="যেমন: একটি উজ্জ্বল ভবিষ্যৎ গড়ার প্রত্যয়ে...">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">বিস্তারিত বর্ণনা (Description)</label>
                                    <textarea name="description" class="form-control" rows="4">{{ $about->description ?? '' }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border p-3 mb-3">
                                            <label class="form-label font-weight-bold">ফিচার ১ (Title & Desc)</label>
                                            <input type="text" name="feature_1_title" class="form-control mb-2" value="{{ $about->feature_1_title ?? '' }}" placeholder="টাইটেল">
                                            <textarea name="feature_1_desc" class="form-control" rows="2" placeholder="ছোট বর্ণনা">{{ $about->feature_1_desc ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border p-3 mb-3">
                                            <label class="form-label font-weight-bold">ফিচার ২ (Title & Desc)</label>
                                            <input type="text" name="feature_2_title" class="form-control mb-2" value="{{ $about->feature_2_title ?? '' }}" placeholder="টাইটেল">
                                            <textarea name="feature_2_desc" class="form-control" rows="2" placeholder="ছোট বর্ণনা">{{ $about->feature_2_desc ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ডান পাশ: ইমেজ ও বাটন --}}
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label">সেকশন ইমেজ</label>
                                    <input type="file" name="image" class="form-control mb-2">
                                    @if($about && $about->image)
                                        <div class="mt-2">
                                            <label class="d-block">বর্তমান ইমেজ:</label>
                                            <img src="{{ asset($about->image) }}" class="img-thumbnail" style="height: 120px; object-fit: cover;">
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">বাটন টেক্সট</label>
                                    <input type="text" name="button_text" class="form-control" value="{{ $about->button_text ?? 'আরও জানুন' }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">বাটন লিঙ্ক (URL)</label>
                                    <input type="text" name="button_url" class="form-control" value="{{ $about->button_url ?? '#' }}">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-save me-1"></i> আপডেট করুন
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif
    </script>
@endsection