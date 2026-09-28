<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Admit Card - {{ $exam->name }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            /* Default English font — Bengali text gets explicit lang="bn" spans → SolaimanLipi */
            font-family: dejavusans, sans-serif;
            color: #0f172a;
            background: #ffffff;
            font-size: 9.5px;
            line-height: 1.15;
        }
        /* Bengali text: always SolaimanLipi, never inherits Latin bold */
        .bn {
            font-family: solaimanlipi, kalpurush, sans-serif;
        }

        /* ── Card Container: 2 per A4 page ── */
        .card-table-wrap {
            width: 100%;
            height:133mm;
            min-height:110mm;
            border: 1.2px solid #0f172a;
            border-radius: 4px;
            padding: 4px 7px 4px 7px;
            background: #ffffff;
            margin-bottom: 2mm;
        }
        .card-content { position: relative; }

        /* ── Header ── */
        .header-tbl {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 1px solid #0f172a;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }
        .hdr-logo {
            width: 80px;
            max-width: 80px;
            vertical-align: middle;
            text-align: left;
        }
        .hdr-logo img {
            width: 80px;
            height: 80px;
            max-width: 80px;
            max-height: 80px;   
            display: block;
        }
        .hdr-center {
            vertical-align: middle;
            text-align: center;
            padding: 2px 5px;
        }
        /*
         * School name: NO CSS text-transform:uppercase.
         * mPDF applies text-transform before font-switching, so Bengali chars
         * inside a "bold + uppercase" block are routed to DejaVuSans-Bold which
         * has no Bengali glyphs → squares.  We uppercase ASCII in PHP instead.
         */
        .school-name {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            line-height: 1.2;
            margin-bottom: 1px;
        }
        .school-code-line {
            font-size: 10px;
            color: #475569;
            margin: 1px 0;
            font-weight: 600;
            line-height: 1.1;
        }
        .exam-name-line {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            margin: 5px 0;
            text-transform: uppercase;
            line-height: 1.15;
        }
        .admit-badge-div{
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 5px;
            height: 40px; 
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px !important;
            font-weight: bold;
            letter-spacing: 0.8px;
            line-height: 1.05;
            text-align: center;
        }
        .admit-badge {
            display: inline-block;
            background: #c6d3f7ff;  
            color: #0f172a;
            padding: 15px 10px !important;
            font-size: 12px !important;
            font-weight: bold;
            border-radius: 10px;
            letter-spacing: 0.8px;
            line-height: 1.05;
            margin-top: 10px !important;
            text-align: center;
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
            margin-top: 5px;
        }
        .student-info-tbl td {
            padding: 7px 10px;
            vertical-align: middle;
            font-size: 12px;
            line-height: 1.1;
        }
        .lbl {
            color: #475569;
            font-weight: bold;
            width: 11%;
            font-size: 12px;
        }
        .val {
            color: #0f172a;
            font-weight: bold;
            width: 20%;
            font-size: 12px;
        }
        .val-name {
            color: #1e3a8a;
            font-weight: bold;
            width: 31%;
            font-size: 11px;
        }

        /* ── Routine Section (2 Columns) ── */
        /*
         * NO text-transform:uppercase on .routine-heading — same mPDF bold+uppercase
         * issue.  We uppercase Latin parts in PHP ($wrapBn $upper=true).
         */
        .routine-heading {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
            border-radius: 2px;
            margin-bottom: 2px;
            margin-top: 8px;
            letter-spacing: 0.4px;
            text-align: center;
            line-height: 1.1;
        }
        .routine-grid-tbl {
            width: 100%;
            border-collapse: collapse;
        }
        .sub-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        .sub-tbl th {
            background: #e2e8f0;
            color: #0f172a;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 5px;
            border: 1px solid #cbd5e1;
            text-transform: uppercase;
            text-align: center;
            line-height: 1;
        }
        .sub-tbl td {
            padding: 2px 5px;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            vertical-align: middle;
            line-height: 1;
            font-size: 10px;
        }
        .sub-tbl tr:nth-child(even) td {
            background: #f8fafc;
        }
        .no-rtn {
            font-size: 11px;
            color: #94a3b8;
            font-style: italic;
            padding: 5px;
            text-align: center;
            border: 1px solid #e2e8f0;
            border-radius: 2px;
            line-height: 1.1;
        }

        /* ── Instructions ── */
        .inst-container {
            margin-top: 5px;
            border: 1px solid #cbd5e1;
            background: #f8fafc;
            border-radius: 2.5px;
            padding: 7px 10px;
        }
        .inst-title {
            font-size: 13px;
            font-weight: bold;
            color: #1e3a8a;
            text-align: center;
            border-bottom: 0.5px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 1px;
            letter-spacing: 0.2px;
        }
        .inst-grid {
            width: 100%;
            border-collapse: collapse;
        }
        .inst-items {
            margin: 0;
            padding-left: 11px;
            font-size: 12px;
            line-height: 1.2;
            color: #1e293b;
        }
        .inst-items li { margin-bottom: 0.5px; }

        /* ── Signatures ── */
        .footer-wrap {
            margin-top: 5px;
            padding-top: 0;
        }
        .footer-tbl {
            width: 100%;
            border-collapse: collapse;
        }
        /* NO text-transform:uppercase — Bengali inside sig-box would render as squares */
        .sig-box {
            width: 100%;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            color: #1e293b;
            padding-top: 1.5px;
            border-top: 1px dashed #334155;
            line-height: 1.1;
        }

        /* Scissor cut line */
        .cut-line {
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #64748b;
            margin: 1.5mm 0;
            line-height: 1;
        }
    </style>
</head>
<body>
@php
/**
 * $wrapBn — Reliable mixed-script font routing for mPDF.
 *
 * Splits a UTF-8 string into Bengali (U+0980–U+09FF) and Latin runs.
 * Bengali runs → <span lang="bn" class="bn"> → SolaimanLipi
 * Latin runs   → plain HTML-escaped text       → DejaVuSans / DejaVuSans-Bold
 *
 * Why this matters: CSS `text-transform:uppercase` combined with `font-weight:bold`
 * causes mPDF to resolve the font BEFORE script detection, routing all glyphs—
 * including Latin ones—through SolaimanLipi which has zero Latin cmap entries.
 * Result: □□□□ (empty boxes). Explicit wrapping bypasses this bug.
 *
 * @param  string $text   Raw UTF-8 (Bengali, Latin, or mixed)
 * @param  bool   $upper  If true, ASCII portions are upper-cased in PHP
 *                        (safer than CSS text-transform:uppercase for mixed scripts)
 * @return string         Safe HTML fragment with Bengali in lang="bn" spans
 */
$wrapBn = function (string $text, bool $upper = false): string {
    if ($text === '') return '';
    // Split on contiguous Bengali Unicode character runs
    $parts = preg_split(
        '/( [\x{0980}-\x{09FF}]+ )/ux',
        $text, -1,
        PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
    );
    $out = '';
    foreach ($parts as $part) {
        $isBn = (bool) preg_match('/[\x{0980}-\x{09FF}]/u', $part);
        // htmlspecialchars keeps ampersands, quotes, angle-brackets safe
        $safe = htmlspecialchars($part, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        if ($isBn) {
            $out .= '<span lang="bn" class="bn">' . $safe . '</span>';
        } else {
            $out .= $upper ? mb_strtoupper($safe, 'UTF-8') : $safe;
        }
    }
    return $out;
};
@endphp
    @foreach($students->chunk(2) as $chunkIndex => $pair)
        @foreach($pair as $pairIndex => $student)
            @php
                $studentSubCategoryId = $student->school_sub_category_id;
                $studentReligion = mb_strtolower(trim($student->religion ?? ''));
                
                // Filter routines for this specific student:
                // 1. Group / SubCategory filter
                // 2. Religion subject filter
                $studentRoutines = $examRoutines->filter(function($rtn) use ($studentSubCategoryId, $assignClasses, $studentReligion) {
                    $ac = isset($assignClasses) ? $assignClasses->get($rtn->subject_id) : null;
                    $subCatId = $ac ? $ac->school_sub_category_id : $rtn->subject?->school_sub_category_id;

                    // 1. Group / Subcategory check
                    if ($studentSubCategoryId) {
                        if (!empty($subCatId) && $subCatId != $studentSubCategoryId) {
                            return false;
                        }
                    } else {
                        if (!empty($subCatId)) {
                            return false;
                        }
                    }

                    // 2. Religion subject check
                    $subName = mb_strtolower(trim($rtn->subject?->name ?? ''));
                    $isIslam = str_contains($subName, 'islam') || str_contains($subName, 'ইসলাম') || str_contains($subName, 'deeniyat') || str_contains($subName, 'দ্বীনিয়াত') || str_contains($subName, 'কোরআন') || str_contains($subName, 'কুরআন');
                    $isHindu = str_contains($subName, 'hindu') || str_contains($subName, 'হিন্দু') || str_contains($subName, 'সনাতন');
                    $isBuddha = str_contains($subName, 'buddh') || str_contains($subName, 'বৌদ্ধ') || str_contains($subName, 'বুদ্ধ');
                    $isChristian = str_contains($subName, 'christ') || str_contains($subName, 'খ্রিস্ট') || str_contains($subName, 'খ্রিষ্ট');

                    if ($isIslam || $isHindu || $isBuddha || $isChristian) {
                        if ($isIslam) {
                            $matchesIslam = str_contains($studentReligion, 'islam') || str_contains($studentReligion, 'ইসলাম') || str_contains($studentReligion, 'muslim') || str_contains($studentReligion, 'মুসলিম') || empty($studentReligion);
                            if (!$matchesIslam) {
                                return false;
                            }
                        }
                        if ($isHindu) {
                            $matchesHindu = str_contains($studentReligion, 'hindu') || str_contains($studentReligion, 'হিন্দু') || str_contains($studentReligion, 'সনাতন');
                            if (!$matchesHindu) {
                                return false;
                            }
                        }
                        if ($isBuddha) {
                            $matchesBuddha = str_contains($studentReligion, 'buddh') || str_contains($studentReligion, 'বৌদ্ধ') || str_contains($studentReligion, 'বুদ্ধ');
                            if (!$matchesBuddha) {
                                return false;
                            }
                        }
                        if ($isChristian) {
                            $matchesChristian = str_contains($studentReligion, 'christ') || str_contains($studentReligion, 'খ্রিস্ট') || str_contains($studentReligion, 'খ্রিষ্ট');
                            if (!$matchesChristian) {
                                return false;
                            }
                        }
                    }

                    return true;
                });

                if ($studentRoutines->isEmpty()) {
                    $studentRoutines = $examRoutines;
                }

                $totalRoutines = $studentRoutines->count();
                $half = ceil($totalRoutines / 2);
                $colA = $studentRoutines->slice(0, $half);
                $colB = $studentRoutines->slice($half);

                // Instructions distribution
                $instLines = $instructionLines ?? [];
                $instCount = count($instLines);
                $instHalf = ceil($instCount / 2);
                $instColA = array_slice($instLines, 0, $instHalf);
                $instColB = array_slice($instLines, $instHalf);
            @endphp

            {{-- ── ADMIT CARD BOX CONTAINER ── --}}
            <div class="card-table-wrap">
                <div class="card-content">
                    {{-- 1. Header: Logo | School Info Center | QR --}}
                    <table class="header-tbl" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tr>
                                    {{-- Left: School Logo --}}
                                    <td class="hdr-logo" style="width: 75px; max-width: 80px; vertical-align: middle; text-align: left;">
                                        @if($school && $school->logo && file_exists(public_path($school->logo)))
                                            <img src="{{ public_path($school->logo) }}" width="70" height="70" style="width: 70px; height: 70px; max-width: 70px; max-height: 70px; display: block;">
                                        @else
                                            <table cellpadding="0" cellspacing="0" style="width:70px; height:70px; border:1px solid #cbd5e1; background:#f8fafc;">
                                                <tr>
                                                    <td style="text-align:center; vertical-align:middle; font-size:8px; color:#94a3b8; font-weight:bold;">LOGO</td>
                                                </tr>
                                            </table>
                                        @endif
                                    </td>

                                    {{-- Center: School Name, School Code, Exam, Badge --}}
                                    {{-- $wrapBn: Bengali → lang="bn" (SolaimanLipi) | Latin → base font (DejaVuSans-Bold) --}}
                                    <td class="hdr-center" style="vertical-align: middle; text-align: center; padding: 0 5px;">
                                        <div class="school-name">{!! $wrapBn($school?->name ?? 'SCHOOL NAME', true) !!}</div>

                                        @php
                                            $schoolCode = $school?->ein_number ?? $school?->emis_code ?? null;
                                            $codeLine = trim(
                                                ($school?->address ? $school->address . '  |  ' : '') .
                                                ($schoolCode ? 'E.I.N: ' . $schoolCode : '')
                                            );
                                        @endphp
                                        @if($codeLine)
                                            <div class="school-code-line">{!! $wrapBn($codeLine) !!}</div>
                                        @endif

                                        <div class="exam-name-line">{!! $wrapBn($exam?->name ?? 'EXAM') !!} &mdash; {{ date('Y') }}</div>
                                        <div class="admit-badge-div"><span class="admit-badge">ADMIT CARD (<span lang="bn" class="bn">প্রবেশপত্র</span>)</span></div>
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
                                    <td class="val-name">: {!! $wrapBn(mb_strtoupper($student->name, 'UTF-8')) !!}</td>
                                    <td class="lbl">Class</td>
                                    <td class="val">: {{ $student->class->name ?? 'N/A' }}</td>
                                    <td class="lbl">Roll</td>
                                    <td class="val">: {{ $student->roll ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="lbl">ID</td>
                                    <td class="val-name">: {{ $student->student_id ?? 'N/A' }}</td>
                                    <td class="lbl">Section</td>
                                    <td class="val">: {{ $student->section->name ?? 'N/A' }}</td>
                                    <td class="lbl">Group</td>
                                    <td class="val">: {{ $student->group->name ?? 'Null' }}</td>
                                </tr>
                            </table>

                            {{-- 3. Exam Routine (2 Columns with Time) --}}
                            {{--
                                Bengali exam name via $wrapBn → SolaimanLipi
                                " ROUTINE" kept as plain Latin → DejaVuSans-Bold
                                $upper=true: ASCII portions of exam name get uppercased in PHP
                                (CSS text-transform:uppercase is removed from .routine-heading
                                because mPDF applies it before font-routing → squares on Bengali)
                            --}}
                            <div class="routine-heading">{!! $wrapBn($exam->name, true) !!} <span style="font-family:dejavusans,sans-serif;font-weight:bold;">ROUTINE</span></div>
                            @if($totalRoutines > 0)
                                <table class="routine-grid-tbl" cellpadding="0" cellspacing="0">
                                    <tr>
                                        {{-- Column A --}}
                                        <td style="width: 49%; vertical-align: top;">
                                            <table class="sub-tbl" cellpadding="0" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 22%;">Date</th>
                                                        <th style="width: 60%;">Subject</th>
                                                        <th style="width: 27%;">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($colA as $rtn)
                                                        <tr>
                                                            <td style="font-weight: 400; text-align: center; white-space: nowrap; font-size: 10px;">
                                                                {{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td style="font-weight: 500; font-size: 10px;">
                                                                {{ $rtn->subject->name ?? 'N/A' }}
                                                            </td>
                                                            <td style="text-align: center; white-space: nowrap; font-size: 10px; font-weight: 400;">
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
                                                        <th style="width: 22%;">Date</th>
                                                        <th style="width: 60%;">Subject</th>
                                                        <th style="width: 27%;">Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($colB as $rtn)
                                                        <tr>
                                                            <td style="font-weight: 400; text-align: center; white-space: nowrap; font-size: 10px;">
                                                                {{ \Carbon\Carbon::parse($rtn->exam_date)->format('d-m-Y') }}
                                                            </td>
                                                            <td style="font-weight: 500; font-size: 10px;">
                                                                {{ $rtn->subject->name ?? 'N/A' }}
                                                            </td>
                                                            <td style="text-align: center; white-space: nowrap; font-size: 10px; font-weight: 400;">
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

                            {{-- 4. Instructions Section --}}
                            @if($instCount > 0)
                                <div class="inst-container">
                                    <div class="inst-title"><span lang="bn" class="bn">শিক্ষার্থীদের নির্দেশনাবলী</span> (INSTRUCTIONS)</div>
                                    <table class="inst-grid" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width: 50%; vertical-align: top; padding-right: 4px;">
                                                <ul class="inst-items" lang="bn">
                                                    @foreach($instColA as $item)
                                                        <li><span lang="bn" class="bn">{{ $item }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td style="width: 50%; vertical-align: top; padding-left: 4px;">
                                                <ul class="inst-items" lang="bn">
                                                    @foreach($instColB as $item)
                                                        <li><span lang="bn" class="bn">{{ $item }}</span></li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            @endif

                            {{-- 5. Signature Footer --}}
                            <div class="footer-wrap">
                                <table class="footer-tbl" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width: 38%; text-align: center; vertical-align: bottom;">
                                            <div style="height: 22px;"></div>
                                            <div class="sig-box"><span>Signature Of Class Teacher</span></div>    
                                        </td>
                                        <td style="width: 24%;"></td>
                                        <td style="width: 38%; text-align: center; vertical-align: bottom;">
                                            <div style="height: 22px; text-align: center;">
                                                @if(!empty($school->signature) && file_exists(public_path($school->signature)))
                                                    <img src="{{ public_path($school->signature) }}" style="max-height: 22px; max-width: 90px; display: inline-block;">
                                                @endif
                                            </div>
                                            <div class="sig-box"><span>Signature Of Head Teacher</span></div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

            {{-- Scissor cut line between the 2 cards on the page --}}
            @if(!$loop->last)
                <div class="cut-line">
                    &#9986; -----------------------------------------------------------------------------------------------------------------------------------------------
                </div>
            @endif
        @endforeach

        {{-- Page break after every 2 students --}}
        @if(!$loop->last)
            <pagebreak />
        @endif
    @endforeach
</body>
</html>