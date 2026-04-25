@extends('app-layouts.frontend')

@section('content')
    {{-- চেক করে নেওয়া যে ভেরিয়েবলটি আছে কি না এবং এটি খালি কি না --}}
    @if(isset($sections) && $sections->count() > 0)
        @foreach($sections as $section)
            @if(view()->exists('frontend.partials.' . $section->key))
                @include('frontend.partials.' . $section->key)
            @endif
        @endforeach
    @else
        <p class="text-center py-5">No sections found in database.</p>
    @endif
@endsection

