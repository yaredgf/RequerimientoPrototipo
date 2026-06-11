<?php
require_once "./Modelo/Conexion.php";

require_once "./Modelo/Entidades/Usuario.php";

class UsuarioM
{
    function CorreoDisponible($correo)
    {
        $retVal=false;
        $conexion= new Conexion();

        $sql="SELECT CASE WHEN COUNT(1) = 0 THEN TRUE ELSE FALSE END AS disponible FROM USUARIO u WHERE u.Email = '".$correo."' ;";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $retVal = $fila["disponible"];
            }
        }

        $conexion->Cerrar();

        return $retVal;
    }
    function BuscarPorCorreo ($correo)
    {
        $retVal=null;
        $conexion= new Conexion();

        $sql="SELECT * FROM USUARIO u WHERE u.Email = '".$correo."';";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $u= new Usuario();
                $retVal->setId($fila["Id"]);
                $retVal->setUsername($fila["Username"]);
                $retVal->setEmail($fila["Email"]);
                $retVal->setIdTipoUsuario($fila["idTipoUsuario"]);
                $retVal->setEstado($fila["Estado"]);
            }
        }

        $conexion->Cerrar();

        return $retVal;
    }

    function ValidarContrasenna($correo, $pass)
    {
        $retVal=-1;
        $conexion = new Conexion();
        $sql = "SELECT CASE WHEN u.Password = '".$pass."' THEN u.Id ELSE -1 END AS Valido FROM `usuario` u WHERE u.Email = '".$correo."';";
        
        $resultado=$conexion->Ejecutar($sql);
        while($fila=$resultado->fetch_assoc())
        {
            $retVal = $fila["Valido"];
        }

        $conexion->Cerrar();
        return $retVal;
    }
    
    function Crear(Usuario $u)
    {
        $retVal=false;
        $conexion= new Conexion();
        if($u->getId()==null){
            $sql="INSERT INTO Usuario("
                ." USERNAME,"
                ." PASSWORD,"
                ." EMAIL,"
                ." IDTIPOUSUARIO,"
                ." ESTADO)"
                ." VALUES ("
                ."'".$u->getUsername()."',"
                ."'".$u->getPass()."',"
                ."'".$u->getEmail()."',"
                ."'".$u->getIdTipoUsuario()."',"
                ."'".$u->getEstado()."')";
        }
        else{
            $sql="UPDATE USUARIO SET ESTADO='".$u->getEstado().
                "', USERNAME='".$u->getUsername().
                "', PASSWORD='".$u->getPass().
                "', EMAIL='".$u->getEmail().
                "', IDTIPOUSUARIO='".$u->getIdTipoUsuario().
                "' WHERE ID='".$u->getId()."'";
        }
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }
    function Activar(Usuario $u)
    {
        $retVal=false;
        $conexion = new Conexion();
        $sql="UPDATE USUARIO SET ESTADO='".$u->getEstado()."' WHERE ID='".$u->getId()."'";
        if($conexion->Ejecutar($sql))
            $retVal=true;
        $conexion->Cerrar();
        return $retVal;
    }

    function Buscar($id)
    {
        $retVal= new Usuario();
        $conexion= new Conexion();

        $sql="SELECT * FROM USUARIO u WHERE u.ID = '".$id."';";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $u= new Usuario();
                $retVal->setId($fila["Id"]);
                $retVal->setUsername($fila["Username"]);
                $retVal->setEmail($fila["Email"]);
                $retVal->setIdTipoUsuario($fila["idTipoUsuario"]);
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

        $sql="SELECT * FROM USUARIO";
        $resultado=$conexion->Ejecutar($sql);

        if(mysqli_num_rows($resultado)>0)
        {
            while($fila=$resultado->fetch_assoc())
            {
                $u= new Usuario();
                $u->setId($fila["Id"]);
                $u->setUsername($fila["Username"]);
                $u->setEmail($fila["Email"]);
                $u->setIdTipoUsuario($fila["idTipoUsuario"]);
                $u->setEstado($fila["Estado"]);
                $todos[]=$u;
            }
        }
        else
            $todos=null;

        $conexion->Cerrar();

        return $todos;
    }
}


?>