<?php

class Usuario
{
    private $id, $username, $pass, $idTipoUsuario, $esActivo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass): void
    {
        $this->pass = $pass;
    }

    public function getIdTipoUsuario()
    {
        return $this->idTipoUsuario;
    }

    public function setIdTipoUsuario($idTipoUsuario): void
    {
        $this->idTipoUsuario = $idTipoUsuario;
    }

    public function getEsActivo()
    {
        return $this->esActivo;
    }

    public function setEsActivo($esActivo): void
    {
        $this->esActivo = $esActivo;
    }


}

?>