<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <style>
    body{
        background-color:#face82;
    }
    </style>
    <h1>Holaaaaaaaaaa</h1>
    <?php echo getdate()["year"]; ?>

    <div class="btn" id="btnLogIn">Logearse</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $('#btnLogIn').click(async function(){
        respuesta = await fetch("./index.php?c=Usuarios&a=LogIn", {
        method: "POST",
        body: JSON.stringify({ correo: "yaredgf@gmail.com",
                                pass: "123"
                            })
        });
        resultado = await respuesta.json();
        if (resultado)
            location.reload();
        else
            console.log("No se logró")
    });

    
</script>
</html>