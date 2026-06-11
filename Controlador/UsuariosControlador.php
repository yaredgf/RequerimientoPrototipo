<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "./Modelo/Entidades/Usuario.php";
require_once "./Modelo/Metodos/UsuarioM.php";


class UsuariosControlador
{
    function Index()
    {
        if (isset($_SESSION["idUsuario"]))
        {
            $uM = new UsuarioM();
            $todos = $uM->BuscarTodos();
            $vistaActiva = "Usuarios";
            require_once "./Vistas/Dashboard.php";
        }
        else
        {
            header("Location: index.php?c=index");
            die();
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

        session_destroy();

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
                $u->setEstado(1);
            }
            
            $u->setUsername($json->username);
            $u->setPass(hash('sha256', $json->pass));
            $u->setEmail($json->email);
            $u->setIdTipoUsuario($json->rol);
            $id = $uM->Crear($u);

            echo json_encode(true);
        }
        else
        {
            
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
            $retVal = $uM->Activar($u);
            echo json_encode($retVal);
        }
    }

}

?>