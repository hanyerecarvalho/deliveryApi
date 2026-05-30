<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\ItensPedidoService;

class ItemPedidoController
{
    private ItensPedidoService $ItensPedidoService;

    public function __construct(ItensPedidoService $ItensPedidoServiceDependency)
    {
        error_log("⬆️ ItensPedidoController::__construct()");
        $this->ItensPedidoService = $ItensPedidoServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ItensPedidoController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoItemPedido = $this->ItensPedidoService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'itensPedidos' => [
                    [
                        'idItemPedido' => $novoItemPedido->getIdItemPedido(),
                        'quantidade' => $novoItemPedido->getQuantidade(),
                        'idPedido' => $novoItemPedido->getIdPedido(),
                        'idProduto' => $novoItemPedido->getIdProduto()
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
        error_log("🔵 ItensPedidoController::findAllController()");

        $itensPedido = $this->ItensPedidoService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'itensPedido' => $itensPedido
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ItensPedidoController::findByIdController()");

        $idItemPedido = (int) $args['idItemPedido'];
        $itemPedido = $this->ItensPedidoService->findByIdService($idItemPedido);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'itemPedido' => $itemPedido
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ItensPedidoController::updateController()");

        $idItemPedido = (int) $args['idItemPedido'];

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $quantidade = (int) $objPHP->itensPedidos->quantidade;
        $idPedido = (int) $objPHP->itensPedidos->idPedido;
        $idProduto = (int) $objPHP->itensPedidos->idProduto;

        $this->ItensPedidoService->updateService($idPedido, $idProduto, $quantidade, $idItemPedido);

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'itensPedidos' => [ 
                    [
                        'idItemPedido' => $idItemPedido,
                        'quantidade' => $quantidade,
                        'idPedido' => $idPedido,
                        'idProduto' => $idProduto
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
        error_log("🔵 ItensPedidoController::deleteController()");

        $idItemPedido = (int) $args['idItemPedido'];

        $this->ItensPedidoService->deleteService($idItemPedido);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'itensPedidos' => [
                    [
                        'idItemPedido' => $idItemPedido
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
        error_log("🔵 ItensPedidoController::countController()");

        $total = $this->ItensPedidoService->countService();

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