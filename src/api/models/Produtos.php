<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class Produtos implements JsonSerializable
{
    
    private float $valorProduto = 0.0;
    private string $nomeProduto = '';
    private int $idRestaurante = 0;
    private int $idProduto = 0;

    public function __construct()
    {
        
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
    public function getNomeProduto(): ?string
    {
        return $this->nomeProduto;
    }
    public function setNomeProduto(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeProduto não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeProduto deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeProduto deve ter no máximo 64 caracteres.");
        }

        $this->nomeProduto = $nome;
    }

    public function getValorProduto(): ?float
    {
        return $this->valorProduto;
    }

    public function setValorProduto(float $value): void
    {
        $valor = $value;

        if ($valor === '') {
            throw new InvalidArgumentException("valorProduto nao pode ser vazio");
        }

        if ($valor < 0) {
            throw new InvalidArgumentException("valorProduto nao pode ser negativo");
        }

        $this->valorProduto = $valor;
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
            'idProduto' => $this->getIdProduto(),
            'nomeProduto' => $this->getNomeProduto(),
            'valorProduto' => $this->getValorProduto(),
            'idRestaurante' => $this->getIdRestaurante()
        ];
    }
}
