<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\ProdutoService;

class ProdutosController
{
    private ProdutoService $ProdutoService;

    public function __construct(ProdutoService $ProdutoServiceDependency)
    {
        error_log("⬆️ ProdutoController::__construct()");
        $this->ProdutoService = $ProdutoServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProdutoController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoProduto = $this->ProdutoService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'Produtos' => [
                    [
                        'idRestaurante' => $novoProduto->getIdRestaurante(),
                        'idProduto' => $novoProduto->getIdProduto(),
                        'nomeProduto' => $novoProduto->getNomeProduto(),
                        'valorProduto' => $novoProduto->getValorProduto()
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
        error_log("🔵 ProdutoController::findAllController()");

        $Produtos = $this->ProdutoService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'Produtos' => $Produtos
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProdutoController::findByIdController()");

        $idProduto = (int) $args['idProduto'];
        $Produto = $this->ProdutoService->findByIdService($idProduto);

        if (!$Produto) {
            $resposta = [
                'success' => false,
                'message' => 'Produto não encontrado',
                'error' => [
                    'message' => "Não existe produto com id {$idProduto}"
                ]
            ];

            $response->getBody()->write(json_encode($resposta));
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'Produto' => $Produto
            ]
        ];

        $response->getBody()->write(json_encode($resposta));
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        $idProduto = (int) $args['idProduto'];
        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);
        $produto = $objPHP->Produtos; 

        $this->ProdutoService->updateService(
            (int) $produto->idRestaurante, 
            $idProduto,                     
            $produto->nomeProduto,          
            (float) $produto->valorProduto   
        );

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'Produtos' => [[
                    'idProduto'     => $idProduto,
                    'nomeProduto'   => $produto->nomeProduto,
                    'valorProduto'  => $produto->valorProduto,
                    'idRestaurante' => $produto->idRestaurante,
                ]]
            ]
        ];

        $response->getBody()->write(json_encode($resposta));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function deleteController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProdutoController::deleteController()");

        $idProduto = (int) $args['idProduto'];

        $this->ProdutoService->deleteService($idProduto);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'produtos' => [
                    [
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

    public function countController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 ProdutoController::countController()");

        $total = $this->ProdutoService->countService();

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