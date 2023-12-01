@php
$variables = [
'nombre',
'informacion',
'tipo',
'nombre_instructor',
'sede',
'fecha_inicio',
'fecha_final'];

$subVariables = [
'categoria',
'creador'];
@endphp


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Curso {{$data['nombre'] ?? "N/A"}}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 20px;
        }

        header {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }

        section {
            margin-top: 20px;
        }

        h1 {
            color: #fff;
        }

        h2 {
            color: #3498db;
        }

        p {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: #fff;
        }

        .error {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <header>
        <h1>Datos del Curso</h1>
    </header>

    <section>
        <h2>Información Principal</h2>
        @foreach ($variables as $var)
        @php
        $title = ucwords(str_replace('_', ' ', $var));
        @endphp
        <p><strong>{{ $title }}:</strong> {{ $data[$var] }}</p>
        @endforeach

        <h2>Datos Secundarios</h2>
        @foreach ($subVariables as $var)
        @php
        $title = ucwords(str_replace('_', ' ', $var));
        @endphp
        <p><strong>{{ $title }}:</strong> {{ $data[$var] }}</p>
        @endforeach
    </section>

</body>

</html>
