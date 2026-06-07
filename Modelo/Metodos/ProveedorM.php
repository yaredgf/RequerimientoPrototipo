<?php

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
        $sql="UPDATE PROVEEDOR SET ESTADO='".$p->getEstado()."' WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
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
                $p->setId($fila["ID"]);
                $p->setIdCategoria($fila["IDCATEGORIA"]);
                $p->setIdProducto($fila["IDPRODUCTO"]);
                $p->setEstado($fila["ESTADO"]);
                $todos[]=$p;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();

        return $todos;
    }
}