<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Processed - LightPDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pdf-preview {
            width: 100%;
            height: 600px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-lg p-4 text-center">
        <h2 class="mb-4">File Processed Successfully!</h2>
        <p><strong>File Name:</strong> {{ $fileName }}</p>

        <!-- PDF Preview Section -->
        <h5 class="mt-4">Preview:</h5>
        <iframe
            src="https://docs.google.com/gview?url={{ urlencode($downloadLink) }}&embedded=true"
            class="pdf-preview">
        </iframe>

        <!-- Download Button -->
        <a href="{{ $downloadLink }}" class="btn btn-success mt-3" download>Download Processed File</a>
    </div>
</div>
</body>
</html>
