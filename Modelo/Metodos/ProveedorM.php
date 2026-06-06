<?php

class ProveedorM
{
    function Crear(Proveedor $e)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($e->getId()==null){
            $sql="INSERT INTO PROVEEDOR("
                ." NOMBRE,"
                ." ESACTIVO)"
                ." VALUES ("
                ."'".$e->getNombre()."',"
                ."'".$e->getEsActivo()."')";
        }
        else{
            $sql="UPDATE PROVEEDOR SET ESACTIVO='".$e->getEsActivo().
                "', NOMBRE='".$e->getNombre().
                "' WHERE ID='".$e->getId()."'";
        }
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }
    function Activar(Proveedor $e)
    {
        $retVal=false;
        $conexion = new Conexion();
        $sql="UPDATE PROVEEDOR SET ESTADO='".$e->getEstado()."' WHERE ID='".$e->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    //Busca todos los productos de x categoria
    function Buscar($id)
    {
        $todos=array();
        $conexion= new Conexion();
        $sql="SELECT p.* FROM PRODUCTO p JOIN PROVEEDOR cat ON p.ID = cat.IDPRODUCTO WHERE cat.IDCATEGORIA = '".$idCategoria."'";
        $resultado=$conexion->Ejecutar($sql);
        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $e= new Producto();
                $e->setId($fila["ID"]);
                $e->setNombre($fila["NOMBRE"]);
                $e->setDescripcion($fila["DESCRIPCION"]);
                $e->setUrlImagen($fila["URLIMAGEN"]);
                $e->setPrecio($fila["PRECIO"]);
                $e->setCantDisponible($fila["CANTDISPONIBLE"]);
                $e->setFechaCreacion($fila["FECHACREACION"]);
                $e->setEstado($fila["ESTADO"]);
                $e->setIdLocalidad($fila["IDLOCALIDAD"]);
                $e->setDescuento($fila["DESCUENTO"]);
                $e->setHasDescuento($fila["HASDESCUENTO"]);
                $todos[]=$e;
            }
        }
        else
            $todos=null;
        $conexion->Cerrar();
        return $todos;
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
                $c= new Proveedor();
                $c->setId($fila["ID"]);
                $c->setIdCategoria($fila["IDCATEGORIA"]);
                $c->setIdProducto($fila["IDPRODUCTO"]);
                $c->setEstado($fila["ESTADO"]);
                $todos[]=$c;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();

        return $todos;
    }
}