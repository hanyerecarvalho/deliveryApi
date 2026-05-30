<?php

namespace Api\Middlewares\Produtos;

use Psr\Http\Message\ServerRequestInterface as Request;   // Interface do PSR-7 para requisições HTTP
use Psr\Http\Message\ResponseInterface as Response;       // Interface do PSR-7 para respostas HTTP
use Psr\Http\Server\RequestHandlerInterface as RequestHandler; // Interface que representa o próximo middleware/handler
use Psr\Http\Server\MiddlewareInterface;                  // Interface obrigatória para criar middlewares no PSR-15
use Api\Http\ErrorResponse;                               // Classe personalizada para padronizar erros da aplicação


class ValidateProdutosBody implements MiddlewareInterface
{
    /**
     * Método principal do middleware.
     *
     * @param Request $request
     * @param RequestHandler $handler
     * @return Response
     * @throws ErrorResponse
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Lê o JSON bruto enviado no body
        $body = $request->getBody()->getContents();

        // Converte JSON para objeto stdClass
        $objPHP = json_decode($body);

        // -----------------------------------------------------------
        // Validação 1: verificar se o campo principal 'cargo' existe
        // -----------------------------------------------------------
        if (!isset($objPHP->Produtos)) {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'Produtos' é obrigatório!"
                ]
            );
        }

        // // Armazena objeto cargo
        $produto = $objPHP->Produtos;

        // // -----------------------------------------------------------
        // // Validação 2: verificar se 'nomeCargo' existe e não está vazio
        // // -----------------------------------------------------------
        if (!isset($produto->nomeProduto) || trim((string) $produto->nomeProduto) === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O campo 'nomeCliente' é obrigatório!"
                ]
            );
        }

        $request->getBody()->rewind();
        return $handler->handle($request);
    }
}