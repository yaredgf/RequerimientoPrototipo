<?php
session_start();
require_once "./Modelo/Entidades/Usuario.php";
require_once "./Modelo/Metodos/UsuarioM.php";


class UsuariosControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            header("Location: index.php?c=index");
            die();
        }
        if (isset($_SESSION["idUsuario"]))
        {
            $uM = new UsuarioM();
            $todos = $uM->BuscarTodos();
            $vista = "Usuarios";
            require_once "./Vistas/Dashboard.php";
        }
    }


    function LogIn()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $uM = new UsuarioM();

            $json = json_decode(file_get_contents('php://input'));
            $correo = $json->correo;
            $pass = $json->pass;

            $idUsuario = $uM->ValidarContrasenna($correo, hash('sha256', $pass));

            if ($idUsuario != -1)
            {
                $_SESSION["idUsuario"] = $idUsuario;
                $_SESSION["usuario"] = json_encode($uM->Buscar($idUsuario));
                echo json_encode(true);
            }
            else
                echo json_encode(false);
        }
        else
        {
            header("Location: index.php?c=index");
            die();
        }
    }

    function CerrarSesion()
    {
        unset($_SESSION["idUsuario"]);
        unset($_SESSION["usuario"]);
        header("Location: index.php?c=index");
        die();
    }

    function Crear() 
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $u = new Usuario();
            $uM = new UsuarioM();
            $actualizar=false;

            $json = json_decode(file_get_contents('php://input'));

            if($json->id != ""){
                $u = $uM->Buscar($json->id);
                $actualizar=true;
            }else{
                $u->setFechaCreacion(date(FORMATO_FECHA));
                $u->setEstado(1);
            }
            
            $u->setUsername($json->username);
            $u->setPass(hash('sha256', $json->pass));
            $u->setEmail($json->email);
            $u->setIdTipoUsuario($json->idTipoUsuario);
            $id = $uM->Crear($u);

            echo json_encode(true);
        }
        else
        {
            
        }
    }

    function Nuevo()
    {
        if (true)
        {
            $u = null;
            $json = json_decode(file_get_contents('php://input'));
            if($json->id != ""){
                $u = $uM->Buscar($json->id);
            }
            $vista = "UsuarioCrear";
            require_once "./Vistas/Dashboard.php";
        }
    }

    function Activar()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $retVal = false;
            $json = json_decode(file_get_contents('php://input'));
            $u = new Usuario();
            $uM = new UsuarioM();
            $u->setId($json->id);
            $u->setEstado($json->estado);
            $retVal = $uM->Activar();
            echo json_encode($retVal);
        }
    }

}

?>