@extends('layouts.main')

@section('content')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.contact.index') }}">Contact Messages</a></li>
            <li class="breadcrumb-item active" aria-current="page">Message Details</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4">
                        <h6 class="card-title mb-0">Message from: {{ $message->name }}</h6>
                        <span class="text-muted small">{{ $message->created_at->format('d M, Y - h:i A') }}</span>
                    </div>
    
                    <div class="message-content bg-light p-4 rounded-3 mb-4">
                        <h6 class="fw-bold mb-2">Message Body:</h6>
                        <p class="text-dark lh-base">
                            {{ $message->message ?? 'No detailed message provided.' }}
                        </p>
                    </div>
    
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <label class="text-muted x-small fw-bold text-uppercase mb-1">Phone Number</label>
                                <h5 class="fw-bold text-primary mb-0">
                                    <a href="tel:{{ $message->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone-outbound me-2"></i>{{ $message->phone }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 border rounded shadow-sm bg-white">
                                <label class="text-muted x-small fw-bold text-uppercase mb-1">Institution</label>
                                <h5 class="fw-bold text-dark mb-0">
                                    <i class="bi bi-building me-2"></i>{{ $message->school_name ?? 'N/A' }}
                                </h5>
                            </div>
                        </div>
                    </div>
    
                    <div class="mt-4 pt-3 border-top d-flex gap-2">
                        <a href="{{ route('manage.contact.index') }}" class="btn btn-secondary btn-icon-text">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i> Back to List
                        </a>
                        
                        {{-- Quick Action: WhatsApp --}}
                        @php
                            $whatsAppPhone = preg_replace('/[^0-9]/', '', $message->phone);
                            // যদি নাম্বারটি ৮৮ ছাড়া হয় তবে ৮৮ যোগ করে দেওয়া ভালো (বাংলাদেশী নাম্বারের জন্য)
                            if(strlen($whatsAppPhone) == 11) $whatsAppPhone = '88' . $whatsAppPhone;
                        @endphp
                        <a href="https://wa.me/{{ $whatsAppPhone }}" target="_blank" class="btn btn-success btn-icon-text">
                            <i class="btn-icon-prepend bi bi-whatsapp"></i> WhatsApp Him
                        </a>
    
                        <form action="{{ route('manage.contact.destroy', $message->id) }}" method="POST" class="ms-auto">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-icon-text" onclick="confirmDelete(this)">
                                <i class="btn-icon-prepend" data-feather="trash-2"></i> Delete Lead
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        {{-- সাইডবার কুইক নোটস --}}
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <h6 class="card-title text-white">Lead Summary</h6>
                    <div class="d-flex flex-column gap-3 mt-4">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white-soft me-3">
                                <i class="bi bi-person-check"></i>
                            </div>
                            <span>Status: <strong class="ms-1">Processed</strong></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="icon-circle bg-white-soft me-3">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <span>Wait Time: <strong class="ms-1">{{ $message->created_at->diffForHumans() }}</strong></span>
                        </div>
                    </div>
                    <hr class="bg-white-50">
                    <p class="small opacity-75">
                        * এডমিন বা এইচআর প্যানেল থেকে এই ইউজারের সাথে যোগাযোগ করা হলে এখানে ইন্টারনাল নোট লিখে রাখার সিস্টেম ভবিষ্যতে যোগ করা যাবে।
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-white-soft { background-color: rgba(255, 255, 255, 0.2); }
    .icon-circle {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.2rem;
    }
    .x-small { font-size: 0.7rem; }
    .message-content p { white-space: pre-line; } /* টেক্সটের লাইন ব্রেক ঠিক রাখার জন্য */
</style>
@endsection

@section('customJs')
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to delete this message/lead?",
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
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $errors->first() }}', // প্রথম এরর মেসেজটি দেখাবে
            confirmButtonColor: '#3085d6',
        });
    @endif
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