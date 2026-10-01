<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $schoolInfo->name }} - {{ $exam->name }}</title>
    <style>
        @font-face { font-family: 'SolaimanLipi'; src: url('{{ public_path('fonts/SolaimanLipi.ttf') }}') format('truetype'); font-weight: normal; }
        @page { size: A4 portrait; margin: 10mm; }
        body { margin: 0; color: #111; font-family: DejaVu Sans, Arial, sans-serif; font-size: 10px; }
        .bn { font-family: 'SolaimanLipi', sans-serif; }
        table { border-collapse: collapse; width: 100%; }
        @if(!$isPdf)
        .sheet { page-break-after: always; }
        .sheet:last-child { page-break-after: auto; }
        @endif
        .sheet { position: relative; }
        .watermark { left: 50%; opacity: 0.08; position: absolute; top: 50%; transform: translate(-50%, -50%); width: 125mm; z-index: 0; }
        .sheet > *:not(.watermark) { position: relative; z-index: 1; }
        .header { border-bottom: 1.5px solid #172554; padding-bottom: 5px; }
        .header td { vertical-align: middle; }
        .logo-cell { width: 62px; }
        .logo { width: 54px; height: 54px; }
        .school-name { color: #172554; font-size: 18px; font-weight: bold; text-align: center; text-transform: uppercase; }
        .school-info { color: #374151; font-size: 8px; line-height: 1.35; text-align: center; }
        .exam-name { color: #172554; font-size: 13px; font-weight: bold; margin-top: 4px; text-align: center; text-transform: uppercase; }
        .title { background: #e8eef8; border: 1px solid #9aa9bf; color: #172554; font-size: 13px; font-weight: bold; margin: 7px 0; padding: 5px; text-align: center; text-transform: uppercase; }
        .student-info { margin-bottom: 8px; }
        .student-info td { border: 1px solid #9ca3af; padding: 5px; text-transform: uppercase; }
        .label { background: #eef2f7; font-weight: bold; width: 15%; }
        .routine th { background: #e8eef8; color: #172554; font-weight: bold; text-align: center; }
        .routine th, .routine td { border: 1px solid #6b7280; padding: 5px; }
        .routine .sl { text-align: center; width: 7%; }
        .routine .date { width: 15%; }
        .routine .subject { width: 30%; text-transform: uppercase; text-align: left;}
        .routine .signature { width: 24%; }
        .sign-space { height: 10mm; vertical-align: bottom; }
        .approval { margin-top: 12mm; }
        .approval td { padding: 14px 10px 0; text-align: center; width: 33.33%; }
        .approval-line { border-top: 1px solid #111; display: block; margin-bottom: 3px; }
        .approval-text { font-size: 9px; font-weight: bold; }
    </style>
</head>
<body>
@php
    $wrapBn = function (?string $text): string {
        $text = (string) ($text ?? '');
        if ($text === '') return '';
        $parts = preg_split('/([\x{0980}-\x{09FF}]+)/u', $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $html = '';
        foreach ($parts as $part) {
            $safe = e($part);
            $html .= preg_match('/[\x{0980}-\x{09FF}]/u', $part)
                ? '<span lang="bn" class="bn">' . $safe . '</span>'
                : $safe;
        }
        return $html;
    };
    $examTitle = $wrapBn($exam->name);
    $schoolAddress = $wrapBn($schoolInfo->address ?? '');
@endphp
@foreach($students as $student)
    @php($studentRoutinesForSheet = $studentRoutines[$student->id] ?? $routines)
    <div class="sheet">
        @if($schoolInfo->logo && file_exists(public_path($schoolInfo->logo)))
            <img class="watermark" src="{{ public_path($schoolInfo->logo) }}" alt="">
        @endif
        <table class="header">
            <tr>
                <td class="logo-cell">
                    @if($schoolInfo->logo && file_exists(public_path($schoolInfo->logo)))
                        <img class="logo" src="{{ public_path($schoolInfo->logo) }}" alt="School Logo">
                    @endif
                </td>
                <td>
                        <div class="school-name">{!! $wrapBn($schoolInfo->name) !!}</div>
                    <div class="school-info">
                        {!! $schoolAddress !!}
                        @if($schoolInfo->phone) | Phone: {{ $schoolInfo->phone }}@endif
                        @if($schoolInfo->email) | Email: {{ $schoolInfo->email }}@endif
                        @if($schoolInfo->ein_number) | E.I.N: {{ $schoolInfo->ein_number }}@endif
                    </div>
                    <div class="exam-name">{!! $examTitle !!} - {{ $class->name }}</div>
                </td>
                <td class="logo-cell"></td>
            </tr>
        </table>

        <div class="title">EXAM ATTENDANCE SHEET</div>

        <table class="student-info">
            <tr>
                <td class="label">Student Name</td><td>{!! $wrapBn($student->name) !!}</td>
                <td class="label">Student ID</td><td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td class="label">Class</td><td>{{ $class->name }}</td>
                <td class="label">Roll</td><td>{{ $student->roll }}</td>
            </tr>
            <tr>
                <td class="label">Section</td><td>{{ $student->section?->name }}</td>
                <td class="label">Group</td><td>{!! $wrapBn($student->group?->name ?? 'General') !!}</td>
            </tr>
        </table>

        <table class="routine">
            <thead>
                <tr>
                    <th class="sl">SL</th>
                    <th class="date">DATE</th>
                    <th class="subject">CODE &amp; Subject</th>
                    <th class="signature">Student Signature</th>
                    <th class="signature">Examinee Signature</th>
                </tr>
            </thead>
            <tbody>
            @foreach($studentRoutinesForSheet as $index => $routine)
                <tr>
                    <td class="sl">{{ $index + 1 }}</td>
                    <td style="text-transform: uppercase; text-align: center;">{{ optional($routine->exam_date)->format('d M Y') }}</td>
                    <td style="text-transform: uppercase; text-align: left; font-size: 10px;"><strong>{{ $routine->subject?->code ?? '-' }}</strong> - {!! $wrapBn($routine->subject?->name ?? '-') !!}</td>
                    <td class="sign-space"></td>
                    <td class="sign-space"></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endforeach
</body>
</html>
