<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class Pedidos implements JsonSerializable
{
    
    private ?int $idPedido = null;
    private ?float $valorTotal = null;
    private ?int $idCliente = null;
    private ?int $idRestaurante = null;

    public function __construct()
    {
        
    }

    public function getIdPedidos(): ?int
    {
        return $this->idPedido;
    }
    public function setIdPedido(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idPedido deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idPedido deve ser maior que zero.");
        }

        $this->idPedido = $value;
    }
    public function getValorTotal(): ?float
    {
        return $this->valorTotal;
    }
    public function setValorTotal(float $value): void
    {
        $valorTotal = $value;

        if ($valorTotal === '') {
            throw new InvalidArgumentException("valorTotal não pode ser vazio.");
        }

        if ($value < 0) {
            throw new InvalidArgumentException("valorTotal deve ser maior que 0");
        }

        $this->valorTotal = $value;
    }

    public function getIdCliente(): ?int
    {
        return $this->idCliente;
    }
    public function setIdCliente(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idCliente deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idCliente deve ser maior que zero.");
        }

        $this->idCliente = $value;
    }

    public function getIdRestaurante(): ?int
    {
        return $this->idRestaurante;
    }
    public function setIdRestaurante(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idRestaurante deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idRestaurante deve ser maior que zero.");
        }

        $this->idRestaurante = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            'idPedido' => $this->getIdPedidos(),
            'valorTotal' => $this->getValorTotal(),
            'idCliente' => $this->getIdCliente(),
            'idRestaurante' => $this->getIdRestaurante()
        ];
    }
}
