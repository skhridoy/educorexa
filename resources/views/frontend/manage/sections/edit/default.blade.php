@extends('layouts.main')

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
        <li class="breadcrumb-item active" aria-current="page">Default Editor</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i data-feather="alert-circle" class="text-warning" style="width: 80px; height: 80px;"></i>
                    </div>
                    <h4 class="mb-3">Custom Editor Not Found!</h4>
                    <p class="text-muted mb-4">
                        দুঃখিত, এই সেকশনটির জন্য কোনো কাস্টম এডিট ফরম তৈরি করা হয়নি। <br>
                        সেকশনের নাম: <strong>{{ $section->title }}</strong> | Key: <code>{{ $section->key }}</code>
                    </p>
                    
                    <div class="alert alert-info d-inline-block">
                        <strong>ডেভেলপার টিপস:</strong> <br>
                        <code>resources/views/frontend/manage/sections/edit/{{ $section->key }}.blade.php</code> <br>
                        নামে একটি ফাইল তৈরি করলে এই এররটি চলে যাবে।
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('manage.frontend.index') }}" class="btn btn-secondary">
                            <i class="btn-icon-prepend" data-feather="arrow-left"></i> ব্যাক টু লিস্ট
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
    $(function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endpush