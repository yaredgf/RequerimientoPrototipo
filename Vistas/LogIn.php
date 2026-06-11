<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Document</title>
</head>
<body style="height=100vh !important; ">
    <div class="row justify-content-center py-5 h-100" style="height=100vh !important;">
        <div class="col-6">
            <div class="card overflow-hidden">
                <div class="row">
                    <!--LogIn-->
                    <div class="col-8 p-5">
                        <h1>Nombre empresa</h1>
                        <h1>Hoy me la doy en la pila</h1>
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon3">Correo</span>
                            <input type="text" class="form-control" id="inputCorreo">
                        </div>
                        <div class="input-group mt-3">
                            <span class="input-group-text" id="basic-addon3">Contraseña</span>
                            <input type="text" class="form-control" id="inputPass">
                        </div>
                        <div class="row justify-content-evenly d-flex mt-3">
                            <button class="btn btn-outline-primary w-25" type="button" id="btnLogIn">Iniciar Sesión</button>
                        </div>
                    </div>
                    <div class="col-4 " style='background-image:url("https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbmRoduBFNeQYgHYTDS3i215E1kbjac6rYvw&s")'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script>
    $('#btnLogIn').click(async function(){
        respuesta = await fetch("./index.php?c=Usuarios&a=LogIn", {
        method: "POST",
        body: JSON.stringify({ correo: document.getElementById("inputCorreo").value,
                                pass: document.getElementById("inputPass").value
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