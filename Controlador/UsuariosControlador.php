<?php
session_start();
require_once "./Modelo/Conexion.php";


class UsuariosControlador
{
    function Index()
    {
        require_once "./Vistas/LogIn.php";
    }


    function LogIn()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $json = json_decode(file_get_contents('php://input'));
            $correo = $json->correo;
            $_SESSION["idUsuario"] = $correo;
            $_SESSION["usuario"] = $correo;
            echo json_encode(true);
        }
        else
        {
            header("Location: index.php?c=index");
            die();
        }
    }

    function CerrarSesion()
    {
        unset($_SESSION["idUsuario"]);
        unset($_SESSION["usuario"]);
        header("Location: index.php?c=index");
        die();
    }
    /*
    Registrar
    Actualizar
    Buscar
    BuscarTodos
    Activar


    */
}







?>