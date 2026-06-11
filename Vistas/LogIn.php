<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, sans-serif;
            background: #0d0d0d;
            color: #e8e8e8;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            background: #161616;
            border: 1px solid #2a2a2a;
            border-radius: 6px;
            width: 360px;
            padding: 32px;
        }
        h1 {
            font-size: 18px;
            color: #6c5ce7;
            margin-bottom: 24px;
            text-align: center;
        }
        label {
            display: block;
            font-size: 12px;
            color: #888;
            margin-bottom: 6px;
        }
        input {
            width: 100%;
            height: 38px;
            background: #1f1f1f;
            border: 1px solid #2a2a2a;
            border-radius: 6px;
            padding: 0 12px;
            color: #e8e8e8;
            font-size: 14px;
            outline: none;
            margin-bottom: 16px;
        }
        input:focus { border-color: #6c5ce7; }
        button {
            width: 100%;
            height: 40px;
            background: #6c5ce7;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            margin-top: 8px;
        }
        button:hover { background: #5a4bd1; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Grupo Digitec Costa Rica</h1>
        
        <label>Correo</label>
        <input type="text" id="inputCorreo">
        
        <label>Contraseña</label>
        <input type="password" id="inputPass">
        
        <button id="btnLogIn">Iniciar Sesión</button>
    </div>

    <script>
        document.getElementById('btnLogIn').addEventListener('click', async function(){
            const respuesta = await fetch("./index.php?c=Usuarios&a=LogIn", {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    correo: document.getElementById("inputCorreo").value,
                    pass: document.getElementById("inputPass").value
                })
            });
            const resultado = await respuesta.json();
            if (resultado)
                window.location.href = "index.php?c=dashboard&vista=Usuarios";
            else
                alert("Credenciales incorrectas");
        });
    </script>
</body>
</html>