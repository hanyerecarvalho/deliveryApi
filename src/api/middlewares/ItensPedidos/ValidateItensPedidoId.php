<?php

namespace Api\Middlewares\ItensPedidos;

use Psr\Http\Message\ServerRequestInterface as Request;   
use Psr\Http\Message\ResponseInterface as Response;     
use Psr\Http\Server\RequestHandlerInterface as RequestHandler; 
use Psr\Http\Server\MiddlewareInterface;               
use Slim\Routing\RouteContext;                         
use Api\Http\ErrorResponse;                             


class ValidateItensPedidoId implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        // Obtém o contexto da rota atual usando o objeto de requisição
        $routeContext = RouteContext::fromRequest($request);

        // Recupera a rota que está sendo chamada
        $route = $routeContext->getRoute();


        // Recupera os argumentos/parametros passados na rota (ex: /cargos/{idCargo})
        $routeArgs = $route->getArguments();

        // -----------------------------------------------------------
        // Validação 2: verificar se o parâmetro obrigatório 'idCargo' existe e não está vazio
        // -----------------------------------------------------------
        if (!isset($routeArgs['idItemPedido']) || $routeArgs['idItemPedido'] === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O parâmetro 'idItemPedido' é obrigatório!"  // Mensagem detalhada
                ]
            );
        }

        // -----------------------------------------------------------
        // Se todas as validações passaram, repassa a requisição para o próximo handler
        // Pode ser outro middleware ou o controller responsável pela rota
        // -----------------------------------------------------------
        return $handler->handle(request: $request);
    }
}
