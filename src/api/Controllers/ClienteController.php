<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\ClienteService;

class ClienteController
{
    private ClienteService $clienteService;
   
    public function __construct(ClienteService $clienteServiceDependency)
    {
        error_log("⬆️ ClienteController::__construct()");
        $this->clienteService = $clienteServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoCliente = $this->clienteService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'clientes' => [
                    [
                        'idCliente' => $novoCliente->getIdCliente(),
                        'nomeCliente' => $novoCliente->getNomeCliente(),
                        'telefoneCliente' => $novoCliente->getTelefoneCliente()
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }

    public function findAllController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::findAllController()");

        $clientes = $this->clienteService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'clientes' => $clientes
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::findByIdController()");

        $idCliente = (int) $args['idCliente'];
        $cliente = $this->clienteService->findByIdService($idCliente);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'clientes' => $cliente 
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::updateController()");

        $idCliente = (int) $args['idCliente'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $nomeCliente = $objPHP->cliente->nomeCliente;
        $telefoneCliente = $objPHP->cliente->telefoneCliente;

        $this->clienteService->updateService($idCliente, $nomeCliente, $telefoneCliente);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'clientes' => [
                    [
                        'idCliente' => $idCliente,
                        'nomeCliente' => $nomeCliente
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::deleteController()");

        $idCliente = (int) $args['idCliente'];

        $this->clienteService->deleteService($idCliente);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'clientes' => [
                    [
                        'idCliente' => $idCliente
                    ]
                ]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ClienteController::countController()");

        $total = $this->clienteService->countService();

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'count' => $total
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}