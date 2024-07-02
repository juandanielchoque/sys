<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 0px 15px;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        h2 {
            font-size: 25px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            font-size: 18px;
            margin-bottom: 10px;
        }

        input {
            padding: 14px;
            border: none;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #E6EFFF;
            outline: none;
            font-size: 16px;
            font-weight: bold;
            color: rgb(5, 13, 39);
        }

        button {
            background-color: #2A7ED6;
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        button:hover {
            background-color: #2372C4;
        }

        p {
            text-align: right;
            padding-bottom: 20px;
            margin-top: 20px;
        }

        p a {
            color: #2372C4;
            font-weight: bold;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .error {
            display: block;
            color: rgb(47, 6, 6);
            background: rgb(255, 214, 214);
            padding: 10px;
        }

        .success {
            display: block;
            color: rgb(7, 47, 6);
            background: rgb(214, 255, 229);
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="{{ route('recuperar.update') }}" method="post">
            @csrf
            <h2>Recuperar contraseña</h2>
            <label for="correo">Correo electrónico:</label>
            <input type="text" id="correo" name="correo" required>

            <div class="mensaje">
                @error('correo')
                    <small class="error">{{ $message }}</small>
                @enderror

                @if (session('CORRECTO'))
                    <small class="success">{{ session('CORRECTO') }}</small>
                @endif

                @if (session('INCORRECTO'))
                    <small class="error">{{ session('INCORRECTO') }}</small>
                @endif
            </div>

            <p>Tambien puedes <a href="{{ route('home') }}">Iniciar Sesion</a></p>
            <button type="submit">Recuperar Contraseña</button>
        </form>
    </div>
</body>

</html>
