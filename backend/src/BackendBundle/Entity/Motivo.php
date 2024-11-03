<?php

namespace BackendBundle\Entity;

/**
 * Motivo
 */
class Motivo
{
    /**
     * @var int
     */
    private $idmotivo;

    /**
     * @var string|null
     */
    private $nombre;

    /**
     * @var string|null
     */
    private $descripcion;


    /**
     * Get idmotivo.
     *
     * @return int
     */
    public function getIdmotivo()
    {
        return $this->idmotivo;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return Motivo
     */
    public function setNombre($nombre = null)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string|null
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return Motivo
     */
    public function setDescripcion($descripcion = null)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string|null
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
