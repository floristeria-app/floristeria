<?php

namespace BackendBundle\Entity;

/**
 * Pedido
 */
class Pedido
{
    /**
     * @var int
     */
    private $idpedido;

    /**
     * @var string|null
     */
    private $para;

    /**
     * @var string|null
     */
    private $de;

    /**
     * @var string|null
     */
    private $direccionEntrega;

    /**
     * @var bool|null
     */
    private $pago;

    /**
     * @var string|null
     */
    private $valor;

    /**
     * @var string|null
     */
    private $valorDomicilio;

    /**
     * @var \DateTime|null
     */
    private $fechaEntrega;

    /**
     * @var \DateTime|null
     */
    private $fechaCobro;

    /**
     * @var \DateTime|null
     */
    private $fechaGeneracion;

    /**
     * @var string|null
     */
    private $direccionCobro;

    /**
     * @var string|null
     */
    private $telefonoEntrega;

    /**
     * @var string|null
     */
    private $telefonoCobro;

    /**
     * @var bool|null
     */
    private $entregado;

    /**
     * @var \DateTime|null
     */
    private $hora;

    /**
     * @var string|null
     */
    private $comentario;

    /**
     * @var \BackendBundle\Entity\Cliente
     */
    private $clientecliente;

    /**
     * @var \BackendBundle\Entity\Motivo
     */
    private $motivomotivo;


    /**
     * Get idpedido.
     *
     * @return int
     */
    public function getIdpedido()
    {
        return $this->idpedido;
    }

    /**
     * Set para.
     *
     * @param string|null $para
     *
     * @return Pedido
     */
    public function setPara($para = null)
    {
        $this->para = $para;

        return $this;
    }

    /**
     * Get para.
     *
     * @return string|null
     */
    public function getPara()
    {
        return $this->para;
    }

    /**
     * Set de.
     *
     * @param string|null $de
     *
     * @return Pedido
     */
    public function setDe($de = null)
    {
        $this->de = $de;

        return $this;
    }

    /**
     * Get de.
     *
     * @return string|null
     */
    public function getDe()
    {
        return $this->de;
    }

    /**
     * Set direccionEntrega.
     *
     * @param string|null $direccionEntrega
     *
     * @return Pedido
     */
    public function setDireccionEntrega($direccionEntrega = null)
    {
        $this->direccionEntrega = $direccionEntrega;

        return $this;
    }

    /**
     * Get direccionEntrega.
     *
     * @return string|null
     */
    public function getDireccionEntrega()
    {
        return $this->direccionEntrega;
    }

    /**
     * Set pago.
     *
     * @param bool|null $pago
     *
     * @return Pedido
     */
    public function setPago($pago = null)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago.
     *
     * @return bool|null
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set valor.
     *
     * @param string|null $valor
     *
     * @return Pedido
     */
    public function setValor($valor = null)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor.
     *
     * @return string|null
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set valorDomicilio.
     *
     * @param string|null $valorDomicilio
     *
     * @return Pedido
     */
    public function setValorDomicilio($valorDomicilio = null)
    {
        $this->valorDomicilio = $valorDomicilio;

        return $this;
    }

    /**
     * Get valorDomicilio.
     *
     * @return string|null
     */
    public function getValorDomicilio()
    {
        return $this->valorDomicilio;
    }

    /**
     * Set fechaEntrega.
     *
     * @param \DateTime|null $fechaEntrega
     *
     * @return Pedido
     */
    public function setFechaEntrega($fechaEntrega = null)
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    /**
     * Get fechaEntrega.
     *
     * @return \DateTime|null
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * Set fechaCobro.
     *
     * @param \DateTime|null $fechaCobro
     *
     * @return Pedido
     */
    public function setFechaCobro($fechaCobro = null)
    {
        $this->fechaCobro = $fechaCobro;

        return $this;
    }

    /**
     * Get fechaCobro.
     *
     * @return \DateTime|null
     */
    public function getFechaCobro()
    {
        return $this->fechaCobro;
    }

    /**
     * Set fechaGeneracion.
     *
     * @param \DateTime|null $fechaGeneracion
     *
     * @return Pedido
     */
    public function setFechaGeneracion($fechaGeneracion = null)
    {
        $this->fechaGeneracion = $fechaGeneracion;

        return $this;
    }

    /**
     * Get fechaGeneracion.
     *
     * @return \DateTime|null
     */
    public function getFechaGeneracion()
    {
        return $this->fechaGeneracion;
    }

    /**
     * Set direccionCobro.
     *
     * @param string|null $direccionCobro
     *
     * @return Pedido
     */
    public function setDireccionCobro($direccionCobro = null)
    {
        $this->direccionCobro = $direccionCobro;

        return $this;
    }

    /**
     * Get direccionCobro.
     *
     * @return string|null
     */
    public function getDireccionCobro()
    {
        return $this->direccionCobro;
    }

    /**
     * Set telefonoEntrega.
     *
     * @param string|null $telefonoEntrega
     *
     * @return Pedido
     */
    public function setTelefonoEntrega($telefonoEntrega = null)
    {
        $this->telefonoEntrega = $telefonoEntrega;

        return $this;
    }

    /**
     * Get telefonoEntrega.
     *
     * @return string|null
     */
    public function getTelefonoEntrega()
    {
        return $this->telefonoEntrega;
    }

    /**
     * Set telefonoCobro.
     *
     * @param string|null $telefonoCobro
     *
     * @return Pedido
     */
    public function setTelefonoCobro($telefonoCobro = null)
    {
        $this->telefonoCobro = $telefonoCobro;

        return $this;
    }

    /**
     * Get telefonoCobro.
     *
     * @return string|null
     */
    public function getTelefonoCobro()
    {
        return $this->telefonoCobro;
    }

    /**
     * Set entregado.
     *
     * @param bool|null $entregado
     *
     * @return Pedido
     */
    public function setEntregado($entregado = null)
    {
        $this->entregado = $entregado;

        return $this;
    }

    /**
     * Get entregado.
     *
     * @return bool|null
     */
    public function getEntregado()
    {
        return $this->entregado;
    }

    /**
     * Set hora.
     *
     * @param \DateTime|null $hora
     *
     * @return Pedido
     */
    public function setHora($hora = null)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora.
     *
     * @return \DateTime|null
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set comentario.
     *
     * @param string|null $comentario
     *
     * @return Pedido
     */
    public function setComentario($comentario = null)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario.
     *
     * @return string|null
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set clientecliente.
     *
     * @param \BackendBundle\Entity\Cliente|null $clientecliente
     *
     * @return Pedido
     */
    public function setClientecliente(\BackendBundle\Entity\Cliente $clientecliente = null)
    {
        $this->clientecliente = $clientecliente;

        return $this;
    }

    /**
     * Get clientecliente.
     *
     * @return \BackendBundle\Entity\Cliente|null
     */
    public function getClientecliente()
    {
        return $this->clientecliente;
    }

    /**
     * Set motivomotivo.
     *
     * @param \BackendBundle\Entity\Motivo|null $motivomotivo
     *
     * @return Pedido
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
