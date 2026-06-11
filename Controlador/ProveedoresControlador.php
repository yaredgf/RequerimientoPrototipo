<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "./Modelo/Entidades/Proveedor.php";
require_once "./Modelo/Metodos/ProveedorM.php";

class ProveedoresControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            $pM = new ProveedorM();
            $todos = $pM->BuscarTodos();
            $vistaActiva = "Proveedores";
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
            $p = new Proveedor();
            $pM = new ProveedorM();
            $actualizar=false;

            $json = json_decode(file_get_contents('php://input'));

            if($json->id != ""){
                $p = $pM->Buscar($json->id);
                $actualizar=true;
            }else{
                $p->setEstado(1);
            }
            
            $p->setNombre($json->nombre);
            $retVal = $pM->Crear($p);

            echo json_encode($retVal);
        }
        else
        {
            
        }
    }

    function Activar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $retVal = false;
            $json = json_decode(file_get_contents('php://input'));
            $p = new Proveedor();
            $pM = new ProveedorM();
            $p->setId($json->id);
            $p->setEstado($json->estado);
            $retVal = $pM->Activar($p);
            echo json_encode($retVal);
        }
    }
}


?>