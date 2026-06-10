<?php

require_once "./Modelo/Entidades/CategoriaProducto.php";

class CategoriaProductoM
{
    function Crear(CategoriaProducto $p)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($p->getId()==null){
            $sql="INSERT INTO CATEGORIAPRODUCTO("
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
    function Activar(CategoriaProducto $p)
    {
        $retVal=false;
        $conexion = new Conexion();
        $sql="UPDATE CATEGORIAPRODUCTO SET ESTADO='".$p->getEstado()."' WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    function BuscarTodos()
    {
        $todos=array();
        $conexion= new Conexion();

        $sql="SELECT * FROM CATEGORIAPRODUCTO";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $p= new CategoriaProducto();
                $p->setId($fila["ID"]);
                $p->setNombre($fila["NOMBRE"]);
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

?>

