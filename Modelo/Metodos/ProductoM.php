<?php
require_once "./Modelo/Conexion.php";
require_once "./Modelo/Entidades/Producto.php";

Class ProductoM
{
    function Crear(Producto $p)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($p->getId()==null){
            $sql="INSERT INTO PRODUCTO("
                ." NOMBRE,"
                ." IdProveedor,"
                ." PRECIO,"
                ." IDCATEGORIA)"
                ." VALUES ("
                ."'".$p->getNombre()."',"
                ."'".$p->getProveedor()."',"
                ."'".$p->getPrecio()."',"
                ."'".$p->getCategoria()."')";
        }
        else{
            $sql="UPDATE PRODUCTO SET ESTADO='".$p->getEstado().
                "', NOMBRE='".$p->getNombre().
                "', IdProveedor='".$p->getProveedor().
                "', PRECIO='".$p->getPrecio().
                "', IDCATEGORIA='".$p->getCategoria().
                "' WHERE ID='".$p->getId()."'";
        }
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    function Buscar($id)
    {
        $retVal=null;
        $conexion= new Conexion();

        $sql="SELECT * FROM PRODUCTO u WHERE u.ID = '".$id."';";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $retVal= new Producto();
                $retVal->setId($fila["Id"]);
                $retVal->setNombre($fila["Nombre"]);
                $retVal->setProveedor($fila["IdProveedor"]);
                $retVal->setPrecio($fila["Precio"]);
                $retVal->setCategoria($fila["IdCategoria"]);
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

        $sql="SELECT * FROM PRODUCTO";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $p= new Producto();
                $p->setId($fila["Id"]);
                $p->setNombre($fila["Nombre"]);
                $p->setProveedor($fila["IdProveedor"]);
                $p->setPrecio($fila["Precio"]);
                $p->setCategoria($fila["IdCategoria"]);
                $p->setEstado($fila["Estado"]);
                $todos[]=$p;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();
        return $todos;
    }

    function Activar(Producto $p)
    {
        $retVal=false;
        $conexion = new Conexion();
        $sql="UPDATE PRODUCTO SET ESTADO= NOT ESTADO WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }
}