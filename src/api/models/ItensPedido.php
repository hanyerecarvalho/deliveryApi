<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class ItensPedido implements JsonSerializable
{
    
    private int $idItemPedido;
    private int $quantidade;
    private int $idPedido;
    private int $idProduto;

    public function __construct()
    {
        
    }

    public function getIdItemPedido(): ?int
    {
        return $this->idItemPedido;
    }
    public function setIdItemPedido(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idItemPedido deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idItemPedido deve ser maior que zero.");
        }

        $this->idItemPedido = $value;
    }
    public function getQuantidade(): ?int
    {
        return $this->idItemPedido;
    }
    public function setQuantidade(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idQuantidade deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idQuantidade deve ser maior que zero.");
        }

        $this->quantidade = $value;
    }

    public function getIdPedido(): ?int
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

    public function getIdProduto(): ?int
    {
        return $this->idProduto;
    }
    public function setIdProduto(int $value): void
    {
        if (!is_int($value)) {
            throw new InvalidArgumentException("idProduto deve ser um número inteiro.");
        }

        if ($value <= 0) {
            throw new InvalidArgumentException("idProduto deve ser maior que zero.");
        }

        $this->idProduto = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            'idItemPedido' => $this->getIdItemPedido(),
            'quantidade' => $this->getQuantidade(),
            'idPedido' => $this->getIdPedido(),
            'idProduto' => $this->getIdProduto()
        ];
    }
}
