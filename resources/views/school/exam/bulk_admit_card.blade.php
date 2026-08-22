<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Admit Card - {{ $exam->name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 10mm 14mm 10mm 14mm;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Helvetica, Arial, sans-serif;
            color: #0f172a;
            background: #ffffff;
            font-size: 11px;
            line-height: 1.1;
            margin: 20px;
        }

        /* ── Main Outer Table Container for DomPDF stability ── */
        .card-table-wrap {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-bottom: 0;

        }
        .card-table-wrap td.card-cell {
            border: 1.5px solid #0f172a;
            border-radius: 4px;
            padding: 4px 8px 3px 8px;
            background: #ffffff;
            vertical-align: top;
        }

        .card-content {
            position: relative;
        }

        /* ── Header: Logo | School Info | QR ── */
        .header-tbl {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1.5px solid #0f172a;
            padding-bottom: 2px;
            margin-bottom: 2px;
            table-layout: fixed;
        }
        .hdr-logo {
            width: 70px;
            vertical-align: middle;
            text-align: left;
            padding: 10px;
        }
        .hdr-logo img { 
            width: 70px; 
            height: 70px;
            object-fit: contain;
            border-radius: 4px;
        }
        .hdr-center {
            vertical-align: middle;
            text-align: center;
            padding: 0 4px;
        }
        .school-name {
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f172a;
            margin: 0 0 1px 0;
            line-height: 1.05;
            white-space: nowrap;
        }
        .school-meta {
            font-size: 9px;
            color: #334155;
            margin: 1px 0;
            line-height: 1.05;
        }
        .school-code-line {
            font-size: 8.5px;
            color: #475569;
            margin: 0.5px 0;
            font-weight: 600;
            line-height: 1;
        }
        .exam-name-line {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 1px 0;
            line-height: 1;
        }
        .admit-badge {
            display: inline-block;
            background: #1e3a8a; 
            color: #0f172a;
            padding: 1.5px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 3px;
            letter-spacing: 0.8px;
            line-height: 1.05;
            margin-top: 10px;
            padding: 5px 10px;
        }
        .hdr-qr {
            width: 70px;
            vertical-align: middle;
            text-align: right;
        }
        .qr-box {
            display: inline-block;
            padding: 1px;
            background: #fff;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
        }

        /* ── Student Info Table ── */
        .student-info-tbl {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 3px;
            margin-bottom: 2px;
            margin-top: 2px;
            table-layout: fixed;
        }
        .student-info-tbl td {
            padding: 1.5px 4px;
            vertical-align: middle;
            font-size: 10px;
            line-height: 1.05;
            padding: 5px 3px;
        }
        .lbl {
            color: #475569;
            font-weight: bold;
            width: 13%;
            font-size: 9.5px;
        }
        .val {
            color: #0f172a;
            font-weight: bold;
            width: 20%;
            font-size: 10px;
        }
        .val-name {
            color: #1e3a8a;
            font-weight: bold;
            width: 34%;
            font-size: 10px;
        }

        /* ── Routine Section (2 Columns with Time) ── */
        .routine-heading {
            font-size: 11px;
            font-weight: bold;
            color: #0f172a;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 2px 6px;
            border-radius: 2px;
            margin-bottom: 2px;
            margin-top: 10px;
            padding: 5px 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: center; 
            line-height: 1.05;
        }
        .routine-grid-tbl {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .sub-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px; 
            table-layout: fixed;
        }
        .sub-tbl th {
            background: #1e293b;
            color: #ffffff; 
            font-size: 11px;
            font-weight: bold;
            padding: 1.5px 3px;
            border: 1px solid #1e293b;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.05;
        }
        .sub-tbl td {
            padding: 1.5px 3px;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            vertical-align: middle;
            line-height: 1.05;
            font-size: 11px; 
        }
        .sub-tbl tr:nth-child(even) td {
            background: #f8fafc;
        }
        .no-rtn {
            font-size: 9px;
            color: #94a3b8;
            font-style: italic;
            padding: 3px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 3px;
            line-height: 1.05;
        }

        /* ── Signatures ── */
        .footer-wrap {
            margin-top: 35px;
            padding-top: 0;
        }
        .footer-tbl {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .sig-box {
            width: 40%;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            padding-top: 3px;
            border-top: 1px dashed #334155;
            line-height: 1.05;
        }

        /* Scissor cut line */
        .cut-line {
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #64748b;
            margin: 1.5mm 0;
            line-height: 1;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    @foreach($students->chunk(3) as $chunkIndex => $pair)
        @foreach($pair as $pairIndex => $student)
            @php
                $studentSubCategoryId = $student->school_sub_category_id;
                
                // Filter routines for this specific student:
                // Look up subcategory from assign_classes (where class-subject mappings are stored), then fallback to subject
                $studentRoutines = $examRoutines->filter(function($rtn) use ($studentSubCategoryId, $assignClasses) {
                    $ac = isset($assignClasses) ? $assignClasses->get($rtn->subject_id) : null;
                    $subCatId = $ac ? $ac->school_sub_category_id : $rtn->subject?->school_sub_category_id;

                    if ($studentSubCategoryId) {
                        // Common/compulsory subject (null) OR matches student's group/subcategory
                        return empty($subCatId) || $subCatId == $studentSubCategoryId;
                    }
                    // If student has no group, include common subjects (null)
                    return empty($subCatId);
                });

                // Fallback: If no routines match the filter, fallback to all class routines
                if ($studentRoutines->isEmpty()) {
                    $studentRoutines = $examRoutines;
                }

                $totalRoutines = $studentRoutines->count();
                $half = ceil($totalRoutines / 2);
                $colA = $studentRoutines->slice(0, $half);
                $colB = $studentRoutines->slice($half);
            @endphp

            {{-- ── ADMIT CARD BOX TABLE WRAPPER ── --}}
            <table class="card-table-wrap" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="card-cell">
                        <div class="card-content">
                            {{-- 1. Header: Logo | School Info Center | QR --}}
                            <table class="header-tbl" cellpadding="0" cellspacing="0">
                                <tr>
                                    {{-- Left: School Logo --}}
                                    <td class="hdr-logo">
                                        @if($school && $school->logo && file_exists(public_path($school->logo)))
                                            <img src="{{ public_path($school->logo) }}">
                                        @else
                                            <div style="width:78px; height:78px; border:1px solid #cbd5e1; border-radius:4px; text-align:center; line-height:78px; font-size:9px; color:#94a3b8; background:#f8fafc;">LOGO</div>
                                        @endif
                                    </td>

                                    {{-- Center: School Name, School Code Only, Exam, Badge --}}
                                    <td class="hdr-center">
                                        <div class="school-name">{{ $school?->name ?? 'SCHOOL NAME' }}</div>

                                        @php
                                            $schoolCode = $school?->app_code ?? $school?->emis_code ?? $school?->ein_number ?? null;
                                        @endphp
                                        @if($schoolCode)
                                            <div class="school-code-line">School Code: {{ $schoolCode }}</div>
                                        @endif

                                        <div class="exam-name-line">{{ $exam?->name ?? 'EXAM' }} &mdash; {{ date('Y') }}</div>
                                        <div><span class="admit-badge">ADMIT CARD</span></div>
                                    </td>

                                    {{-- Right: QR Code --}}
                                    <td class="hdr-qr">
                                        <div class="qr-box">
                                            @php
                                                $qrSvg = null;
                                                try {
                                                    $groupStr = $student->group->name ?? '';
                                                    $qrData = "ID: {$student->student_id}\nName: {$student->name}\nRoll: {$student->roll}\nClass: " . ($student->class->name ?? '') . ($groupStr ? "\nGroup: {$groupStr}" : '') . "\nExam: " . ($exam->name ?? '');
                                                    $qrSvg = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(60)->generate($qrData));
                                                } catch (\Throwable $e) {
                                                    $qrSvg = null;
                                                }
                                            @endphp
                                            @if($qrSvg)
                                                <img src="data:image/svg+xml;base64,{!! $qrSvg !!}" style="width:60px; height:60px; display:block;">
                                            @else
                                                <div style="width:60px; height:60px; border:1px solid #cbd5e1; border-radius:4px; text-align:center; line-height:60px; font-size:8px; color:#94a3b8; background:#f8fafc;">QR CODE</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            {{-- 2. Student Info --}}
                            <table class="student-info-tbl" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="lbl">Name</td>
                                    <td class="val-name" colspan="3">: {{ strtoupper($student->name) }}</td>
                                    <td class="lbl">Class</td>
                                    <td class="val">: {{ $student->class->name ?? 'N/A' }}</td>
                                    <td class="lbl">Roll</td>
                                    <td class="val">: {{ $student->roll ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">ID</td>
                                    <td class="val" colspan="3">: {{ $student->student_id ?? 'N/A' }}</td>
                                    <td class="lbl">Section</td>
                                    <td class="val">: {{ $student->section->name ?? 'N/A' }}</td>
                                    <td class="lbl">Session</td>
                                    <td class="val">: {{ date('Y') }}</td>
                                </tr>
                            </table>

                            {{-- 3. Exam Routine (2 Columns with Time) --}}
                            <div class="routine-heading">{{ $exam->name }} Routine</div>
                            @if($totalRoutines > 0)
                                <table class="routine-grid-tbl" cellpadding="0" cellspacing="0">
                                    <tr>
                                        {{-- Column A --}}
                                        <td style="width: 49%; vertical-align: top;">
                                            <table class="sub-tbl" cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 25%;">Date</th>
                                                        <th style="width: 55%;">Subject</th>
                                                        <th style="width: 20%;">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($colA as $rtn)
                                                        <tr>
                                                            <td style="font-weight: bold; text-align: center; white-space: nowrap; font-size: 11px;">
                                                                {{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td style="font-weight: bold; font-size: 11px;">
                                                                {{ $rtn->subject->name ?? 'N/A' }}
                                                            </td>
                                                            <td style="text-align: center; white-space: nowrap; font-size: 10px; font-weight: 600;">
                                                                {{ $rtn->start_time ? \Carbon\Carbon::parse($rtn->start_time)->format('h:i A') : '-' }}
                                                                {{ $rtn->end_time ? '- ' . \Carbon\Carbon::parse($rtn->end_time)->format('h:i A') : '' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>

                                        <td style="width: 2%;"></td>

                                        {{-- Column B --}}
                                        <td style="width: 49%; vertical-align: top;">
                                            <table class="sub-tbl" cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 25%;">Date</th>
                                                        <th style="width: 55%;">Subject</th>
                                                        <th style="width: 20%;">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($colB as $rtn)
                                                        <tr>
                                                            <td style="font-weight: bold; text-align: center; white-space: nowrap; font-size: 11px;">
                                                                {{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td style="font-weight: bold; font-size: 11px;">
                                                                {{ $rtn->subject->name ?? 'N/A' }}
                                                            </td>
                                                            <td style="text-align: center; white-space: nowrap; font-size: 10px; font-weight: 600;">
                                                                {{ $rtn->start_time ? \Carbon\Carbon::parse($rtn->start_time)->format('h:i A') : '-' }}
                                                                {{ $rtn->end_time ? '- ' . \Carbon\Carbon::parse($rtn->end_time)->format('h:i A') : '' }}
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr><td colspan="3" style="text-align:center; color:#94a3b8;">&mdash;</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <div class="no-rtn">No examination routine has been scheduled for this class.</div>
                            @endif

                            {{-- 4. Signature Footer (with proper space above) --}}
                            <div class="footer-wrap">
                                <table class="footer-tbl" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="sig-box">Class Teacher</td>
                                        <td style="width: 20%;"></td>
                                        <td class="sig-box">Principal / Headmaster</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            {{-- Scissor cut line between cards --}}
            @if(!$loop->last)
                <div class="cut-line">
                    &#9986; -----------------------------------------------------------------------------------------------------------------------------------------------
                </div>
            @endif
        @endforeach

        {{-- Page break after every 3 students --}}
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
</body>
</html>