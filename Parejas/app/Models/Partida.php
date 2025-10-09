<?php

class Partida
{
    private $id;
    private $usuario_id;
    private $estado;
    private $intentos;

    public function __construct($id, $usuario_id, $estado, $intentos)
    {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->estado = $estado;
        $this->intentos = $intentos;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }
    public function getestado()
    {
        return $this->estado;
    }
    public function getintentos()
    {
        return $this->intentos;
    }

}