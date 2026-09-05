<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ID Card - {{ $student->name }}</title>
    <style>
        /* A4 Page Setup */
        @page {
            size: A4;
            margin: 0.5in;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f1f5f9;
        }

        .print-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            padding: 30px 20px;
            flex-wrap: wrap;
        }

        /* Standard ID Card Size (CR80) */
        .card-container {
            width: 2.125in;
            height: 3.375in;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            border: 0.5px solid #d1d5db;
            border-radius: 9px;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
        }

        /* ── FRONT SIDE ── */
        .dot-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(106, 27, 154, 0.1) 1.5px, transparent 1.5px);
            background-size: 10px 10px;
            z-index: 0;
        }
        .top-header-shape {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 140px;
            background: linear-gradient(135deg, #6a1b9a 0%, #ad1457 100%);
            clip-path: polygon(0 0, 100% 0, 100% 70%, 85% 75%, 75% 85%, 50% 100%, 25% 85%, 15% 75%, 0 70%);
            z-index: 1;
        }
        .header-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: white;
            padding-top: 10px;
            margin: 1px 8px;
        }
        .school-logo {
            max-height: 32px;
            max-width: 54px;
            object-fit: contain;
            margin-bottom: 2px;
            display: inline-block;
        }
        .school-name-text {
            font-size: 11px;
            margin-top: -2px;
            text-transform: uppercase;
            font-weight: 800;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .photo-border {
            position: absolute;
            top: 82px;
            left: 50%;
            transform: translateX(-50%);
            width: 74px;
            height: 74px;
            background: white;
            border-radius: 50%;
            padding: 2.5px;
            z-index: 3;
            border: 2px solid #6a1b9a;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
        }
        .photo-border img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .details {
            position: absolute;
            top: 165px;
            width: 100%;
            padding: 0 10px;
            box-sizing: border-box;
            z-index: 2;
        }
        .name-badge {
            justify-content: center;
            text-align: center;
            position: relative;
            margin: 0 2px 4px 2px;
        }
        .name {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            text-transform: uppercase;
            border-radius: 8px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
            font-size: 9.5px;
            padding: 2.5px 8px;
            font-weight: 800;
            color: #ffffff;
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 95%;
        }
        .row-info {
            display: flex;
            font-size: 9px;
            line-height: 1.28;
            margin-bottom: 1px;
        }
        .label {
            width: 42%;
            font-weight: 700;
            color: #6a1b9a;
        }
        .val {
            width: 58%;
            color: #1e293b;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .front-signature {
            position: absolute;
            bottom: 16px;
            right: 12px;
            text-align: center;
            z-index: 2;
        }
        .front-signature img {
            max-height: 22px;
            max-width: 48px;
            object-fit: contain;
            margin-bottom: -3px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .front-signature p {
            margin: 0;
            font-size: 6px;
            font-weight: 800;
            border-top: 0.5px solid #333;
            color: #1e293b;
        }

        /* ── BACK SIDE ── */
        .back-top-bar {
            width: 100%;
            height: 24px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }
        .back-header {
            margin: 10px auto 6px auto;
            width: 86%;
            background: rgba(106, 27, 154, 0.15);
            color: #6a1b9a;
            text-align: center;
            font-size: 8.5px;
            font-weight: 800;
            padding: 3px 0;
            border-radius: 3px;
            letter-spacing: 0.3px;
        }
        .terms-text {
            padding: 0 12px;
            font-size: 8px;
            color: #334155;
            line-height: 1.25;
        }
        .extra-info-section {
            margin-top: 8px;
            padding: 0 14px;
            font-size: 8.5px;
            color: #334155;
            line-height: 1.35;
        }
        .school-info-section {
            margin-top: 6px;
            padding: 0 14px;
            font-size: 8.5px;
            color: #334155;
            line-height: 1.3;
        }
        .qr-section {
            text-align: center;
            margin-top: 8px;
        }
        .bottom-bar {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 10px;
            background: linear-gradient(90deg, #6a1b9a, #ad1457);
        }

        @media print {
            body {
                background: none;
            }
            .no-print {
                display: none !important;
            }
            .print-wrapper {
                padding: 0;
                margin-top: 0.5in;
            }
            .card-container {
                box-shadow: none;
                border: 1px solid #eee;
            }
        }
    </style>
</head>
<body>
    @php
        $school = $student->school ?? (auth()->user()?->school ?? (app()->bound('currentSchool') ? app('currentSchool') : null));
        $schoolSig = $school?->signature ?? auth()->user()?->signature;
        $hasSignature = !empty($schoolSig) && file_exists(public_path($schoolSig));

        $schoolSlug = $school?->slug ?? 'school';
        $mainDomain = parse_url(config('app.url'), PHP_URL_HOST);
        $fullUrl = $schoolSlug . '.' . $mainDomain;
    @endphp

    <div class="no-print" style="text-align: center; padding: 18px; background: #ffffff; border-bottom: 1px solid #e2e8f0; margin-bottom: 10px;">
        <button onclick="window.print()" style="padding: 10px 24px; background: linear-gradient(135deg, #6a1b9a, #ad1457); color: white; border: none; cursor: pointer; border-radius: 30px; font-weight: bold; font-size: 14px; box-shadow: 0 4px 12px rgba(106, 27, 154, 0.3);">
            PRINT ID CARD
        </button>
    </div>

    <div class="print-wrapper">
        {{-- ── FRONT SIDE ── --}}
        <div>
            <div class="card-container">
                <div class="dot-pattern"></div>
                <div class="top-header-shape"></div>
                <div class="header-content">
                    @if($school && $school->logo && file_exists(public_path($school->logo)))
                        <img src="{{ asset($school->logo) }}" class="school-logo" alt="Logo">
                    @else
                        <div class="school-logo" style="display: inline-flex; align-items: center; justify-content: center; font-weight: bold; color: #ffffff; font-size: 15px;"><i class="fa-solid fa-school"></i></div>
                    @endif
                    <h1 class="school-name-text">{{ $school?->name ?? 'School Name' }}</h1>
                </div>

                <div class="photo-border">
                    @if($student->photo && file_exists(public_path($student->photo)))
                        <img src="{{ asset($student->photo) }}" alt="{{ $student->name }}">
                    @else
                        <img src="{{ asset('assets/images/profile.webp') }}" alt="Student">
                    @endif
                </div>

                <div class="details">
                    <div class="name-badge">
                        <span class="name">{{ $student->name }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Class</span>
                        <span class="val">: {{ $student->class->name }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Roll No</span>
                        <span class="val">: {{ $student->roll }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Student ID</span>
                        <span class="val">: {{ $student->student_id }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Guardians</span>
                        <span class="val">: {{ $student->fathers_name ?: 'N/A' }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Blood Group</span>
                        <span class="val">: {{ $student->blood_group ?: 'N/A' }}</span>
                    </div>

                    <div class="row-info">
                        <span class="label">Emergency</span>
                        <span class="val">: {{ $student->contact_number ?: 'N/A' }}</span>
                    </div>
                </div>

                <div class="front-signature">
                    @if($hasSignature)
                        <img src="{{ asset($schoolSig) }}" alt="Sign">
                    @else
                        <img src="{{ asset('assets/images/signature.png') }}" alt="Sign">
                    @endif
                    <p>Principal</p>
                </div>

                <div class="bottom-bar"></div>
            </div>
            <div style="font-size: 10px; font-weight: bold; text-align: center; color: #64748b; margin-top: 6px;">Front Side</div>
        </div>

        {{-- ── BACK SIDE ── --}}
        <div>
            <div class="card-container">
                <div class="dot-pattern"></div>
                <div class="back-top-bar"></div>

                <div class="back-header">
                    TERMS AND CONDITIONS
                </div>

                <div class="terms-text">
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        <li style="margin-bottom: 3px;">• This card is the property of <strong>{{ $school?->name }}</strong>.</li>
                        <li>• If found, please return to the school office immediately.</li>
                    </ul>
                </div>

                <div class="extra-info-section">
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
                        <span>: {{ $student->academicYear?->end_date ? \Carbon\Carbon::parse($student->academicYear->end_date)->format('M Y') : 'N/A' }}</span>
                    </div>
                </div>

                <div class="school-info-section">
                    <div style="margin-bottom: 2px; display: flex; align-items: center;">
                        <strong style="color: #6a1b9a; width: 50px;">Phone</strong> 
                        <span>: {{ $school?->phone ?? '01XXX-XXXXXX' }}</span>
                    </div>
                    <div style="margin-bottom: 2px; display: flex; align-items: center;">
                        <strong style="color: #6a1b9a; width: 50px;">Website</strong> 
                        <span>: {{ $fullUrl ?? 'www.school.com' }}</span>
                    </div>
                </div>

                <div class="qr-section">
                    <div style="display: inline-block; padding: 3px; border: 1px solid #eee; background: white; border-radius: 4px;">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(42)->color(106, 27, 154)->generate("ID: " . $student->student_id . " | Name: " . $student->name) !!}
                    </div>
                    <div style="font-size: 7px; margin-top: 2px; font-weight: bold; color: #6a1b9a;">
                        {{ $student->student_id }}
                    </div>
                </div>

                <div class="bottom-bar"></div>
            </div>
            <div style="font-size: 10px; font-weight: bold; text-align: center; color: #64748b; margin-top: 6px;">Back Side</div>
        </div>
    </div>
</body>
</html>