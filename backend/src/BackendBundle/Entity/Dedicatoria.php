<?php

namespace BackendBundle\Entity;

/**
 * Dedicatoria
 */
class Dedicatoria
{
    /**
     * @var int
     */
    private $iddedicatoria;

    /**
     * @var string|null
     */
    private $nombre;

    /**
     * @var string|null
     */
    private $dedicatoria;

    /**
     * @var \BackendBundle\Entity\Motivo
     */
    private $motivomotivo;


    /**
     * Get iddedicatoria.
     *
     * @return int
     */
    public function getIddedicatoria()
    {
        return $this->iddedicatoria;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return Dedicatoria
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
     * Set dedicatoria.
     *
     * @param string|null $dedicatoria
     *
     * @return Dedicatoria
     */
    public function setDedicatoria($dedicatoria = null)
    {
        $this->dedicatoria = $dedicatoria;

        return $this;
    }

    /**
     * Get dedicatoria.
     *
     * @return string|null
     */
    public function getDedicatoria()
    {
        return $this->dedicatoria;
    }

    /**
     * Set motivomotivo.
     *
     * @param \BackendBundle\Entity\Motivo|null $motivomotivo
     *
     * @return Dedicatoria
     */
    public function setMotivomotivo(\BackendBundle\Entity\Motivo $motivomotivo = null)
    {
        $this->motivomotivo = $motivomotivo;

        return $this;
    }

    /**
     * Get motivomotivo.
     *
     * @return \BackendBundle\Entity\Motivo|null
     */
    public function getMotivomotivo()
    {
        return $this->motivomotivo;
    }
}
