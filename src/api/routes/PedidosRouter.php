<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\PedidoController;
use Api\Middlewares\Pedidos\ValidatePedidosBody;
use Api\Middlewares\Pedidos\ValidatePedidosId;

class PedidosRouter
{

    private App $app;


    public function __construct(App $app)
    {
        $this->app = $app;
    }

   
    public function setupRoutes(): void
    {
      
        $this->app->post(
            '/pedidos',
            [PedidoController::class, 'createController']
        )
            ->add(ValidatePedidosBody::class);

 
        $this->app->get(
            '/pedidos',
            [PedidoController::class, 'findAllController']
        );


        $this->app->get(
            '/pedidos/count',
            [PedidoController::class, 'countController']
        );

        $this->app->get(
            '/pedidos/{idPedido}',
            [PedidoController::class, 'findByIdController']
        )
            ->add(ValidatePedidosId::class);


        $this->app->put(
            '/pedidos/{idPedido}',
            [PedidoController::class, 'updateController']
        )
            ->add(ValidatePedidosBody::class)
            ->add(ValidatePedidosId::class);


        $this->app->delete(
            '/pedidos/{idPedido}',
            [PedidoController::class, 'deleteController']
        )
            ->add(ValidatePedidosId::class);
    }
}