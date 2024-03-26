<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Compra</title>
</head>
<body>
    <h2>Confirmación de Compra</h2>
    <p>Estas son las entradas que has comprado:</p>
    <ul>
        @foreach ($data['entradas'] as $entrada)
            <li>Asiento: {{ $entrada['asiento'] }} - Precio: {{ $entrada['precio'] }}€</li>
        @endforeach
    </ul>
    <p>Total: {{ $data['precioTotal'] }}€</p>
    <p>Método de Pago: {{ $data['metodoPago'] }}</p>
</body>
</html>
