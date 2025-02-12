<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove PDF Watermark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .spinner-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Upload Your PDF to Remove Watermark</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="uploadForm" action="{{ route('lightpdf.process') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Select File</label>
            <input class="form-control" type="file" name="file" id="pdfFile" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload & Process</button>
    </form>

    <div id="pdf-preview" class="mt-4 d-none">
        <h4>PDF Preview:</h4>
        <iframe id="pdf-frame" src="" width="100%" height="1000px" style="border: 1px solid #ccc;"></iframe>
    </div>

</div>
    <!-- Spinner Overlay -->
    <div class="spinner-overlay" id="spinner">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Processing...</span>
        </div>
        <p class="text-light mt-3">Processing your file, please wait...</p>
    </div>
<script>
    document.getElementById('uploadForm').addEventListener('submit', function() {
        document.getElementById('spinner').style.display = 'flex';
    });

    document.getElementById('pdfFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type === 'application/pdf') {
            const fileURL = URL.createObjectURL(file);
            document.getElementById('pdf-frame').src = fileURL;
            document.getElementById('pdf-preview').classList.remove('d-none');
        } else {
            document.getElementById('pdf-preview').classList.add('d-none');
        }
    });

</script>
</body>
</html>
