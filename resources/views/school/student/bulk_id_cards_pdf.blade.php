<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student ID Cards - {{ $class->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0.25in 0.35in 0.25in 0.35in;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #1e293b;
            background: #ffffff;
        }

        .page-break {
            page-break-after: always;
        }

        /* ── 2x2 Page Layout Grid (4 Students per page) ── */
        .page-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .student-cell {
            width: 50%;
            padding: 6px 10px 10px 10px;
            vertical-align: top;
            text-align: center;
        }

        /* ── Front & Back Pair side-by-side for easy cutting & folding ── */
        .card-pair-table {
            border-collapse: collapse;
            margin: 0 auto;
        }
        .card-pair-table td.side-td {
            padding: 0;
            vertical-align: top;
        }
        .card-pair-table td.cut-divider-td {
            width: 4px;
            padding: 0;
            vertical-align: middle;
            border-left: 1px dashed #94a3b8;
        }

        /* ── Standard ID Card Container (CR80 Standard: 153pt x 243pt) ── */
        .card-container {
            width: 153pt;
            height: 243pt;
            background: #ffffff;
            position: relative;
            overflow: hidden;
            border: 0.5px solid #d1d5db;
            border-radius: 9px;
            text-align: left;
        }

        /* ── Background & Shapes ── */
        .dot-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 153pt;
            height: 243pt;
            z-index: 0;
        }
        .top-header-shape {
            position: absolute;
            top: 0;
            left: 0;
            width: 153pt;
            height: 100pt;
            z-index: 1;
        }
        .bottom-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 153pt;
            height: 8pt;
            z-index: 2;
        }
        .back-top-bar {
            position: absolute;
            top: 0;
            left: 0;
            width: 153pt;
            height: 18pt;
            z-index: 1;
        }

        /* ── FRONT SIDE ── */
        .front-signature {
            position: absolute;
            bottom: 11pt;
            right: 8pt;
            text-align: center;
            z-index: 3;
        }
        .front-signature img {
            max-height: 18pt;
            max-width: 42pt;
            display: block;
            margin: 0 auto -2px auto;
        }
        .front-signature p {
            margin: 0;
            font-size: 5.5pt;
            font-weight: 800;
            border-top: 0.5px solid #333;
            color: #1e293b;
            width: 40pt;
            text-align: center;
        }

        /* ── BACK SIDE ── */
        .back-header {
            width: 130pt;
            background: #f3e8ff;
            color: #6a1b9a;
            text-align: center;
            font-size: 8pt;
            font-weight: 800;
            padding: 2.5pt 0;
            border-radius: 3px;
            letter-spacing: 0.3px;
            margin: 0 auto;
        }
        .b-lbl {
            width: 48pt;
            font-weight: bold;
            color: #6a1b9a;
            font-size: 8pt;
        }
        .b-val {
            color: #334155;
            font-size: 8pt;
        }
    </style>
</head>
<body>

@php
    $currentSchool = $school ?? ($students->first()?->school ?? (app()->bound('currentSchool') ? app('currentSchool') : null));
    $schoolName = $currentSchool?->name ?? 'SCHOOL NAME';
    $schoolLogo = $currentSchool?->logo ?? null;
    $schoolSig = $currentSchool?->signature ?? null;
    $schoolPhone = $currentSchool?->phone ?? '01XXX-XXXXXX';
    $schoolSlug = $currentSchool?->slug ?? 'school';
    $mainDomain = parse_url(config('app.url'), PHP_URL_HOST) ?? 'schoolerp.test';
    $fullUrl = $schoolSlug . '.' . $mainDomain;

    $totalChunks = $students->chunk(4)->count();
    $chunkIndex = 0;
@endphp

@foreach($students->chunk(4) as $chunk)
    @php $chunkIndex++; @endphp
    <table class="page-grid" cellpadding="0" cellspacing="0">
        @foreach($chunk->chunk(2) as $rowStudents)
            <tr>
                @foreach($rowStudents as $student)
                    @php
                        $photoPath = $student->photo && file_exists(public_path($student->photo))
                            ? public_path($student->photo)
                            : (file_exists(public_path('assets/images/profile.webp')) ? public_path('assets/images/profile.webp') : null);

                        $qrSvg = null;
                        try {
                            $qrText = "ID: {$student->student_id} | Name: {$student->name}";
                            $qrSvg = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(40)->color(106, 27, 154)->generate($qrText));
                        } catch (\Throwable $e) {
                            $qrSvg = null;
                        }

                        $sessionName = $student->academicYear->name ?? (date('Y'));
                        $validUpTo = $student->academicYear?->end_date ? \Carbon\Carbon::parse($student->academicYear->end_date)->format('M Y') : 'Dec ' . date('Y');
                        $dobStr = $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d-m-Y') : 'N/A';
                        $studentSig = $student->school->signature ?? $schoolSig;
                        $hasSig = !empty($studentSig) && file_exists(public_path($studentSig));
                        $studentSchoolName = $student->school->name ?? $schoolName;
                        $studentLogo = $student->school->logo ?? $schoolLogo;
                        $hasStuLogo = !empty($studentLogo) && file_exists(public_path($studentLogo));
                    @endphp
                    <td class="student-cell">
                        <table class="card-pair-table" cellpadding="0" cellspacing="0">
                            <tr>
                                {{-- ── FRONT SIDE ── --}}
                                <td class="side-td">
                                    <div class="card-container">
                                        <img src="{{ public_path('assets/images/id_card/dot_pattern.png') }}" class="dot-pattern">
                                        <img src="{{ public_path('assets/images/id_card/header_shape.png') }}" class="top-header-shape">

                                        {{-- 1. School Logo & School Name (Exact Symmetrical Centering) --}}
                                        <div style="position: absolute; top: 6pt; left: 0; width: 153pt; text-align: center; z-index: 3;">
                                            <table style="width: 153pt; border-collapse: collapse; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
                                                @if($hasStuLogo)
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <img src="{{ public_path($studentLogo) }}" style="max-height: 26pt; max-width: 50pt; object-fit: contain; display: inline-block;">
                                                    </td>
                                                </tr>
                                                @else
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <div style="height: 26pt;"></div>
                                                    </td>
                                                </tr>
                                                @endif
                                                <tr>
                                                    <td align="center" style="padding: 2pt 6pt 0 6pt; text-align: center;">
                                                        <div style="font-size: 11pt; font-weight: bold;text-transform: uppercase; color: #ffffff; line-height: 1.1; white-space: normal; overflow: wrap; text-align: center;">
                                                            {{ $studentSchoolName }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 2. Student Photo (Exact Symmetrical Centering) --}}
                                        <div style="position: absolute; top: 60pt; left: 0; width: 153pt; text-align: center; z-index: 4;">
                                            <table style="width: 153pt; border-collapse: collapse; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <div style="width: 54pt; height: 54pt; background: #ffffff; border-radius: 50%; padding: 2px; border: 2px solid #6a1b9a; display: inline-block;">
                                                            @if($photoPath)
                                                                <img src="{{ $photoPath }}" style="width: 100%; height: 100%; border-radius: 50%; display: block;">
                                                            @else
                                                                <div style="width: 100%; height: 100%; border-radius: 50%; background: #e2e8f0; line-height: 50pt; font-size: 7pt; color: #64748b; text-align: center;">Photo</div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 3. Student Name Badge (Exact Symmetrical Centering) --}}
                                        <div style="position: absolute; top: 121pt; left: 0; width: 153pt; text-align: center; z-index: 3;">
                                            <table style="width: 153pt; border-collapse: collapse; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <div style="background-color: #841778; border-radius: 7px; font-size: 9pt; padding: 2pt 8pt; font-weight: bold; color: #ffffff; display: inline-block; white-space: nowrap; overflow: hidden; text-transform: uppercase;">
                                                            {{ $student->name }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 4. Details Table (Equal margins on left and right) --}}
                                        <div style="position: absolute; top: 139pt; left: 0; width: 153pt; z-index: 3;">
                                            <table style="width: 137pt; margin: 0 8pt; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Class') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->class->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Roll No') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->roll }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Student ID') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->student_id }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Guardians') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->fathers_name ?: 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Blood Group') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->blood_group ?: 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 42%; font-size: 8pt; font-weight: bold; color: #6a1b9a; padding: 0.5pt 0;">{{ __('Emergency') }}</td>
                                                    <td style="width: 58%; font-size: 8pt; font-weight: bold; color: #1e293b; padding: 0.5pt 0; white-space: nowrap; overflow: hidden;">: {{ $student->contact_number ?: 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 5. Front Signature --}}
                                        <div class="front-signature">
                                            @if($hasSig)
                                                <img src="{{ public_path($studentSig) }}" alt="Sign">
                                            @elseif(file_exists(public_path('assets/images/signature.png')))
                                                <img src="{{ public_path('assets/images/signature.png') }}" alt="Sign">
                                            @else
                                                <div style="height: 18pt;"></div>
                                            @endif
                                            <p>{{ __('Principal') }}</p>
                                        </div>

                                        <img src="{{ public_path('assets/images/id_card/gradient_bar.png') }}" class="bottom-bar">
                                    </div>
                                </td>

                                {{-- Middle Cut / Fold Guideline --}}
                                <td class="cut-divider-td">&nbsp;</td>

                                {{-- ── BACK SIDE ── --}}
                                <td class="side-td">
                                    <div class="card-container">
                                        <img src="{{ public_path('assets/images/id_card/dot_pattern.png') }}" class="dot-pattern">
                                        <img src="{{ public_path('assets/images/id_card/gradient_bar.png') }}" class="back-top-bar">

                                        {{-- 1. Terms and Conditions Header Box (Centered) --}}
                                        <div style="position: absolute; top: 24pt; left: 0; width: 153pt; text-align: center; z-index: 2;">
                                            <table style="width: 153pt; border-collapse: collapse; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <div class="back-header">
                                                            {{ __('TERMS AND CONDITIONS') }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 2. Terms Text --}}
                                        <div style="position: absolute; top: 43pt; left: 0; width: 153pt; z-index: 2;">
                                            <div style="width: 137pt; margin: 0 8pt; font-size: 7pt; color: #334155; line-height: 1.25;">
                                                <div style="margin-bottom: 2pt;">• This card is the property of <strong>{{ $studentSchoolName }}</strong>.</div>
                                                <div>• If found, please return to the school office immediately.</div>
                                            </div>
                                        </div>

                                        {{-- 3. Extra Info (Session, DOB, Valid Up To) --}}
                                        <div style="position: absolute; top: 72pt; left: 0; width: 153pt; z-index: 2;">
                                            <table style="width: 137pt; margin: 0 8pt; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="b-lbl">Session</td>
                                                    <td class="b-val">: {{ $sessionName }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="b-lbl">D.O.B</td>
                                                    <td class="b-val">: {{ $dobStr }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="b-lbl">Valid Up To</td>
                                                    <td class="b-val">: {{ $validUpTo }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 4. School Info (Phone & Website) --}}
                                        <div style="position: absolute; top: 114pt; left: 0; width: 153pt; z-index: 2;">
                                            <table style="width: 137pt; margin: 0 8pt; border-collapse: collapse;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="b-lbl">Phone</td>
                                                    <td class="b-val">: {{ $student->school->phone ?? $schoolPhone }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="b-lbl">Website</td>
                                                    <td class="b-val" style="white-space: nowrap; overflow: hidden;">: {{ $fullUrl }}</td>
                                                </tr>
                                            </table>
                                        </div>

                                        {{-- 5. QR Code Section (Centered) --}}
                                        <div style="position: absolute; top: 154pt; left: 0; width: 153pt; text-align: center; z-index: 2;">
                                            <table style="width: 153pt; border-collapse: collapse; margin: 0; padding: 0;" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td align="center" style="padding: 0; text-align: center;">
                                                        <div style="display: inline-block; padding: 2px; border: 0.5px solid #cbd5e1; background: white; border-radius: 4px;">
                                                            @if($qrSvg)
                                                                <img src="data:image/svg+xml;base64,{!! $qrSvg !!}" style="width: 36pt; height: 36pt; display: block;">
                                                            @endif
                                                        </div>
                                                        <div style="font-size: 6.5pt; margin-top: 2pt; font-weight: bold; color: #6a1b9a; text-align: center;">
                                                            {{ $student->student_id }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        <img src="{{ public_path('assets/images/id_card/gradient_bar.png') }}" class="bottom-bar">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                @endforeach

                {{-- If single student on last row, fill empty cell for layout alignment --}}
                @if($rowStudents->count() == 1)
                    <td class="student-cell">&nbsp;</td>
                @endif
            </tr>
        @endforeach
    </table>

    @if($chunkIndex < $totalChunks)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
