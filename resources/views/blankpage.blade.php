<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artieses</title>
    <link rel="stylesheet" href="{{ asset('css/appes/appes.css') }}">
    @include('partses.baries')
    <style>
        .nullpage {
            font-size: 1.5rem;
            color: #444;
            margin-top: 20%;
            text-align: center;
        }
        .dark-mode .nullpage {
            color: #fff;
        }
    </style>
</head>
<body>
    <p class="nullpage">Alamat yang anda tuju tidak ada.</p>
</body>
<script src="{{ asset('js/appes/togglemode.js') }}"></script>  
</html>