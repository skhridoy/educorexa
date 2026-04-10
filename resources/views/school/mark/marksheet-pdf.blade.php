@php 
    try {
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Transcript - {{ $student->name }}</title>
    <style>
        /* ফন্ট সাইজ ১১.৫ এ সেট করা হয়েছে যা স্ট্যান্ডার্ড */
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11.5px; margin: 0; padding: 0; color: #000; line-height: 1.4; }
        
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1000;
        }
        .watermark img { width: 420px; }

        /* wrapper এর মার্জিন ও প্যাডিং ঠিক করা হয়েছে */
        .wrapper { border: 2px solid #000; padding: 15px; margin: 5px; min-height: 920px; position: relative;}
        
        /* Header Section - স্পেসিং একটু বাড়ানো হয়েছে */
        .header-top { text-align: center; margin-bottom: 12px; }
        .school-name { font-size: 22px; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .school-info { font-size: 11px; margin-bottom: 5px; }

        /* Top Layout - ফটো এবং গ্রেড টেবিল */
        .top-container { width: 100%; margin-bottom: 15px; }
        .top-container td { vertical-align: top; }
        
        .photo-box { width: 100px; height: 110px; border: 1px solid #000; text-align: center; line-height: 110px; }
        .logo-box img { width: 90px; }
        
        .grade-table { width: 100%; border-collapse: collapse; font-size: 9px; margin-top: -10px;}
        .grade-table th, .grade-table td { border: 1px solid #000; padding: 2px 4px; text-align: center; }
        
        /* Info Section */
        .transcript-title { text-align: center; font-weight: bold; font-size: 15px; text-decoration: underline; margin-bottom: 12px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .info-table td { padding: 4px 2px; font-style: italic;}
        .label { font-weight: bold; font-style: normal; }

        /* Marks Table - এটি এখন পড়ার জন্য বেশ ক্লিয়ার হবে */
        .marks-table { width: 100%; border-collapse: collapse; text-align: center; font-size: 11px; }
        .marks-table th, .marks-table td { border: 1px solid #000; padding: 6px 3px; }
        .bg-gray { background-color: #f2f2f2; }

        /* Footer Signatures - পজিশন ফিক্সড করা হয়েছে যাতে পেজের নিচে থাকে */
        .footer-sig { margin-top: 60px; width: 100%; }
        .footer-sig td { text-align: center; vertical-align: bottom; }
        .sig-line { border-top: 1px solid #000; display: inline-block; width: 150px; padding-top: 5px; font-size: 11px; font-weight: bold;}
    </style>
</head>
<body>
<div class="watermark">
    <img src="{{ $instituteLogo }}" alt="Watermark">
</div>
<div class="wrapper">

    {{-- School Header --}}
    <div class="header-top">
        <div class="school-name">{{ $schoolName }}</div>
        <div class="school-info">{{ $address }}<br>EMIS CODE: {{$emis}}</div>
        <div style="font-weight: bold; font-size: 10px;">
            Academic Year: {{ $academic_year ?? date('Y') }}
        </div>
        <h3 style="margin: 5px 0;">{{ $exam->name }} - {{ $academic_year ?? date('Y') }}</h3>
    </div>

    {{-- Top Section --}}
    <table class="top-container">
        <tr>
            <td width="20%">
                <div class="photo-box">
                    @if($student->photo)
                        <img src="{{ $studentPhoto }}" style="width:100%; height:100px; object-fit: cover;">
                    @else
                        <div style="line-height: 100px;">No Photo</div>
                    @endif
                </div>
            </td>
            <td width="55%" style="text-align: center;">
                <div class="logo-box">
                    <img src="{{ $instituteLogo }}" alt="School Logo">
                </div>
            </td>
            <td width="25%">
                <table class="grade-table">
                    <tr class="bg-gray"><th>LG</th><th>Interval</th><th>GP</th></tr>
                    <tr><td>A+</td><td>80-100</td><td>5.0</td></tr>
                    <tr><td>A</td><td>70-79</td><td>4.0</td></tr>
                    <tr><td>A-</td><td>60-69</td><td>3.5</td></tr>
                    <tr><td>B</td><td>50-59</td><td>3.0</td></tr>
                    <tr><td>C</td><td>40-49</td><td>2.0</td></tr>
                    <tr><td>D</td><td>33-39</td><td>1.0</td></tr>
                    <tr><td>F</td><td>00-32</td><td>0.0</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="transcript-title">ACADEMIC TRANSCRIPT</div>

    {{-- Student Information --}}
    <table class="info-table">
        <tr>
            <td width="18%" class="label">Name of Student</td>
            <td width="32%">: {{ strtoupper($student->name) }}</td>
            <td width="18%" class="label">Student ID</td>
            <td>: {{ $student->student_id ?? $student->id }}</td>
        </tr>
        <tr>
            <td class="label">Father's Name</td>
            <td>: {{ $student->fathers_name }}</td>
            <td class="label">Class</td>
            <td>: {{ $class->name }}</td>
        </tr>
        <tr>
            <td class="label">Mother's Name</td>
            <td>: {{ $student->mothers_name }}</td>
            <td class="label">Section</td>
            <td>: {{ is_object($student->section) ? $student->section->name : ($student->section ?? 'A') }}</td>
        </tr>
        <tr>
            <td class="label">Birth</td>
            <td>: {{ $formattedDOB }}</td>
            <td class="label">Total Marks</td>
            <td>: {{ $totalMarks }}</td>
        </tr>
        <tr>
            <td class="label">Merit</td>
            <td>: {{ $meritPosition }}</td>
            <td class="label">GPA</td>
            <td style="font-weight: bold;">: {{ $gpa }}</td>
        </tr>
    </table>

    <div style="text-align: center; font-weight: bold; margin-bottom: 5px;">
        <span style="font-size: 12px; border-bottom: 1px solid #000;">Subject Wise Marks and Grade</span>
    </div>

    {{-- Marks Table --}}
    <table class="marks-table">
        <thead>
            <tr class="bg-gray">
                <th width="5%">SL</th>
                <th width="10%">Code</th>
                <th width="35%">Subject's Name</th>
                <th width="8%">Full</th>
                <th width="8%">Obt.</th>
                <th width="8%">High</th>
                <th width="8%">Grade</th>
                <th width="8%">Point</th>
                <th width="10%">GPA</th>
            </tr>
        </thead>
        <tbody>
            @php $sl = 1; @endphp
            @foreach($marksData as $subjectId => $res)
            <tr>
                <td>{{ $sl++ }}</td>
                <td>{{ $res['subject_code'] }}</td>
                <td style="text-align: left; padding-left: 5px;">{{ $res['subject_name'] }}</td>
                <td>{{ $res['full_mark'] }}</td>
                <td>{{ $res['marks'] }}</td>
                <td>{{ $res['highest_mark'] ?? '---' }}</td>
                <td style="font-weight: bold;">{{ $res['grade'] }}</td>
                <td>{{ number_format($res['point'], 2) }}</td>
                @if($loop->first)
                <td rowspan="{{ count($marksData) }}" style="vertical-align: middle; font-weight: bold; font-size: 14px;">
                    {{ $gpa }}
                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer Signatures --}}
    <table class="footer-sig">
        <tr>
            <td><span class="sig-line">Class Teacher</span></td>
            <td><span class="sig-line">Guardian</span></td>
            <td><span class="sig-line">Principal</span></td>
        </tr>
    </table>
</div>

</body>
</html>

@php
    } catch (\Exception $e) {
        dd($e->getMessage(), $e->getLine());
    }
@endphp