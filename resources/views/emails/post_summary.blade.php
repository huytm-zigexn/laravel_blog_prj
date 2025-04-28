<!DOCTYPE html>
<html>
<head>
    <title>Post Summary</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Here is your monthly post performance summary:</p>

    <table border="1" cellspacing="0" cellpadding="10">
        <thead>
            <tr>
                <th>Post Title</th>
                <th>Likes</th>
                <th>Views</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($postPerformance as $performance)
            <tr>
                <td>{{ $performance['title'] }}</td>
                <td>{{ $performance['likes'] }}</td>
                <td>{{ $performance['views'] }}</td>
                <td>{{ $performance['comments'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Keep up the great work!</p>
</body>
</html>
