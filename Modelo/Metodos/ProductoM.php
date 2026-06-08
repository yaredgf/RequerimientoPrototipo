<?php
Class ProductoM
{
    function Crear(Producto $p)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($p->getId()==null){
            $sql="INSERT INTO PRODUCTO("
                ." NOMBRE,"
                ." DESCRIPCION,"
                ." PRECIO,"
                ." IDCATEGORIA)"
                ." VALUES ("
                ."'".$p->getNombre()."',"
                ."'".$p->getDescripcion()."',"
                ."'".$p->getPrecio()."',"
                ."'".$p->getIdCategoria()."')";
        }
        else{
            $sql="UPDATE PRODUCTO SET NOMBRE='".$p->getNombre().
                "', DESCRIPCION='".$p->getDescripcion().
                "', PRECIO='".$p->getPrecio().
                "', IDCATEGORIA='".$p->getIdCategoria().
                "' WHERE ID='".$p->getId()."'";
        }
        if($conexion->Ejecutar($sql))
            $retVal=true;
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
                $p->setId($fila["ID"]);
                $p->setNombre($fila["NOMBRE"]);
                $p->setDescripcion($fila["DESCRIPCION"]);
                $p->setPrecio($fila["PRECIO"]);
                $p->setIdCategoria($fila["IDCATEGORIA"]);
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
        $sql="UPDATE PRODUCTO SET ESTADO='".$p->getEstado()."' WHERE ID='".$p->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }
}