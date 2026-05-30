<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\RestauranteController;
use Api\Middlewares\Restaurantes\ValidateRestaurantesBody;
use Api\Middlewares\Restaurantes\ValidateRestaurantesId;


class RestaurantesRouter
{

    private App $app;


    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function setupRoutes(): void
    {

        $this->app->post(
            '/restaurante',
            [RestauranteController::class, 'createController']
        )
            ->add(ValidateRestaurantesBody::class);

        $this->app->get(
            '/restaurante',
            [RestauranteController::class, 'findAllController']
        );

        $this->app->get(
            '/restaurante/count',
            [RestauranteController::class, 'countController']
        );

        $this->app->get(
            '/restaurante/{idRestaurante}',
            [RestauranteController::class, 'findByIdController']
        )
            ->add(ValidateRestaurantesId::class);


        $this->app->put(
            '/restaurante/{idRestaurante}',
            [RestauranteController::class, 'updateController']
        )
            ->add(ValidateRestaurantesBody::class)
            ->add(ValidateRestaurantesId::class);

        $this->app->delete(
            '/restaurante/{idRestaurante}',
            [RestauranteController::class, 'deleteController']
        )
            ->add(ValidateRestaurantesId::class);
    }
}