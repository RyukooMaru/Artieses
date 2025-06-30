<!-- resources/views/upload_file.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
    <h1>Unggah File untuk Dibaca</h1>
    <form action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button type="submit">Unggah File</button>
    </form>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif
</body>
</html>
