<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Templates</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}?v={{ @Helper::system_version() }}"
          type="text/css"/>
</head>
<body>
<h1>Email Templates</h1>
<table border="1" cellspacing="0" cellpadding="10">
    <thead>
    <tr>
        <th>ID</th>
        <th>Template Name</th>
        <th>Subject</th>
        <th>Template Type</th>
        <th>Status</th>
        <th>Created At</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->tplname }}</td>
            <td>{{ $item->subject }}</td>
            <td>{{ $item->template_type->type ?? '' }}</td>
            <td>{{ $item->status }}</td>
            <td>{{ $item->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
