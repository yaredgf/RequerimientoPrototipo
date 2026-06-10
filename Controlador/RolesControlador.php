<?php
session_start();
require_once "./Modelo/Conexion.php";


class RolesControlador
{
    function Index()
    {
        require_once "./Vistas/LogIn.php";
    }

}







?>