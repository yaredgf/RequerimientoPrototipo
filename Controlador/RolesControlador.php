<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "./Modelo/Entidades/TipoUsuario.php";
require_once "./Modelo/Metodos/TipoUsuarioM.php";


class RolesControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            $tM = new TipoUsuarioM();
            $todos = $tM->BuscarTodos();
            $vistaActiva = "Roles";
            require_once "./Vistas/Dashboard.php";
        }
        else
        {
            header("Location: index.php?c=index");
            die();
        }
    }

    function Crear() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $t = new TipoUsuario();
            $tM = new TipoUsuarioM();
            $actualizar=false;

            $json = json_decode(file_get_contents('php://input'));

            if($json->id != ""){
                $t = $tM->Buscar($json->id);
                $actualizar=true;
            }
            
            $t->setNombre($json->nombre);
            $retVal = $tM->Crear($t);

            echo json_encode($retVal);
        }
        else
        {
            
        }
    }


}







?>