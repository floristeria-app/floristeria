<?php

namespace BackendBundle\Entity;

/**
 * Cliente
 */
class Cliente
{
    /**
     * @var int
     */
    private $idcliente;

    /**
     * @var string|null
     */
    private $numCliente;

    /**
     * @var string|null
     */
    private $nombre;

    /**
     * @var string|null
     */
    private $apellidos;

    /**
     * @var string|null
     */
    private $telefono;

    /**
     * @var string|null
     */
    private $celular;

    /**
     * @var string|null
     */
    private $email;


    /**
     * Get idcliente.
     *
     * @return int
     */
    public function getIdcliente()
    {
        return $this->idcliente;
    }

    /**
     * Set numCliente.
     *
     * @param string|null $numCliente
     *
     * @return Cliente
     */
    public function setNumCliente($numCliente = null)
    {
        $this->numCliente = $numCliente;

        return $this;
    }

    /**
     * Get numCliente.
     *
     * @return string|null
     */
    public function getNumCliente()
    {
        return $this->numCliente;
    }

    /**
     * Set nombre.
     *
     * @param string|null $nombre
     *
     * @return Cliente
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
     * Set apellidos.
     *
     * @param string|null $apellidos
     *
     * @return Cliente
     */
    public function setApellidos($apellidos = null)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos.
     *
     * @return string|null
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set telefono.
     *
     * @param string|null $telefono
     *
     * @return Cliente
     */
    public function setTelefono($telefono = null)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string|null
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular.
     *
     * @param string|null $celular
     *
     * @return Cliente
     */
    public function setCelular($celular = null)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular.
     *
     * @return string|null
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Cliente
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }
}
