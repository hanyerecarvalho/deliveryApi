<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\ItemPedidoController;
use Api\Middlewares\ItensPedidos\ValidateItensPedidoBody;
use Api\Middlewares\ItensPedidos\ValidateItensPedidoId;

/**
 * Classe responsável por registrar as rotas do recurso Cargo.
 *
 * Endpoints disponíveis:
 * - POST   /cargos
 * - GET    /cargos
 * - GET    /cargos/count
 * - GET    /cargos/{idCargo}
 * - PUT    /cargos/{idCargo}
 * - DELETE /cargos/{idCargo}
 */
class ItensPedidoRouter
{
    /**
     * Instância da aplicação Slim.
     *
     * @var App
     */
    private App $app;

    /**
     * Recebe a instância principal da aplicação.
     *
     * @param App $app Aplicação Slim.
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Registra todas as rotas relacionadas ao recurso Cargo.
     *
     * Estrutura esperada do JSON:
     *
     * {
     *   "cargo": {
     *     "nomeCargo": "teste"
     *   }
     * }
     *
     * IMPORTANTE:
     * No Slim Framework, os middlewares executam em ordem inversa
     * à ordem em que são adicionados com ->add().
     *
     * O último middleware adicionado executa primeiro.
     *
     * @return void
     */
    public function setupRoutes(): void
    {
        $this->app->post(
            '/itensPedidos',
            [ItemPedidoController::class, 'createController']
        )
            ->add(ValidateItensPedidoBody::class);

        $this->app->get(
            '/itensPedidos',
            [ItemPedidoController::class, 'findAllController']
        );

        $this->app->get(
            '/itensPedidos/count',
            [ItemPedidoController::class, 'countController']
        );

        $this->app->get(
            '/itensPedidos/{idItemPedido}',
            [ItemPedidoController::class, 'findByIdController']
        )
            ->add(ValidateItensPedidoId::class);

        $this->app->put(
            '/itensPedidos/{idItemPedido}',
            [ItemPedidoController::class, 'updateController']
        )
            ->add(ValidateItensPedidoBody::class)
            ->add(ValidateItensPedidoId::class);

        $this->app->delete(
            '/itensPedidos/{idItemPedido}',
            [ItemPedidoController::class, 'deleteController']
        )
            ->add(ValidateItensPedidoId::class);
    }
}