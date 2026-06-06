<?php
session_start();
require_once "./Modelo/Conexion.php";


class IndexControlador
{

    function Index()
    {
        if (isset($_SESSION["idUsuario"])) // Muestra el dashboard
        {
            //header("Location: index.php?c=Usuarios&a=Cuenta");
            //die();
            require_once "./Vistas/Dashboard.php";

        }
        else // Muestra el login
        {
            require_once "./Vistas/LogIn.php";
        }
    }
}







?>