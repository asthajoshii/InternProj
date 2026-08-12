<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
</head>

<body>

    <h1>Student Records</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Class</th>
            <th>Division</th>
            <th>City</th>
            <th>Parent Name</th>
            <th>Parent Contact</th>
        </tr>

        @foreach($students as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->fname }}</td>
            <td>{{ $student->mname }}</td>
            <td>{{ $student->lname }}</td>
            <td>{{ $student->class }}</td>
            <td>{{ $student->div }}</td>
            <td>{{ $student->city }}</td>
            <td>{{ $student->pname }}</td>
            <td>{{ $student->pcontact }}</td>
        </tr>
        @endforeach

    </table>
    <h1>Student Records</h1>
    <p><strong>Total Students:</strong> {{ $count }}</p>

</body>
</html>