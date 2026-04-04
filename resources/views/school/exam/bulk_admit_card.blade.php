<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page {
            size: A4 landscape;
            margin: 15px;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
        }
        .card-wrapper {
            width: 47%; /* উইডথ কিছুটা কমানো হলো গ্যাপ বাড়ানোর জন্য */
            float: left;
            margin: 15px 1.5%; /* ডবল গ্যাপ তৈরির জন্য মার্জিন বাড়ানো হয়েছে (উপরে-নিচে ১৫px, পাশে ১.৫%) */
            gap: 5;
            border: 1px solid #000;
            margin-bottom: 20px;
            position: relative;
            height: 330px; /* উচ্চতা অ্যাডজাস্ট করা হয়েছে */
            background: #fff;
            box-sizing: border-box; /* বর্ডারকে উইডথের ভেতরে রাখার জন্য */
        }

        .card-wrapper {
            outline: 1px dashed #ccc; /* কাটার গাইডলাইন হিসেবে হালকা ডটেড লাইন */
            outline-offset: 10px; /* কার্ড থেকে ১০px দূরে ডটেড লাইন দেখাবে */
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            z-index: -1;
            text-align: center;
        }
        .watermark img {
            width: 180px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding: 5px;
            background: #f8f9fa;
        }
        .header h3 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        .content {
            padding: 10px;
            
        }
        .student-info {
            width: 65%;
           
            float: left;
        }
        .student-photo {
            width: 30%;
            float: right;
            text-align: center;
        }
        .info-table {
            width: 100%;
            font-size: 14px;
        
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px 0; 
            line-height: 1.6;
            vertical-align: top;
        }
        .photo-box {
            width: 85px;
            height: 85px;
            border: 1px solid #666;
            margin: 0 auto;
            display: block;
            margin-top: 5px;
        }
        .qr-code {
            margin-top: 10px;
        }
        .footer {
            position: absolute;
            bottom: 15px;
            width: 100%;
        }
        .sig-box-1 {
            width: 40%;
            float: left;
            text-align: center;
            margin: 0 5%;
            font-size: 14px;
            border-top: 1px solid #000;
        }
        .sig-box-2 {
            width: 40%;
            float: right;
            text-align: center;
            margin: 0 5%;
            font-size: 14px;
            border-top: 1px solid #000;
        }
        .clear { clear: both; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="container">
        @foreach($students as $index => $student)
            <div class="card-wrapper">
                {{-- ওয়াটারমার্ক --}}
                <div class="watermark">
                    <img src="{{ ($school->logo) }}">
                </div>

                <div class="header">
                    <h3>{{ auth()->user()->school->name }}</h3>
                    <p>{{ $exam->name }} - {{ date('Y') }}</p>
                </div>

                <div class="content">
                    <div class="student-info">
                        <table class="info-table">
                            <tr><td width="30%"><strong>Roll</strong></td><td>: {{ $student->roll }}</td></tr>
                            <tr><td><strong>ID</strong></td><td>: {{ $student->student_id }}</td></tr>
                            <tr><td><strong>Name</strong></td><td>: {{ $student->name }}</td></tr>
                            <tr><td><strong>Class</strong></td><td>: {{ $student->class->name }}</td></tr>
                            <tr><td><strong>Session</strong></td><td>: {{ date('Y') }}</td></tr>
                        </table>
                    </div>

                    <div class="student-photo">
                        <div class="photo-box">
                            @if($student->photo)
                                <img src="{{ public_path($student->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <span style="font-size: 10px; line-height: 80px; color: #ccc;">Photo</span>
                            @endif
                        </div>
                        <div class="qr-code">
                            @php
                                $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(50)->generate("ID: " . $student->student_id));
                            @endphp
                            <img src="data:image/svg+xml;base64, {!! $qrCode !!}">
                        </div>
                    </div>
                </div>

                <div class="clear"></div>

                <div class="footer">
                    <div class="sig-box-1">Class Teacher</div>
                    <div class="sig-box-2">Principal</div>
                    <div class="clear"></div>
                </div>
            </div>

            {{-- প্রতি ৪টি কার্ডের পর পেজ ব্রেক এবং ২টির পর ফ্লোট ক্লিয়ার --}}
            @if(($index + 1) % 2 == 0)
                <div class="clear"></div>
            @endif

            @if(($index + 1) % 4 == 0 && !$loop->last)
                <div class="page-break"></div>
            @endif
        @endforeach
    </div>
</body>
</html>