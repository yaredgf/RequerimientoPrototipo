<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Hola, soy un dashboard todo épico</h1>
    <div class="contenedor-vistas">
        <?php if (isset($vista)) require_once "./Vistas/".$vista.".php"; ?>
    </div>
    
<div class="btn" id="btnLogOut">Cerrar sesión</div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
    $('#btnLogOut').click(async function(){
        respuesta = await fetch("./index.php?c=Usuarios&a=CerrarSesion", {
        method: "POST"
        });
        window.location.replace("?c=Index");
    });

    
</script>
</html>