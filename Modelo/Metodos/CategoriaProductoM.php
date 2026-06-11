<?php
require_once "./Modelo/Conexion.php";
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
            $sql="UPDATE CATEGORIAPRODUCTO SET ESTADO='".$p->getEstado().
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
        $sql="UPDATE CATEGORIAPRODUCTO SET ESTADO= NOT ESTADO WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    function Buscar($id)
    {
        $retVal=null;
        $conexion= new Conexion();

        $sql="SELECT * FROM CATEGORIAPRODUCTO WHERE ID = '".$id."';";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $retVal= new CategoriaProducto();
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

        $sql="SELECT * FROM CATEGORIAPRODUCTO";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $p= new CategoriaProducto();
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

?>

