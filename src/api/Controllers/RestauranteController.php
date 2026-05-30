<?php

namespace Api\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Api\Services\RestauranteService;

class RestauranteController
{
    private RestauranteService $RestauranteService;

    public function __construct(RestauranteService $RestauranteServiceDependency)
    {
        error_log("⬆️ RestauranteController::__construct()");
        $this->RestauranteService = $RestauranteServiceDependency;
    }

    public function createController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 RestauranteController::createController()");

        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $novoRestaurante = $this->RestauranteService->createService($objPHP);

        $resposta = [
            'success' => true,
            'message' => 'Cadastro realizado com sucesso',
            'data' => [
                'restaurantes' => [
                    [
                        'idRestaurante' => $novoRestaurante->getIdRestaurante(),
                        'nomeRestaurante' => $novoRestaurante->getNomeRestaurante(),
                        'telefoneRestaurante' => $novoRestaurante->getTelefoneRestaurante(),
                        'enderecoRestaurante' => $novoRestaurante->getEnderecoRestaurante()
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
        error_log("🔵 RestauranteController::findAllController()");

        $Restaurante = $this->RestauranteService->findAllService();

        $resposta = [
            'success' => true,
            'message' => 'Busca realizada com sucesso',
            'data' => [
                'Restaurante' => $Restaurante
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function findByIdController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 RestauranteController::findByIdController()");

        $idRestaurante = (int) $args['idRestaurante'];
        $Restaurante = $this->RestauranteService->findByIdService($idRestaurante);

        $resposta = [
            'success' => true,
            'message' => 'Executado com sucesso',
            'data' => [
                'Restaurante' => $Restaurante
            ]
        ];

        $response->getBody()->write(json_encode($resposta));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function updateController(Request $request, Response $response, array $args): Response
    {
        error_log("🔵 RestauranteController::updateController()");

        $idRestaurante = (int) $args['idRestaurante'];


        $body = $request->getBody()->getContents();
        $objPHP = json_decode($body);

        $this->RestauranteService->updateService(
            $idRestaurante,
            $objPHP->Restaurantes->nomeRestaurante,
            $objPHP->Restaurantes->telefoneRestaurante,
            $objPHP->Restaurantes->enderecoRestaurante
        );

        $resposta = [
            'success' => true,
            'message' => 'Atualizado com sucesso',
            'data' => [
                'restaurantes' => [
                    [
                        'idRestaurante' => $idRestaurante
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
        error_log("🔵 RestauranteController::deleteController()");

        $idRestaurante = (int) $args['idRestaurante'];

        $this->RestauranteService->deleteService($idRestaurante);

        $resposta = [
            'success' => true,
            'message' => 'Excluído com sucesso',
            'data' => [
                'restaurantes' => [
                    [
                        'idRestaurante' => $idRestaurante
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
        error_log("🔵 RestauranteController::countController()");

        $total = $this->RestauranteService->countService();

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