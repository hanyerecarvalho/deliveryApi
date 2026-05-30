<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\ProdutosController;
use Api\Middlewares\Produtos\ValidateProdutosBody;
use Api\Middlewares\Produtos\ValidateProdutosId;

class ProdutosRouter
{

    private App $app;


    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function setupRoutes(): void
    {
 
        $this->app->post(
            '/produtos',
            [ProdutosController::class, 'createController']
        )
            ->add(ValidateProdutosBody::class);


        $this->app->get(
            '/produtos',
            [ProdutosController::class, 'findAllController']
        );


        $this->app->get(
            '/produtos/count',
            [ProdutosController::class, 'countController']
        );

 
        $this->app->get(
            '/produtos/{idProduto}',
            [ProdutosController::class, 'findByIdController']
        )
            ->add(ValidateProdutosId::class);

        $this->app->put(
            '/produtos/{idProduto}',
            [ProdutosController::class, 'updateController']
        )
            ->add(ValidateProdutosBody::class)
            ->add(ValidateProdutosId::class);

        $this->app->delete(
            '/produtos/{idProduto}',
            [ProdutosController::class, 'deleteController']
        )
            ->add(ValidateProdutosId::class);
    }
}