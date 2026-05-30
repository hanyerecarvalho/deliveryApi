<?php

namespace Api\Services;

use Api\Models\Clientes;
use Api\DAO\ClienteDAO;
use Api\Http\ErrorResponse;
use stdClass;

class ClienteService
{
    private ClienteDAO $clienteDAO;

    public function __construct(ClienteDAO $clienteDAODependency)
    {
        error_log("⬆️ ClienteService::__construct()");
        $this->clienteDAO = $clienteDAODependency;
    }

    public function createService(stdClass $objPHP): Clientes
    {
        error_log("🟣 ClienteService::createService()");

        $cliente = new Clientes();
        $cliente->setIdCliente($objPHP->cliente->idCliente);
        $cliente->setNomeCliente($objPHP->cliente->nomeCliente);
        $cliente->setTelefoneCliente($objPHP->cliente->telefoneCliente);

        
        $resultado = $this->clienteDAO->findByField(
            'idCliente', $cliente->getIdCliente()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Cliente já existe",
                [
                    "message" =>
                        "O cliente {$cliente->getIdCliente()} já existe"
                ]
            );
        }

        return $this->clienteDAO->create($cliente);
    }

    
    public function countService(): int
    {
        error_log("🟣 ClienteService::countService()");
        return $this->clienteDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 ClienteService::findAllService()");
        return $this->clienteDAO->findAll();
    }

    public function findByIdService(int $idCliente): ?Clientes
    {
        error_log("🟣 ClienteService::findByIdService()");

        $cliente = new Clientes();
        $cliente->setIdCliente($idCliente);

        return $this->clienteDAO->findById(
            $cliente->getIdCliente()
        );
    }

    public function updateService(int $idCliente, string $nomeCliente, string $telefoneCliente): bool
    {
        error_log("🟣 ClienteService::updateService()");

        /**
         * Verifica existência.
         */
        $clienteExistente = $this->clienteDAO->findById($idCliente);

        if (!$clienteExistente) {
            throw new ErrorResponse(
                404,
                "Cliente não encontrado",
                [
                    "message" =>
                        "Não existe cargo com id {$idCliente}"
                ]
            );
        }

        /**
         * Monta objeto atualizado.
         */
        $cliente = new Clientes();
        $cliente->setIdCliente($idCliente);
        $cliente->setNomeCliente($nomeCliente);
        $cliente->setTelefoneCliente($telefoneCliente);

        return $this->clienteDAO->update($cliente);
    }

    public function deleteService(int $idCliente): bool
    {
        error_log("🟣 ClienteService::deleteService()");

        /**
         * Verifica existência.
         */
        $clienteExistente = $this->clienteDAO->findById($idCliente);

        if (!$clienteExistente) {
            throw new ErrorResponse(
                404,
                "Cliente não encontrado",
                [
                    "message" =>
                        "Não existe Cliente com id {$idCliente}"
                ]
            );
        }

        /**
         * Monta objeto para exclusão.
         */
        $cliente = new Clientes();
        $cliente->setIdCliente($idCliente);

        return $this->clienteDAO->delete($cliente);
    }
}