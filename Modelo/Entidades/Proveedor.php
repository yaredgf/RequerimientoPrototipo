<?php

class Proveedor
{
    private $id, $nombre, $esActivo;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): void
    {
        $this->nombre = $nombre;
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

