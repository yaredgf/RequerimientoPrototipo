<?php

class CategoriaProducto
{
    private $id, $nombre, $Estado;

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

    public function getEstado()
    {
        return $this->Estado;
    }

    public function setEstado($Estado): void
    {
        $this->Estado = $Estado;
    }
}

?>