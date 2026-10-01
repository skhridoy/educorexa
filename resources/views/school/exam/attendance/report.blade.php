<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $exam->name }} - Attendance Report</title>
    <style>
        @page { size: A4 portrait; margin: 12mm; }
        body { color: #111; font-family: Arial, sans-serif; font-size: 11px; margin: 0; }
        .school-header { border-bottom: 2px solid #172554; margin-bottom: 10px; padding-bottom: 8px; text-align: center; }
        .school-header table { border-collapse: collapse; width: 100%; }
        .school-header td { vertical-align: middle; }
        .school-logo { width: 62px; text-align: left; }
        .school-logo img { height: 54px; max-width: 54px; width: 54px; }
        .school-name { color: #172554; font-size: 18px; font-weight: bold; }
        .school-info { color: #374151; font-size: 9px; line-height: 1.4; margin-top: 3px; }
        h1 { color: #172554; font-size: 20px; margin: 0; text-align: center; }
        h2 { color: #374151; font-size: 13px; font-weight: normal; margin: 5px 0 14px; text-align: center; }
        .meta { margin-bottom: 12px; text-align: center; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #6b7280; padding: 7px 8px; }
        th { background: #e8eef8; color: #172554; text-align: center; }
        .sl, .roll, .status { text-align: center; }
        .sl { width: 8%; }
        .student-id { width: 20%; }
        .roll { width: 12%; }
        .status { width: 18%; }
        .present { color: #166534; font-weight: bold; }
        .absent { color: #b91c1c; font-weight: bold; }
        .pagination { display: flex; gap: 5px; justify-content: center; list-style: none; margin: 14px 0 0; padding: 0; }
        .pagination a, .pagination span { border: 1px solid #cbd5e1; color: #172554; display: block; padding: 5px 9px; text-decoration: none; }
        .pagination .active span { background: #172554; color: #fff; }
        .signature-row td { border: 0; padding-top: 42px; text-align: center; }
        .signature-line { border-top: 1px solid #111; display: block; margin: 0 20px 4px; }
        @media print { .no-print { display: none; } }
        @if(!empty($isPdf)) .no-print { display: none !important; } @endif
    </style>
</head>
<body>
    <div class="school-header">
        <table>
            <tr>
                <td class="school-logo">
                    @if($schoolInfo->logo && file_exists(public_path($schoolInfo->logo)))
                        <img src="{{ asset($schoolInfo->logo) }}" alt="School Logo">
                    @endif
                </td>
                <td>
                    <div class="school-name">{{ $schoolInfo->name }}</div>
                    <div class="school-info">
                        {{ $schoolInfo->address }}
                        @if($schoolInfo->phone) | Phone: {{ $schoolInfo->phone }}@endif
                        @if($schoolInfo->email) | Email: {{ $schoolInfo->email }}@endif
                        @if($schoolInfo->ein_number) | E.I.N: {{ $schoolInfo->ein_number }}@endif
                    </div>
                </td>
                <td class="school-logo"></td>
            </tr>
        </table>
    </div>
    <h1>{{ $exam->name }}</h1>
    <h2>Exam Attendance Report | Date: {{ $date->format('d M Y') }}</h2>

    <table>
        <thead>
            <tr>
                <th class="sl">SL</th>
                <th class="student-id">Student ID</th>
                <th class="roll">Roll</th>
                <th>Student Name</th>
                <th class="status">Status</th>
            </tr>
        </thead>
        <tbody>
        @forelse($students as $index => $student)
            @php $isPresent = ($records[$student->id]->status ?? null) === 'present'; @endphp
            <tr>
                <td class="sl">{{ $students->firstItem() + $index }}</td>
                <td>{{ $student->student_id }}</td>
                <td class="roll">{{ $student->roll }}</td>
                <td>{{ $student->name }}</td>
                <td class="status {{ $isPresent ? 'present' : 'absent' }}">{{ $isPresent ? 'Present' : 'Absent' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" style="text-align:center">No active students found.</td></tr>
        @endforelse
        </tbody>
    </table>
    @if($students->hasPages())
        <div class="no-print">{{ $students->links() }}</div>
    @endif

    <table class="signature-row">
        <tr>
            <td><span class="signature-line"></span>Class Teacher</td>
            <td><span class="signature-line"></span>Examiner</td>
            <td><span class="signature-line"></span>Head Teacher</td>
        </tr>
    </table>
    <script>window.onload = function () { window.print(); };</script>
</body>
</html>
