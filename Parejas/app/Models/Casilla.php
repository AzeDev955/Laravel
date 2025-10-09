<?php

class Casilla
{
    private $id;
    private $partida_id;
    private $numeroContenido;
    private $posicionEnTablero;
    private $destapada;

    public function __construct($id, $partida_id, $numeroContenido, $posicionEnTablero, $destapada)
    {
        $this->id = $id;
        $this->partida_id = $partida_id;
        $this->numeroContenido = $numeroContenido;
        $this->posicionEnTablero = $posicionEnTablero;
        $this->destapada = $destapada;

    }
    public function getId()
    {
        return $this->id;
    }
    public function getPartidaId()
    {
        return $this->partida_id;
    }
    public function getNumeroContenido()
    {
        return $this->numeroContenido;
    }
    public function getPosicionEnTablero()
    {
        return $this->posicionEnTablero;
    }
    public function getdestapada()
    {
        return $this->destapada;
    }
}