<?php

namespace BackendBundle\Entity;

/**
 * ImagenTarjeta
 */
class ImagenTarjeta
{
    /**
     * @var int
     */
    private $idimagenTarjeta;

    /**
     * @var string|null
     */
    private $nombre;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $descripcion;

    /**
     * @var \BackendBundle\Entity\Motivo
     */
    private $motivomotivo;


    /**
     * Get idimagenTarjeta.
     *
     * @return int
     */
    public function getIdimagenTarjeta()
    {
        return $this->idimagenTarjeta;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return ImagenTarjeta
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
     * Set url.
     *
     * @param string|null $url
     *
     * @return ImagenTarjeta
     */
    public function setUrl($url = null)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set descripcion.
     *
     * @param string|null $descripcion
     *
     * @return ImagenTarjeta
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

    /**
     * Set motivomotivo.
     *
     * @param \BackendBundle\Entity\Motivo|null $motivomotivo
     *
     * @return ImagenTarjeta
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
