<?php

class Conexion
{
    private $mysqli;

    function Ejecutar($query)
    {
        $servername ="127.0.0.1";
        $user="root";
        $pass="";
        $dbname ="requerimientoprototipo";

        if(!$this->mysqli=new mysqli($servername,$user,$pass,$dbname))
        {
            die('Error en conexion');
        }
        $this->mysqli->autocommit(TRUE);
        $resultado=$this->mysqli->query($query);
        return $resultado;
    }

    function Cerrar()
    {
        $this->mysqli->close();
    }
}