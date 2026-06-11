<?php
session_start();
require_once "./Modelo/Entidades/TipoUsuario.php";
require_once "./Modelo/Metodos/TipoUsuarioM.php";


class RolesControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            header("Location: index.php?c=index");
            die();
        }
        if (isset($_SESSION["idUsuario"]))
        {
            $cM = new UsuarioM();
            $todos = $cM->CategoriaProductoM();
            $vista = "Roles";
            require_once "./Vistas/Dashboard.php";
        }
    }

    function Crear() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $c = new CategoriaProducto();
            $cM = new CategoriaProductoM();
            $actualizar=false;

            $json = json_decode(file_get_contents('php://input'));

            if($json->id != ""){
                $c = $cM->Buscar($json->id);
                $actualizar=true;
            }else{
                $c->setEstado(1);
            }
            
            $c->setNombre($json->email);
            $retVal = $cM->Crear($c);

            echo json_encode($retVal);
        }
        else
        {
            
        }
    }

    function Nuevo()
    {
        if (true)
        {
            $c = null;
            $json = json_decode(file_get_contents('php://input'));
            if($json->id != ""){
                $c = $cM->Buscar($json->id);
            }
            $vista = "CategoriaCrear";
            require_once "./Vistas/Dashboard.php";
        }
    }

    function Activar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $retVal = false;
            $json = json_decode(file_get_contents('php://input'));
            $c = new CategoriaProducto();
            $cM = new CategoriaProductoM();
            $c->setId($json->id);
            $c->setEstado($json->estado);
            $retVal = $cM->Activar();
            echo json_encode($retVal);
        }
    }

}







?>