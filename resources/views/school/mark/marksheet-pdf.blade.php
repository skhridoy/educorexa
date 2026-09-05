<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grade & Mark Sheet - {{ $student->name }}</title>
    <style>
        @page {
            margin: 20px 24px 16px 24px;
            size: A4 portrait;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #000;
            margin: 0; padding: 0;
            line-height: 1.25;
        }
        .page-border {
            border: 2px solid #000;
            padding: 10px 12px;
            position: relative;
            min-height: 1045px;
        }

        /* ── WATERMARK ── */
        .watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1000;
            pointer-events: none;
            text-align: center;
        }
        .watermark img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 380px;
            height: auto;
            margin-top: -190px;
            margin-left: -190px;
            opacity: 0.07;
        }

        /* ── HEADER ── */
        .hdr { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .hdr-logo { width: 75px; vertical-align: middle; text-align: right; padding-right: 8px; }
        .hdr-logo img { width: 68px; height: 68px; object-fit: contain; display: inline-block; }
        .hdr-text { text-align: center; vertical-align: middle; padding: 0 4px; }
        .school-title {
            font-family: 'Helvetica Neue', 'Arial Black', Arial, sans-serif;
            font-size: 26px;
            font-weight: 900;
            letter-spacing: 0.6px;
            margin: 0 0 2px 0;
            text-transform: uppercase;
            color: #111;
        }
        .exam-title {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 1px 0;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .class-sub {
            font-size: 11px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }
        .hdr-grade { width: 120px; vertical-align: middle; }
        .hdr-grade table { width: 100%; border-collapse: collapse; font-size: 8px; text-align: center; }
        .hdr-grade th, .hdr-grade td { border: 1px solid #000; padding: 1px 1.5px; }
        .hdr-grade th { font-weight: bold; background: #eee; }

        /* ── STUDENT INFO (2 PARTS) ── */
        .sinfo {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin: 3px 0 4px 0;
        }
        .sinfo td { vertical-align: top; padding: 0.5px 2px; }
        .lbl { font-weight: bold; white-space: nowrap; }

        .info-card {
            border: 1px solid #000;
            padding: 4px 6px;
            background: transparent;
        }
        .info-card table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .info-card td { padding: 1px 0; }

        /* ── SECTION BANNER ── */
        .banner {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin: 10px 0 5px 0;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            padding: 5px 10px;
            border: 1px solid #000; 
            border-radius: 5px;
        }

        /* ── MARKS TABLE ── */
        .mt { width: 100%; border-collapse: collapse; font-size: 11px; margin-bottom: 5px; }
        .mt th, .mt td { border: 1px solid #000; padding: 2.5px 1.5px; text-align: center; height: 14px; }
        .mt th { font-weight: bold; text-transform: uppercase; font-size: 11px; }
        .tl { text-align: left; padding-left: 6px !important; font-size: 11px; font-weight: bold; color: #111; }
        .bd { font-weight: bold; }

        /* ── BOTTOM AREA ── */
        .bot { width: 100%; border-collapse: collapse; margin-top: 3px; }
        .bot td { vertical-align: top; padding: 0; }
        .bx { border: 1px solid #000; }
        .bxh {
            text-align: center; font-weight: bold; font-size: 10px;
            padding: 2px; border-bottom: 1px solid #000; text-transform: uppercase;
        }
        .bxsh {
            text-align: center; font-size: 10px; padding: 1.5px;
            border-bottom: 1px solid #000; font-weight: bold;
        }
        .mt2 { width: 100%; border-collapse: collapse; text-align: center; font-size: 10px; }
        .mt2 td { border: 1px solid #000; padding: 1.5px 2px; height: 12px; }

        /* ── SIGNATURE ── */
        .footer-sig {
            position: absolute;
            bottom: 30px;
            left: 12px;
            right: 12px;
        }
        .sig { width: 100%; border-collapse: collapse; margin: 0; }
        .sig td { text-align: center; font-size: 10px; font-weight: bold; }
        .sig-line { border-top: 1px dotted #000; display: inline-block; width: 150px; padding-top: 4px; }
    </style>
</head>
<body>
@if(!empty($watermarkLogo ?? $instituteLogo))
<div class="watermark">
    <img src="{{ $watermarkLogo ?? $instituteLogo }}" alt="Watermark">
</div>
@endif
<div class="page-border">

{{-- 1. HEADER --}}
<table class="hdr">
    <tr>
        <td class="hdr-logo">
            @if(!empty($instituteLogo))<img src="{{ $instituteLogo }}" alt="Logo">@endif
        </td>
        <td class="hdr-text">
            <div class="school-title">{{ $schoolName }}</div>
            <div class="exam-title">{{ strtoupper($exam->name) }}-{{ $academic_year ?? date('Y') }}</div>
            <div class="class-sub">{{ strtoupper($class->name) }} / EQUIVALENT RESULT PUBLICATION {{ $academic_year ?? date('Y') }}</div>
        </td>
        <td class="hdr-grade">
            <table>
                <thead><tr><th>Range</th><th>Grade</th><th>GP</th></tr></thead>
                <tbody>
                    <tr><td>80-100</td><td class="bd">A+</td><td>5.00</td></tr>
                    <tr><td>70-79</td><td class="bd">A</td><td>4.00</td></tr>
                    <tr><td>60-69</td><td class="bd">A-</td><td>3.50</td></tr>
                    <tr><td>50-59</td><td class="bd">B</td><td>3.00</td></tr>
                    <tr><td>40-49</td><td class="bd">C</td><td>2.00</td></tr>
                    <tr><td>33-39</td><td class="bd">D</td><td>1.00</td></tr>
                    <tr><td>00-32</td><td class="bd">F</td><td>0.00</td></tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>

<div class="banner">STUDENT'S INFORMATION</div>
{{-- 2. STUDENT INFO (2 BALANCED 5-ROW PARTS: LEFT & RIGHT) --}}
@php
    $grp = $student->group ?? '';
    if (is_string($grp) && str_starts_with(trim($grp), '{')) {
        $dGrp = json_decode($grp, true);
        $grp  = $dGrp['name'] ?? $dGrp['NAME'] ?? '';
    } elseif (is_object($grp)) {
        $grp = $grp->name ?? '';
    }
    $sec = is_object($student->section) ? ($student->section->name ?? '') : ($student->section ?? '');
@endphp
<table class="sinfo">
    <tr>
        {{-- PART 1: LEFT SIDE (50%) --}}
        <td style="width: 50%; padding-right: 4px;">
            <div class="info-card">
                <table>
                    <tr><td style="width: 55px;" class="lbl">NAME</td><td>: {{ strtoupper($student->name) }}</td></tr>
                    <tr><td class="lbl">FATHER</td><td>: {{ strtoupper($student->fathers_name ?? 'N/A') }}</td></tr>
                    <tr><td class="lbl">MOTHER</td><td>: {{ strtoupper($student->mothers_name ?? 'N/A') }}</td></tr>
                    <tr><td class="lbl">SID</td><td>: {{ $displayCustomId ?? ($student->student_id ?? $student->id) }}</td></tr>
                    <tr><td class="lbl">DOB</td><td>: {{ $formattedDOB }}</td></tr>
                </table>
            </div>
        </td>

        {{-- PART 2: RIGHT SIDE (50%) --}}
        <td style="width: 50%;">
            <div class="info-card">
                <table>
                    <tr>
                        <td style="width: 48px;" class="lbl">CLASS</td>
                        <td>: {{ strtoupper($class->name) }}</td>
                        <td style="width: 65px;" class="lbl">ROLL NO</td>
                        <td>: {{ $displayRoll ?? $student->roll }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">SECTION</td>
                        <td>: {{ strtoupper($sec) }}</td>
                        <td class="lbl">GPA</td>
                        <td>: {{ $numericGpa ?? '0.00' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">GROUP</td>
                        <td>: {{ strtoupper($grp !== '' ? $grp : 'GENERAL') }}</td>
                        <td class="lbl">GRADE</td>
                        <td>: {{ $finalGrade ?? 'F' }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">SHIFT</td>
                        <td>: {{ strtoupper($student->shift ?? 'DAY') }}</td>
                        <td class="lbl">MERIT</td>
                        <td>: {{ $meritPosition }}{{ in_array($meritPosition % 100,[11,12,13]) ? 'TH' : (match($meritPosition % 10){1=>'ST',2=>'ND',3=>'RD',default=>'TH'}) }}</td>
                    </tr>
                    <tr>
                        <td class="lbl">BOARD</td>
                        <td>: {{ strtoupper($student->board ?? 'DINAJPUR') }}</td>
                        <td class="lbl">TOTAL MARK</td>
                        <td>: {{ $totalMarks }}</td>
                    </tr>
                </table>
            </div>
        </td>
    </tr>
</table>

{{-- 3. SECTION BANNER --}}
<div class="banner">SUBJECT-WISE GRADE & MARK SHEET</div>

{{-- 4. MARKS TABLE --}}
@php
    $ml     = array_values($marksData);
    $mcount = count($ml);
    $fmt = function($val) {
        if ($val === null || $val === '') return '';
        if (!is_numeric($val)) return $val;
        return ((float)$val == (int)$val) ? (int)$val : (float)$val;
    };
@endphp
<table class="mt">
    <thead>
        <tr>
            <th rowspan="2" style="width: 6%;">CODE</th>
            <th rowspan="2" style="width: 36%;">SUBJECT</th>
            <th colspan="7" style="text-align: center;">{{ strtoupper($exam->name) }}</th>
            <th rowspan="2" style="width: 6%;">GPA</th>
        </tr>
        <tr>
            <th style="width: 5%;">CQ</th>
            <th style="width: 5%;">MCQ</th>
            <th style="width: 7%;">CA/Prac.</th>
            <th style="width: 7%;">Total</th>
            <th style="width: 6%;">High.</th>
            <th style="width: 6%;">GP</th>
            <th style="width: 7%;">Grade</th>
        </tr>
    </thead>
    <tbody>
        @for($i = 0; $i < $mcount; $i++)
            @php $res = $ml[$i]; @endphp

            @if(!empty($res['is_paired']))
                @if($res['is_first'])
                    @php
                        $nx  = ($i+1 < $mcount) ? $ml[$i+1] : null;
                        $ca1 = ($res['ca'] ?? null) !== null ? $fmt($res['ca']) : '';
                        $pr1 = ($res['practical'] ?? null) !== null ? $fmt($res['practical']) : '';
                        $cp1 = trim($ca1 . ($pr1 !== '' ? ($ca1 !== '' ? '/' : '') . $pr1 : ''));

                        $ca2 = ($nx && ($nx['ca'] ?? null) !== null) ? $fmt($nx['ca']) : '';
                        $pr2 = ($nx && ($nx['practical'] ?? null) !== null) ? $fmt($nx['practical']) : '';
                        $cp2 = trim($ca2 . ($pr2 !== '' ? ($ca2 !== '' ? '/' : '') . $pr2 : ''));

                        $cpM = $cp1 . ($cp2 !== '' ? ($cp1 !== '' ? '+' : '') . $cp2 : '');
                    @endphp
                    <tr>
                        <td>{{ $res['subject_code'] }}</td>
                        <td class="tl" style="text-align: left;">{{ strtoupper($res['subject_name']) }}</td>
                        <td>{{ ($res['cq'] ?? null) !== null ? $fmt($res['cq']) : '' }}</td>
                        <td>{{ ($res['mcq'] ?? null) !== null ? $fmt($res['mcq']) : '' }}</td>
                        <td rowspan="2" style="vertical-align: middle;">{{ $cpM }}</td>
                        <td rowspan="2" style="vertical-align: middle;">{{ $fmt($res['combined_marks'] ?? '') }}</td>
                        <td style="vertical-align: middle;">{{ is_numeric($res['highest_mark'] ?? null) && $res['highest_mark'] > 0 ? $fmt($res['highest_mark']) : '' }}</td>
                        <td rowspan="2" style="vertical-align: middle;">{{ number_format($res['point'] ?? 0, 1) }}</td>
                        <td rowspan="2"  style="vertical-align: middle;">{{ $res['grade'] ?? '-' }}</td>

                        {{-- GPA single merged cell across all rows --}}
                        @if($i === 0)
                            <td rowspan="{{ $mcount }}" style="vertical-align: middle; font-size: 11px; text-align: center;">
                                {{ $numericGpa ?? '0.00' }}
                            </td>
                        @endif
                    </tr>
                @else
                    <tr>
                        <td>{{ $res['subject_code'] }}</td>
                        <td class="tl" style="text-align: left;">{{ strtoupper($res['subject_name']) }}</td>
                        <td>{{ ($res['cq'] ?? null) !== null ? $fmt($res['cq']) : '' }}</td>
                        <td>{{ ($res['mcq'] ?? null) !== null ? $fmt($res['mcq']) : '' }}</td>
                        <td style="vertical-align: middle;">{{ $nx && is_numeric($nx['highest_mark'] ?? null) && $nx['highest_mark'] > 0 ? $fmt($nx['highest_mark']) : '' }}</td>

                        {{-- If 2nd paper happened to be first row (safety) --}}
                        @if($i === 0)
                            <td rowspan="{{ $mcount }}" style="vertical-align: middle; font-size: 11px; text-align: center;">
                                {{ $numericGpa ?? '0.00' }}
                            </td>
                        @endif
                    </tr>
                @endif
            @else
                @php
                    $caS = ($res['ca'] ?? null) !== null ? $fmt($res['ca']) : '';
                    $prS = ($res['practical'] ?? null) !== null ? $fmt($res['practical']) : '';
                    $cp  = trim($caS . ($prS !== '' ? ($caS !== '' ? '/' : '') . $prS : ''));
                @endphp
                <tr>
                    <td>{{ $res['subject_code'] }}</td>
                    <td class="tl" style="text-align: left;">{{ strtoupper($res['subject_name']) }}</td>
                    <td>{{ ($res['cq'] ?? null) !== null ? $fmt($res['cq']) : (($res['marks'] ?? null) !== null && ($res['mcq'] ?? null) === null && ($res['practical'] ?? null) === null ? $fmt($res['marks']) : '') }}</td>
                    <td>{{ ($res['mcq'] ?? null) !== null ? $fmt($res['mcq']) : '' }}</td>
                    <td>{{ $cp }}</td>
                    <td >{{ ($res['marks'] ?? null) !== null ? $fmt($res['marks']) : '—' }}</td>
                    <td>{{ !empty($res['highest_mark']) ? $fmt($res['highest_mark']) : '' }}</td>
                    <td >{{ number_format($res['point'] ?? 0, 1) }}</td>
                    <td >{{ $res['grade'] ?? '-' }}</td>

                    {{-- GPA single merged cell across all rows --}}
                    @if($i === 0)
                        <td rowspan="{{ $mcount }}" class="bd" style="vertical-align: middle; font-size: 11px; text-align: center;">
                            {{ $numericGpa ?? '0.00' }}
                        </td>
                    @endif
                </tr>
            @endif
        @endfor
    </tbody>
</table>

{{-- 5. SIGNATURES AT THE BOTTOM OF THE PAGE --}}
<div class="footer-sig">
    <table class="sig">
        <tr>
            <td style="width: 33%; vertical-align: bottom;">
                <div style="height: 28px;"></div>
                <span class="sig-line">Signature (Guardian)</span>
            </td>
            <td style="width: 34%; vertical-align: bottom;">
                <div style="height: 28px;"></div>
                <span class="sig-line">Signature (Class Teacher)</span>
            </td>
            <td style="width: 33%; vertical-align: bottom;">
                <div style="height: 28px; text-align: center;">
                    @if(!empty($headmasterSignature))
                        <img src="{{ $headmasterSignature }}" style="max-height: 28px; max-width: 110px; display: inline-block;">
                    @endif
                </div>
                <span class="sig-line">Signature (Head Master)</span>
            </td>
        </tr>
    </table>
</div>

</div>
</body>
</html>