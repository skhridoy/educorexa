@extends('layouts.main')

@section('content')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('manage.frontend.index') }}">Frontend</a></li>
            <li class="breadcrumb-item active" aria-current="page">Features</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Features Section</h6>
                    <form action="{{ route('manage.frontend.update', $section->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Main Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $content['title'] ?? '' }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2">{{ $content['description'] ?? '' }}</textarea>
                            </div>

                            <hr class="my-3">
                            <h5>Feature Items (Up to 6)</h5>

                            @php $items = $content['items'] ?? []; @endphp

                            @for($i=0;$i<6;$i++)
                                @php $it = $items[$i] ?? ['icon'=>'language','title'=>'','desc'=>'']; @endphp
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Icon (Material Symbol)</label>
                                    <input type="text" name="items[{{ $i }}][icon]" class="form-control" value="{{ $it['icon'] }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="items[{{ $i }}][title]" class="form-control" value="{{ $it['title'] }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Short Description</label>
                                    <input type="text" name="items[{{ $i }}][desc]" class="form-control" value="{{ $it['desc'] }}">
                                </div>
                            @endfor

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary px-4">Update Features Section</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
