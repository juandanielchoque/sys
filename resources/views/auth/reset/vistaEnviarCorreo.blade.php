<!DOCTYPE html>
<html>

<head>
    <title>Restablecer contraseña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
        }
        
        h1 {
            margin-top: 50px;
            margin-bottom: 20px;
        }
        
        p {
            margin-bottom: 40px;
        }
        
        a.button {
            background-color: #007bff;
            color: #fff;
            display: inline-block;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        a.button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Restablecer contraseña</h1>
    <p>Haga clic en el botón para restablecer su contraseña:</p>
    <a class="button" href="{{ route('nuevo.clave', [$correo, $codigo]) }}">Restablecer contraseña</a>
</body>

</html>
