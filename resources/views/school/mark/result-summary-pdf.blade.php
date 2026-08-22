<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Result Summary - {{ $exam->name }} ({{ $academic_year ?? date('Y') }})</title>
    <style>
        @page {
            margin: 20px 24px 25px 24px;
            size: A4 portrait;
        }
        * { box-sizing: border-box; }
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 8.5px;
            color: #111;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        /* ── WATERMARK ── */
        .watermark {
            position: fixed;
            top: 30%;
            left: 0;
            right: 0;
            width: 100%;
            text-align: center;
            opacity: 0.06;
            z-index: -1000;
        }
        .watermark img {
            width: 340px;
            height: auto;
            opacity: 0.06;
        }

        /* ── PAGE FOOTER ── */
        .page-footer {
            position: fixed;
            bottom: -12px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 7.5px;
            color: #64748b;
            border-top: 0.5px solid #cbd5e1;
            padding-top: 3px;
        }

        /* ── 1-COLUMN HEADER ── */
        .doc-header {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }
        .hdr-table { width: 100%; border-collapse: collapse; }
        .hdr-logo-td { width: 65px; vertical-align: middle; text-align: left; }
        .hdr-logo-td img { width: 55px; height: 55px; object-fit: contain; }
        .hdr-text-td { text-align: center; vertical-align: middle; padding: 0 6px; }
        .school-name {
            font-family: 'Helvetica Neue', 'Arial Black', Arial, sans-serif;
            font-size: 18px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 2px 0;
            color: #0f172a;
        }
        .school-sub {
            font-size: 8.5px;
            color: #475569;
            margin: 0 0 3px 0;
        }
        .exam-title-badge {
            display: inline-block;
            background: #0f172a;
            color: #fff;
            font-size: 9.5px;
            font-weight: bold;
            padding: 2.5px 12px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 2px;
        }
        .hdr-side-td { width: 65px; vertical-align: middle; text-align: right; font-size: 7.5px; color: #64748b; }

        /* ── CLASS BLOCK (CONTINUOUS) ── */
        .class-section {
            margin-bottom: 12px;
            page-break-inside: auto;
        }

        /* ── 1-COLUMN CLASS HEADING BANNER ── */
        .class-heading-banner {
            background: #f1f5f9;
            border: 1px solid #334155;
            border-radius: 4px;
            padding: 4px 8px;
            margin-bottom: 6px;
            page-break-after: avoid;
            page-break-inside: avoid;
        }
        .class-title-text {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            color: #0f172a;
            letter-spacing: 0.4px;
            display: inline-block;
        }
        .class-stats-text {
            float: right;
            font-size: 8px;
            font-weight: bold;
            color: #334155;
            padding-top: 2px;
        }

        /* ── 2-COLUMN TABLE CONTAINER ── */
        .two-col-container {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
            page-break-inside: auto;
        }
        .two-col-td {
            width: 50%;
            vertical-align: top;
            padding: 0;
        }
        .two-col-td.left-td {
            padding-right: 4px;
        }
        .two-col-td.right-td {
            padding-left: 4px;
        }

        /* ── STUDENT SUMMARY TABLE ── */
        .summary-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.8px;
        }
        .summary-tbl th,
        .summary-tbl td {
            border: 0.6px solid #475569;
            padding: 2px 2.5px;
            text-align: center;
            height: 13px;
        }
        .summary-tbl th {
            background: #e2e8f0;
            color: #0f172a;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 7.8px;
            letter-spacing: 0.2px;
        }
        .summary-tbl td.name-td {
            text-align: left;
            padding-left: 4px;
            font-weight: bold;
            color: #0f172a;
            max-width: 85px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .summary-tbl tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .merit-top {
            font-weight: 800;
            color: #1e3a8a;
        }
        .fail-text {
            color: #dc2626;
            font-weight: bold;
        }
        .pass-text {
            color: #059669;
            font-weight: bold;
        }
    </style>
</head>
<body>

{{-- Watermark --}}
@if(!empty($instituteLogo))
<div class="watermark">
    <img src="{{ $instituteLogo }}" alt="Watermark">
</div>
@endif

{{-- Page Footer --}}
<div class="page-footer">
    <span>Printed on {{ date('d M, Y h:i A') }} | {{ $school->name ?? 'EduCorexa' }} — Academic Result Summary</span>
</div>

{{-- ── 1-COLUMN DOCUMENT HEADER ── --}}
<div class="doc-header">
    <table class="hdr-table">
        <tr>
            <td class="hdr-logo-td">
                @if(!empty($instituteLogo))
                    <img src="{{ $instituteLogo }}" alt="Logo">
                @endif
            </td>
            <td class="hdr-text-td">
                <div class="school-name">{{ $school->name ?? 'School Name' }}</div>
                @if(!empty($school->address))
                    <div class="school-sub">{{ $school->address }} {{ !empty($school->emis_code) ? '· EMIS: ' . $school->emis_code : '' }}</div>
                @endif
                <div class="exam-title-badge">
                    {{ strtoupper($exam->name) }} — {{ $academic_year ?? date('Y') }} (RESULT SUMMARY)
                </div>
            </td>
            <td class="hdr-side-td">
                <strong>ACADEMIC YEAR</strong><br>
                {{ $academic_year ?? date('Y') }}<br>
                <span>Total Classes: {{ count($classesData) }}</span>
            </td>
        </tr>
    </table>
</div>

{{-- ── CLASSES SUMMARY (CONTINUOUS 2-COLUMN RESULT FLOW) ── --}}
@foreach($classesData as $cData)
@php
    $cls       = $cData['class'];
    $leftList  = $cData['left_col'];
    $rightList = $cData['right_col'];
@endphp
<div class="class-section">
    {{-- 1-Column Class Heading --}}
    <div class="class-heading-banner">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="text-align: left; vertical-align: middle;">
                    <span class="class-title-text">CLASS: {{ strtoupper($cls->name) }}</span>
                </td>
                <td style="text-align: right; vertical-align: middle;" class="class-stats-text">
                    Total: <strong>{{ $cData['total_count'] }}</strong> |
                    Passed: <strong style="color:#059669;">{{ $cData['pass_count'] }}</strong> |
                    Failed: <strong style="color:#dc2626;">{{ $cData['fail_count'] }}</strong> |
                    Pass Rate: <strong>{{ $cData['pass_rate'] }}%</strong> |
                    Highest Mark: <strong>{{ $cData['highest_mark'] }}</strong> |
                    Avg GPA: <strong>{{ $cData['avg_gpa'] }}</strong>
                </td>
            </tr>
        </table>
    </div>

    {{-- 2-Column Student Tables Side-by-Side --}}
    <table class="two-col-container">
        <tr>
            {{-- Left Column Table --}}
            <td class="two-col-td left-td">
                <table class="summary-tbl">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Roll</th>
                            <th style="width: 10%;">Merit</th>
                            <th style="width: 16%;">ID</th>
                            <th style="width: 40%; text-align: left; padding-left: 4px;">Student Name</th>
                            <th style="width: 12%;">Mark</th>
                            <th style="width: 12%;">GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leftList as $st)
                            <tr>
                                <td><strong>{{ $st['roll'] }}</strong></td>
                                <td class="{{ $st['merit'] <= 3 ? 'merit-top' : '' }}">
                                    {{ $st['merit'] }}
                                </td>
                                <td>{{ $st['display_id'] }}</td>
                                <td class="name-td">{{ strtoupper($st['name']) }}</td>
                                <td><strong>{{ $st['total_marks'] }}</strong></td>
                                <td class="{{ $st['fail_count'] > 0 ? 'fail-text' : 'pass-text' }}">
                                    {{ $st['gpa_text'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>

            {{-- Right Column Table --}}
            <td class="two-col-td right-td">
                <table class="summary-tbl">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Roll</th>
                            <th style="width: 10%;">Merit</th>
                            <th style="width: 16%;">ID</th>
                            <th style="width: 40%; text-align: left; padding-left: 4px;">Student Name</th>
                            <th style="width: 12%;">Mark</th>
                            <th style="width: 12%;">GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rightList as $st)
                            <tr>
                                <td><strong>{{ $st['roll'] }}</strong></td>
                                <td class="{{ $st['merit'] <= 3 ? 'merit-top' : '' }}">
                                    {{ $st['merit'] }}
                                </td>
                                <td>{{ $st['display_id'] }}</td>
                                <td class="name-td">{{ strtoupper($st['name']) }}</td>
                                <td><strong>{{ $st['total_marks'] }}</strong></td>
                                <td class="{{ $st['fail_count'] > 0 ? 'fail-text' : 'pass-text' }}">
                                    {{ $st['gpa_text'] }}
                                </td>
                            </tr>
                        @endforeach
                        {{-- If right column has fewer rows than left, add blank spacer rows for perfect balance --}}
                        @for($k = count($rightList); $k < count($leftList); $k++)
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td class="name-td">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
@endforeach

</body>
</html>
