<?php
namespace Api\Models;
use InvalidArgumentException;
use \JsonSerializable;


class Clientes implements JsonSerializable
{
    
    private int $idCliente;
    private string $nomeCliente = "";
    private string $telefoneCliente = "";

    public function __construct()
    {
        
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
    public function getNomeCliente(): ?string
    {
        return $this->nomeCliente;
    }
    public function setNomeCliente(string $value): void
    {
        $nome = trim($value);

        if ($nome === '') {
            throw new InvalidArgumentException("nomeCliente não pode ser vazio.");
        }

        $len = mb_strlen($nome);

        if ($len < 3) {
            throw new InvalidArgumentException("nomeCliente deve ter pelo menos 3 caracteres.");
        }

        if ($len > 64) {
            throw new InvalidArgumentException("nomeCliente deve ter no máximo 64 caracteres.");
        }

        $this->nomeCliente = $nome;
    }

    public function getTelefoneCliente(): ?string
    {
        return $this->telefoneCliente;
    }

    public function setTelefoneCliente(string $value): void
    {
        $telefone = trim($value);

        if ($telefone === '') {
            throw new InvalidArgumentException("telefoneCliente nao pode ser vazio");
        }

        $len = mb_strlen($telefone);

        if ($len < 8) {
            throw new InvalidArgumentException("telefoneCliente deve ter pelo menos 8 caracteres");
        }

        if ($len > 15) {
            throw new InvalidArgumentException("telefoneCliente deve ter no maximo 15 caracteres");
        }

        $this->telefoneCliente = $telefone;
    }

    public function jsonSerialize(): array
    {
        return [
            'idCliente' => $this->getIdCliente(),
            'nomeCliente' => $this->getNomeCliente(),
            'telefoneCliente' => $this->getTelefoneCliente()
        ];
    }
}
