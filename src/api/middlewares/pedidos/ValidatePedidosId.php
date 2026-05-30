<?php

namespace Api\Middlewares\Pedidos;

use Psr\Http\Message\ServerRequestInterface as Request;   
use Psr\Http\Message\ResponseInterface as Response;    
use Psr\Http\Server\RequestHandlerInterface as RequestHandler; 
use Psr\Http\Server\MiddlewareInterface;               
use Slim\Routing\RouteContext;                          
use Api\Http\ErrorResponse;                            


class ValidatePedidosId implements MiddlewareInterface
{

    public function process(Request $request, RequestHandler $handler): Response
    {
        $routeContext = RouteContext::fromRequest($request);

 
        $route = $routeContext->getRoute();


 
        $routeArgs = $route->getArguments();


        if (!isset($routeArgs['idPedido']) || $routeArgs['idPedido'] === "") {
            throw new ErrorResponse(
                httpCode: 400,
                message: "Erro na validação de dados",
                error: [
                    "message" => "O parâmetro 'idPedido' é obrigatório!" 
                ]
            );
        }

        return $handler->handle(request: $request);
    }
}
