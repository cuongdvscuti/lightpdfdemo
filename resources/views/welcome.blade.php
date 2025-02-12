<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove Watermark</title>
</head>
<body>
<h1>Upload PDF to Remove Watermark</h1>
<form action="/remove-watermark" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" accept="application/pdf" required>
    <button type="submit">Remove Watermark</button>
</form>

@if(session('success'))
    <p>{{ session('message') }}</p>
    <a href="{{ session('file_url') }}" target="_blank">Download File</a>
@elseif(session('error'))
    <p>{{ session('message') }}</p>
@endif
</body>
</html>
