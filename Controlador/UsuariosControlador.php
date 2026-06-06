<?php
session_start();
require_once "./Modelo/Conexion.php";

require_once "./Modelo/Entidades/Usuario.php";
require_once "./Modelo/Metodos/UsuarioM.php";


class UsuariosControlador
{
    function Index()
    {
        require_once "./Vistas/LogIn.php";
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
                $_SESSION["idUsuario"] = $correo;
                $_SESSION["usuario"] = $correo;
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

    function Crear() // FALTA HACER ESTOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
    {
        $u = new Usuario();
        $uM = new UsuarioM();
        $actualizar=false;
        if(isset($_POST['id'])){
            if($_POST['id']!=""){
                $u = $uM->Buscar($_POST['id']);
                $actualizar=true;
            }else{
            $u->setCorreo($_POST["correo"]);
                $u->setFechaCreacion(date("Y-m-d H:i:s"));
            }
        }
        else
        {
            $u->setCorreo($_POST["correo"]);
            $u->setFechaCreacion(date("Y-m-d H:i:s"));
        }
        $u->setEstado(1);
        if(isset($_POST['cedula'])){
            $u->setCedula($_POST["cedula"]);
        }
        if(isset($_POST['correo'])){
            $u->setCorreo($_POST["correo"]);
        }
        $u->setNombre($_POST["nombre"]);
        $u->setApellidos($_POST["apellidos"]);
        $u->setTelefono($_POST["telefono"]);
        $u->setIsValidated(false);
        $id = $uM->Crear($u);

        echo var_dump($id);
        if(!$actualizar){
            $c->setIdUsuario($id);
            $c->setToken('sasa');
            $c->setIsTemp($esTemporal);
            $c->setPass(hash('sha256', $password));
            var_dump($c->getIdUsuario());
            $cM->Crear($c);
            $this->PassReset($u->getCorreo());
            
        }
        header("Location: index.php?c=Usuarios&a=Cuenta");
        die();
    }

    /*
    Buscar
    BuscarTodos
    Activar


    */
}







?>