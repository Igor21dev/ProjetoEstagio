<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quarto de ID: {{$room->id}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <h1 class="text-center">Quarto de ID: {{$room->id}}</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>ID do Hotel</th>
                <th>Nome do Hotel</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$room->id}}</td>
                <td>{{$room->name}}</td>
                <td>{{$room->hotelCode}}</td>
                <td>{{$room->hotel->name}}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>