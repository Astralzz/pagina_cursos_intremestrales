<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('/imgs/iconApp.png') }}">
    <link rel="shortcut icon" sizes="192x192" href="{{ asset('/imgs/iconApp.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <title>CURSOS ITERNACIONALES</title>
</head>

<body>

    {{-- ? Existe una sesion --}}
    @if (auth()->check())
        @include('pages.home')
    @else
        @include('pages.login')
    @endif

    {{-- Scrips --}}
    <script src="{{ asset('js/global.js') }}"></script>

</body>

</html>
