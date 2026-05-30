<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\PedidoService;

class PedidoController
{
    private PedidoService $PedidoService;

    public function __construct(PedidoService $PedidoServiceDependency)
    {
        error_log("⬆️ ProdutoController::__construct()");
        $this->PedidoService = $PedidoServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 PedidoController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoPedido = $this->PedidoService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'Pedidos' => [
                    [
                        'idPedido' => $novoPedido->getIdPedidos(),
                        'valorTotal' => $novoPedido->getValorTotal(),
                        'idCliente' => $novoPedido->getIdCliente(),
                        'idRestaurante' => $novoPedido->getIdRestaurante()
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
        error_log("🔵 PedidoController::findAllController()");

        $Pedido = $this->PedidoService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'Pedido' => $Pedido
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 PedidoController::findByIdController()");

        $idPedido = (int) $args['idPedido'];
        $Pedido = $this->PedidoService->findByIdService($idPedido);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'Pedido' => $Pedido
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 PedidoController::updateController()");

        $idPedido = (int) $args['idPedido'];
        $body = $request->getParsedBody();
        $pedido = $body['pedidos'];

        $this->PedidoService->updateService(
            $idPedido,
            (float) $pedido['valorTotal'],
            (int) $pedido['idCliente'],
            (int) $pedido['idRestaurante']
        );
        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'Pedidos' => [
                    [
                        'idPedido'      => $idPedido,
                        'valorTotal'    => $pedido['valorTotal'],
                        'idCliente'     => $pedido['idCliente'],
                        'idRestaurante' => $pedido['idRestaurante'],
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
        error_log("🔵 PedidoController::deleteController()");

        $idPedido = (int) $args['idPedido'];

        $this->PedidoService->deleteService($idPedido);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'Pedido' => [
                    [
                        'idPedido' => $idPedido
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
        error_log("🔵 PedidoController::countController()");

        $total = $this->PedidoService->countService();

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