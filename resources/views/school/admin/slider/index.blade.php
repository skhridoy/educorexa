@extends('layouts.school')

@section('customCSS')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
@endsection
@section('content')
<div class="page-content">
    <div class="row">
        {{-- স্লাইডার আপলোড ফর্ম --}}
        <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">নতুন স্লাইডার যুক্ত করুন</h6>
                    <form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">টাইটেল (ঐচ্ছিক)</label>
                            <input type="text" name="title" class="form-control" placeholder="স্লাইডার টাইটেল">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">সাব-টাইটেল (ঐচ্ছিক)</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="স্কুলের ঠিকানা বা ছোট বর্ণনা">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ইমেজ (প্রয়োজনীয়)</label>
                            <input type="file" name="image" class="form-control" required>
                            <small class="text-muted">সাইজ: ১৯২০x১০৮০ রেশিও হলে ভালো দেখাবে।</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">সিরিয়াল নম্বর</label>
                            <input type="number" name="order_by" class="form-control" value="0">
                        </div>
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- স্লাইডার লিস্ট --}}
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">বর্তমান স্লাইডারসমূহ</h6>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ইমেজ</th>
                                    <th>টাইটেল</th>
                                    <th>সিরিয়াল</th>
                                    <th>অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sliders as $slider)
                                <tr>
                                    <td>
                                        <img src="{{ asset($slider->image) }}" style="width: 100px; height: 60px; border-radius: 5px; object-fit: cover;">
                                    </td>
                                    <td>{{ $slider->title ?? 'N/A' }}</td>
                                    <td>{{ $slider->order_by }}</td>
                                    <td>
                                        <form action="{{ route('sliders.destroy', ['tenant' => auth()->user()->school->slug, 'id' => $slider->id]) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete(this)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
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