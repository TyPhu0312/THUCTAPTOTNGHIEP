<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scores Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Bảng điểm</h1>
    <h2>Môn Học: {{ $course_name }}</h2>
    <table>
        <thead>
            <tr>
                <th>MSSV</th>
                <th>Tên sinh viên</th>
                <th>Điểm quá trình</th>
                <th>Điểm giữa kỳ</th>
                <th>Điểm cuối kỳ</th>
                <th>Điểm tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $score)
                <tr>
                    <td>{{ $score->student->student_code }}</td>
                    <td>{{ $score->student->full_name }}</td>
                    <td>{{ $score->process_score }}</td>
                    <td>{{ $score->midterm_score }}</td>
                    <td>{{ $score->final_score }}</td>
                    <td>{{ number_format($score->average_score, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
