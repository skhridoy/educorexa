@php 
    try {
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Academic Transcript - {{ $student->name }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; margin: 0; padding: 0; color: #000; }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1; /* স্বচ্ছতা নিয়ন্ত্রণ */
            z-index: -1000; /* যেন সব লেখার নিচে থাকে */
            text-align: center;
        }
        .watermark img {
            width: 450px; /* লোগোর সাইজ প্রয়োজন অনুযায়ী ছোট-বড় করতে পারেন */
            height: auto;
        }

        
        .wrapper { border: 2px solid #000; padding: 15px; margin: 10px; min-height: 900px; }
        
        /* Header Section */
        .header-top { text-align: center; margin-bottom: 10px; }
        .school-name { font-size: 22px; font-weight: bold; color: #000; text-transform: uppercase; }
        .school-info { font-size: 11px; margin-bottom: 5px; }

        /* Top Layout: Photo | Logo | Grade Table */
        .top-container { width: 100%; margin-bottom: 15px; }
        .top-container td { vertical-align: top; border: none; }
        
        .photo-box { width: 100px; height: 110px; border: 1px solid #000; text-align: center; line-height: 110px; }
        .logo-box img { width: 100px; }
        
        .grade-table { width: 100%; border-collapse: collapse; font-size: 10px; margin-top: -20px;}
        .grade-table th, .grade-table td { border: 1px solid #000; padding: 2px; text-align: center; }
        
        /* Info Section */
        .transcript-title { text-align: center; font-weight: bold; font-size: 14px; text-decoration: underline; margin-bottom: 10px; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; border: none !important;}
        
        .info-table td { border: none !important; padding: 4px; font-style: italic;}
        .label { font-weight: bold; }

        /* Marks Table */
        .marks-table { width: 100%; border-collapse: collapse; text-align: center; }
        .marks-table th, .marks-table td { border: 1px solid #000; padding: 6px; }
        .bg-gray { background-color: #f2f2f2; }

        /* Footer Signatures */
        .footer-sig { margin-top: 80px; width: 100%; }
        .footer-sig td { text-align: center; border: none; width: 33%; }
        .sig-line { border-top: 1px solid #000; display: inline-block; width: 150px; padding-top: 5px; }
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
        <div style="font-weight: bold;">
            Academic Year: {{ $academic_year ?? date('Y') }}
        </div>
        <h3>{{ $exam->name }} - {{ $academic_year ?? date('Y') }}</h3>
    </div>

    {{-- Top Section: Photo, Logo, Grade Table --}}
    <table class="top-container">
        <tr>
            <td width="25%">
                <div class="photo-box">
                    @if($student->photo)
                        {{-- যদি photo কলামে শুধু ফাইলের নাম থাকে (যেমন: image.jpg) --}}
                        <img src="{{ $studentPhoto }}" style="width:100%; height:110px; object-fit: cover;">
                    @else
                        <div style="line-height: 110px;">No Photo</div>
                    @endif
                </div>
            </td>
            <td width="50%" style="text-align: center;">
                <div class="logo-box">
                    <img src="{{ $instituteLogo }}" alt="School Logo">
                </div>
            </td>
            <td width="25%">
                <table class="grade-table">
                    <tr class="bg-gray"><th>Letter Grade</th><th>Class Interval</th><th>Grade Point</th></tr>
                    <tr><td>A+</td><td>80 - 100</td><td>5</td></tr>
                    <tr><td>A</td><td>70 - 79</td><td>4</td></tr>
                    <tr><td>A-</td><td>60 - 69</td><td>3.5</td></tr>
                    <tr><td>B</td><td>50 - 59</td><td>3</td></tr>
                    <tr><td>C</td><td>40 - 49</td><td>2</td></tr>
                    <tr><td>D</td><td>33 - 39</td><td>1</td></tr>
                    <tr><td>F</td><td>0 - 32</td><td>0</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="transcript-title">ACADEMIC TRANSCRIPT</div>

    {{-- Student Information --}}
    <table class="info-table">
    <tr>
        <td width="20%" class="label">Name of Student</td>
        <td width="30%">:  {{ strtoupper($student->name) }}</td>
        
        <td class="label">Student ID</td>
        
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
        <td class="label">Date of Birth</td>
        <td>: {{ $formattedDOB }}</td>
        
        <td class="label">Total Marks</td>
        <td>: {{ $totalMarks }}</td>
    </tr>
    <tr>
        <td class="label">Merit Position</td>
        <td>: {{ $meritPosition }}</td>
        
        <td class="label">GPA</td>
        <td style="font-weight: bold;">: {{ $gpa }}</td>
    </tr>
</table>

    <div style="text-align: center; font-weight: bold; margin-bottom: 10px;">
        <p style="font-size: 14px;">Subject Wise Marks and Grade</p>
    </div>

    {{-- Marks Table --}}
    <table class="marks-table">
        <thead>
            <tr class="bg-gray">
                <th>SL No.</th>
                <th>Subject's Name</th>
                <th>Subject Code</th>
                <th>Full Marks</th>
                <th>Obtaind Marks</th>
                <th>Highest Marks</th>
                <th>Grade</th>
                <th>Point</th>
                <th>GPA</th>
            </tr>
        </thead>
        <tbody>
            @php $sl = 1; @endphp
            @foreach($marksData as $subjectId => $res)
            <tr>
                <td>{{ $sl++ }}</td>
                <td style="text-align: left;">{{ $res['subject_name'] }}</td>
                <td>{{ $res['subject_code'] }}</td>
                <td>{{ $res['full_mark'] }}</td>
                <td>{{ $res['marks'] }}</td>
                <td>{{ $res['highest_mark'] ?? '---' }}</td>
                <td>{{ $res['grade'] }}</td>
                <td>{{ number_format($res['point'], 2) }}</td>
                @if($loop->first)
                <td rowspan="{{ count($marksData) }}" style="vertical-align: middle; font-weight: bold;">
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
            <td>
                <span style="font-style: italic;"></span><br>
                <span class="sig-line">Class Teacher's Signature</span>
            </td>
            <td>
                <br>
                <span class="sig-line">Guardian's Signature</span>
            </td>
            <td>
                <br>
                <span class="sig-line">Principal's Signature</span>
            </td>
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
