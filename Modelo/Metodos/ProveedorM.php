<?php
require_once "./Modelo/Conexion.php";
require_once "./Modelo/Entidades/Proveedor.php";

class ProveedorM
{
    function Crear(Proveedor $p)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($p->getId()==null){
            $sql="INSERT INTO PROVEEDOR("
                ." NOMBRE,"
                ." ESTADO)"
                ." VALUES ("
                ."'".$p->getNombre()."',"
                ."'".$p->getEstado()."')";
        }
        else{
            $sql="UPDATE PROVEEDOR SET ESTADO='".$p->getEstado().
                "', NOMBRE='".$p->getNombre().
                "' WHERE ID='".$p->getId()."'";
        }
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }
    function Activar(Proveedor $p)
    {
        $retVal=false;
        $conexion = new Conexion();
        $sql="UPDATE PROVEEDOR SET ESTADO= NOT ESTADO WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    function Buscar($id)
    {
        $retVal=null;
        $conexion= new Conexion();

        $sql="SELECT * FROM PROVEEDOR WHERE ID='".$id."'";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $retVal= new Proveedor();
                $retVal->setId($fila["Id"]);
                $retVal->setNombre($fila["Nombre"]);
                $retVal->setEstado($fila["Estado"]);
            }
        }

        $conexion->Cerrar();

        return $retVal;
    }

    function BuscarTodos()
    {
        $todos=array();
        $conexion= new Conexion();

        $sql="SELECT * FROM PROVEEDOR";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $p= new Proveedor();
                $p->setId($fila["Id"]);
                $p->setNombre($fila["Nombre"]);
                $p->setEstado($fila["Estado"]);
                $todos[]=$p;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();

        return $todos;
    }
}