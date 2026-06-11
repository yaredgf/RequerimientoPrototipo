<?php
require_once "./Modelo/Conexion.php";
require_once "./Modelo/Entidades/TipoUsuario.php";

class TipoUsuarioM
{
    function Crear(TipoUsuario $t)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($t->getId()==null){
            $sql="INSERT INTO TIPOUSUARIO("
                ." NOMBRE)"
                ." VALUES ("
                ."'".$t->getNombre()."')";
        }
        else{
            $sql="UPDATE TIPOUSUARIO SET NOMBRE='".$t->getNombre().
                "' WHERE ID='".$t->getId()."'";
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

        $sql="SELECT * FROM TIPOUSUARIO WHERE ID='".$id."'";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $retVal= new TipoUsuario();
                $retVal->setId($fila["Id"]);
                $retVal->setNombre($fila["Nombre"]);
            }
        }

        $conexion->Cerrar();

        return $retVal;
    }

    function BuscarTodos()
    {
        $todos=array();
        $conexion= new Conexion();

        $sql="SELECT * FROM TIPOUSUARIO";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $t= new TipoUsuario();
                $t->setId($fila["Id"]);
                $t->setNombre($fila["Nombre"]);
                $todos[]=$t;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();

        return $todos;
    }
}