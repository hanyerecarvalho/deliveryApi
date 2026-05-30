<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class Restaurantes implements JsonSerializable
{
    
    private int $idRestaurante;
    private string $nomeRestaurante = "";
    private string $telefoneRestaurante = "";
    private string $enderecoRestaurante = "";

    public function __construct()
    {
        
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
    public function getNomeRestaurante(): ?string
    {
        return $this->nomeRestaurante;
    }
    public function setNomeRestaurante(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeRestaurante não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeRestaurante deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeRestaurante deve ter no máximo 64 caracteres.");
        }

        $this->nomeRestaurante = $nome;
    }

    public function getTelefoneRestaurante(): ?string
    {
        return $this->telefoneRestaurante;
    }

    public function setTelefoneRestaurante(string $value): void
    {
        $telefone = trim($value);

        if ($telefone === '') {
            throw new InvalidArgumentException("telefoneRestaurante nao pode ser vazio");
        }

        $len = mb_strlen($telefone);

        if ($len < 8) {
            throw new InvalidArgumentException("telefoneRestaurante deve ter pelo menos 8 caracteres");
        }

        if ($len > 15) {
            throw new InvalidArgumentException("telefoneRestaurante deve ter no maximo 15 caracteres");
        }

        $this->telefoneRestaurante = $telefone;
    }

    public function getEnderecoRestaurante(): ?string
    {
        return $this->enderecoRestaurante;
    }

    public function setEnderecoRestaurante(string $value): void
    {
        $this->enderecoRestaurante= $value;

    }

    public function jsonSerialize(): array
    {
        return [
            'idRestaurante' => $this->getIdRestaurante(),
            'nomeRestaurante' => $this->getNomeRestaurante(),
            'telefoneRestaurante' => $this->getTelefoneRestaurante(),
            'enderecoRestaurante' => $this->getEnderecoRestaurante()
        ];
    }
}
