<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "./Modelo/Entidades/Producto.php";
require_once "./Modelo/Metodos/ProductoM.php";

class ProductosControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            $pM = new ProductoM();
            $todos = $pM->BuscarTodos();
            $vistaActiva = "Productos";
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
            $p = new Producto();
            $pM = new ProductoM();
            $actualizar=false;

            $json = json_decode(file_get_contents('php://input'));

            if($json->id != ""){
                $p = $pM->Buscar($json->id);
                $actualizar=true;
            }else{
                $p->setEstado(1);
            }
            //id, nombre, prov, precio, cat
            $p->setNombre($json->nombre);
            $p->setPrecio($json->precio);
            $p->setProveedor($json->prov);
            $p->setCategoria($json->cat);
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
            $p = new Producto();
            $pM = new ProductoM();
            $p->setId($json->id);
            $p->setEstado($json->estado);
            $retVal = $pM->Activar($p);
            echo json_encode($retVal);
        }
    }
}


?>