@extends('app-layouts.frontend')

@section('title', 'EduCorexa')
@section('subtitle', 'School Management Software')
@section('seo_title', 'EduCorexa | School Management Software')
@section('seo_description', 'EduCorexa হলো আধুনিক স্কুল ম্যানেজমেন্ট সফটওয়্যার। ভর্তি, হাজিরা, ফলাফল, হিসাব ও অভিভাবক যোগাযোগ এক প্ল্যাটফর্মে পরিচালনা করুন।')
@section('seo_keywords', 'school management software, স্কুল ম্যানেজমেন্ট সফটওয়্যার, school ERP, school management system, education management software')

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

