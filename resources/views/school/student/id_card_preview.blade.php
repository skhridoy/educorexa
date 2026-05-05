@extends('layouts.school')

@section('customCSS')
    @include('school.others._modern_design_styles')
<style>
    /* প্রিভিউ মোডে কার্ডগুলো সুন্দরভাবে দেখানোর জন্য */
    .preview-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr)); /* বড় স্ক্রিনে পাশাপাশি দেখাবে */
        gap: 20px;
    }

    .student-block {
        display: flex;
        justify-content: center;
        gap: 5px;
        background: #fdfdfd;
        padding: 20px 0;
        box-sizing: border-box;
        box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
    }

    /* কার্ডের সাইজ ঠিক রাখা */
    .card-container {
        width: 2.125in;
        height: 3.375in;
        background: white;
        position: relative;
        overflow: hidden;
        border: 0.5px solid #ddd;
        flex-shrink: 0;
        border-radius: 8px;
    }

    .name-badge {
            justify-content: center;
            text-align: center;
            position: relative;
            margin: 0 5px;
            padding: 2px 5px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .name {
            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
            margin: 0 5px;
            text-transform: uppercase;
            border-radius: 10px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
            font-size: 10px;
            padding: 3px 8px;
            font-weight: bold;
            color: #f0f0f0;

            z-index: 2;
        }

    .dot-pattern { position: absolute; width: 100%; height: 100%; background-image: radial-gradient(rgba(106, 27, 154, 0.1) 1.5px, transparent 1.5px); background-size: 10px 10px; z-index: 0; }
    .top-header-shape { position: absolute; top: 0; left: 0; width: 100%; height: 140px; background: linear-gradient(135deg, #6a1b9a 0%, #ad1457 100%); clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%); z-index: 1; }
    .header-content { position: relative; z-index: 3; text-align: center; color: white; padding-top: 10px; margin: 1px 10px;}
    .school-logo { width: 32px; margin-bottom: 2px; }
    .photo-border { position: absolute; top: 85px; left: 50%; transform: translateX(-50%); width: 75px; height: 75px; background: white; border-radius: 50%; padding: 3px; z-index: 3; border: 2px solid #6a1b9a; }
    .photo-border img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    .details { position: absolute; top: 170px; width: 100%; padding: 0 12px; box-sizing: border-box; z-index: 2; }
    .row-info { display: flex; font-size: 10px; }
    .label { width: 42%; font-weight: bold; color: #6a1b9a; }
    .val { width: 58%; color: #000; font-weight: bold; }
    .front-signature { position: absolute; bottom: 20px; right: 15px; text-align: center; z-index: 2; }
    .front-signature img { width: 35px; margin-bottom: -10px; }
    .front-signature p { margin: 0; font-size: 6px; font-weight: bold; border-top: 0.5px solid #333; }
    .back-top-bar { width: 100%; height: 25px; background: linear-gradient(90deg, #6a1b9a, #ad1457); }
    .back-header { margin: 8px auto; width: 85%; background: rgba(106, 27, 154, 0.1); color: #6a1b9a; text-align: center; font-size: 8px; font-weight: bold; padding: 3px 0; border-radius: 3px; }
    .school-info-section { margin-top: 8px; padding: 0 15px; font-size: 9px; color: #333; line-height: 1.2;}
    .qr-section { text-align: center; margin-top: 10px; }
    .bottom-bar { position: absolute; bottom: 0; width: 100%; height: 10px; background: linear-gradient(90deg, #6a1b9a, #ad1457); }
</style>
@endsection

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="page-title">ID Cards Preview ({{ $students->count() }} Students)</h3>
        <a href="{{ route('students.idcard.print', ['tenant' => auth()->user()->school->slug, 'class_id' => $class_id]) }}" 
           class="btn btn-danger btn-icon-text" target="_blank">
            <i class="btn-icon-prepend" data-feather="printer"></i> 
            Print All ID Cards
        </a>
    </div>

    <div class="preview-grid">
        @foreach($students as $student)
            <div class="student-block">
                <div class="card-container">
                    <div class="dot-pattern"></div>
                    <div class="top-header-shape"></div>
                    <div class="header-content">
                        <img src="{{ asset($school->logo) }}" class="school-logo">
                        <h1 style="font-size: 13px; margin-top: -3px; text-transform:uppercase">{{ $student->school->name }}</h1>
                    </div>
                    <div class="photo-border">
                        <img src="{{ asset($student->photo) }}">
                    </div>
                    <div class="details">
                        <div class="row-info name-badge">
                            <span class="name"> {{ $student->name }}</span>
                        </div>
                        
                        <div class="row-info">
                            <span class="label">Class</span>
                            <span class="val">: {{ $student->class->name }}</span>

                            <span class="label">Roll No</span>
                            <span class="val">: {{ $student->roll }}</span>
                        </div>
                        <div class="row-info">
                            <span class="label">Student ID</span>
                            <span class="val">: {{ $student->student_id }}</span>
                        </div>

                        <div class="row-info">
                            <span class="label">Guardians</span>
                            <span class="val">: {{ $student->fathers_name }}</span>
                        </div>

                        <div class="row-info">
                            <span class="label">Blood Group</span>
                            <span class="val">: {{ $student->blood_group }}</span>
                        </div>

                        <div class="row-info">
                            <span class="label">Emergency</span>
                            <span class="val">: {{ $student->contact_number }}</span>
                        </div>
                    </div>
                    <div class="front-signature">
                        <img src="{{ asset('assets/images/signature.png') }}" alt="Sign">
                        <p>Principal</p>
                    </div>
                    <div class="bottom-bar"></div>
                </div>

                <div class="card-container">
                    <div class="dot-pattern"></div>
                    <div class="back-top-bar" style="width: 100%; height: 25px; background: linear-gradient(90deg, #6a1b9a, #ad1457);"></div>

                    <div class="back-header" style="margin: 12px auto; width: 85%; background: rgba(106, 27, 154, 0.3); color: #6a1b9a; text-align: center; font-size: 9px; font-weight: bold; padding: 4px 0; border-radius: 3px;">
                        TERMS AND CONDITIONS
                    
                    </div>

                    <div class="terms-text" style="padding: 0 15px; font-size: 9px; color: #343232; line-height: 1;">
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 3px;">• This card is the property of <strong>{{ $student->school->name }}</strong>.</li>
                            <li>• If found, please return to the school office immediately.</li>
                        </ul>
                    </div>

                    {{-- Session, DOB এবং Validity অংশ --}}
                    <div class="extra-info-section" style="margin-top: 10px; padding: 0 20px; font-size: 9px; color: #333;">
                        <div style="margin-bottom: 2px; display: flex;">
                            <strong style="color: #6a1b9a; width: 50px;">Session</strong> 
                            <span>: {{ $student->academicYear->name ?? 'N/A' }}</span>
                        </div>
                        <div style="margin-bottom: 2px; display: flex;">
                            <strong style="color: #6a1b9a; width: 50px;">D.O.B</strong> 
                            <span>: {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : 'N/A' }}</span>
                        </div>
                        <div style="margin-bottom: 2px; display: flex;">
                            <strong style="color: #6a1b9a; width: 50px;">Valid Up To</strong> 
                            <span>: {{ $student->academicYear->end_date ? \Carbon\Carbon::parse($student->academicYear->end_date)->format('M Y') : 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="school-info-section" style="margin-top: 8px; padding: 0 20px; font-size: 9px; color: #333;">
                        <div style="margin-bottom: 2px; display: flex; align-items: center;">
                            <strong style="color: #6a1b9a; width: 50px;">Phone</strong> 
                            <span>: {{ $student->school->phone ?? '01XXX-XXXXXX' }}</span>
                        </div>
                        <div style="margin-bottom: 2px; display: flex; align-items: center;">
                            <strong style="color: #6a1b9a; width: 50px;">Website</strong> 
                                @php    
                                    $schoolSlug = $student->school->slug;
                                    $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
                                    $fullUrl = $schoolSlug . '.' . $mainDomain;
                                @endphp
                                
                            <span>: {{ $fullUrl ?? 'www.school.com' }}</span>
                        </div>
                    </div>

                    <div class="qr-section" style="text-align: center; margin-top: 8px;">
                        <div style="display: inline-block; padding: 4px; border: 1px solid #eee; background: white;">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(45)->color(106, 27, 154)->generate("ID: " . $student->student_id . " | Name: " . $student->name) !!}
                        </div>
                        <div style="font-size: 7px; margin-top: 2px; font-weight: bold; color: #6a1b9a;">
                                {{ $student->student_id }}
                        </div>
                        
                    </div>

                    <div class="bottom-bar" style="position: absolute; bottom: 0; width: 100%; height: 12px; background: linear-gradient(90deg, #6a1b9a, #ad1457);"></div>
                    </div>
                
                </div>
                
            @endforeach
        </div>
    </div>
@endsection