<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rebut de Compra</title>
</head>
<body>
    <h1>Rebut de Compra</h1>
    <h3>Aquestes son les entrades que has comprat:</h3>
    <h2>Pel·lícula: {{ $data['titolPelicula'] }}</h2>
    <ul>
        @foreach ($data['entradas'] as $entrada)
            <li>Asiento: {{ $entrada['asiento'] }} - Precio: {{ $entrada['precio'] }}€</li>
        @endforeach
    </ul>
    <p>Métode de Pagament: {{ $data['metodoPago'] }}</p>
    <h2>Total: {{ $data['precioTotal'] }}€</h2>
</body>
</html>
