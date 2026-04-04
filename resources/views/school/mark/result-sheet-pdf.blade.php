<!DOCTYPE html>
<html>
<head>
    <title>Result Sheet</title>
    <style>
        body { font-family: 'sans-serif'; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; }
        .fail { color: red; font-weight: bold; }
        .text-left { text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ auth()->user()->school->name }}</h2>
        <h3>Exam: {{ $exam->name }} | Class: {{ $class->name }}</h3>
        <p>Full Result Summary (Academic Year: {{ date('Y') }})</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Merit</th>
                <th>Roll</th>
                <th>Student Name</th>
                <th>Total Marks</th>
                <th>GPA / Result</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $index => $res)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $res['roll'] }}</td>
                <td class="text-left">{{ strtoupper($res['name']) }}</td>
                <td>{{ $res['total_marks'] }}</td>
                <td class="{{ $res['fail_count'] > 0 ? 'fail' : '' }}">
                    {{ $res['gpa'] }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>