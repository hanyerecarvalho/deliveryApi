<?php

namespace Api\Routes;

use Slim\App;
use Api\Controllers\ClienteController;
use Api\Middlewares\cliente\ValidateClienteBody;
use Api\Middlewares\cliente\ValidateClienteId;

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
class ClienteRouter
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
            '/clientes',
            [ClienteController::class, 'createController']
        )
            ->add(ValidateClienteBody::class);

        /**
         * =========================================================
         * GET /cargos
         * =========================================================
         * Lista todos os cargos.
         *
         * Ordem de execução:
         * 1. CargoController::findAllController
         */
        $this->app->get(
            '/clientes',
            [ClienteController::class, 'findAllController']
        );
        

        /**
         * =========================================================
         * GET /cargos/count
         * =========================================================
         * Retorna a quantidade total de cargos.
         *
         * Ordem de execução:
         * 1. CargoController::countController
         */
        $this->app->get(
            '/clientes/count',
            [ClienteController::class, 'countController']
        );

        /**
         * =========================================================
         * GET /cargos/{idCargo}
         * =========================================================
         * Busca um cargo pelo ID.
         *
         * Ordem de execução:
         * 1. ValidateCargoId
         * 2. CargoController::findByIdController
         */
        $this->app->get(
            '/clientes/{idCliente}',
            [ClienteController::class, 'findByIdController']
        )
            ->add(ValidateClienteId::class);

        /**
         * =========================================================
         * PUT /cargos/{idCargo}
         * =========================================================
         * Atualiza um cargo existente.
         *
         * Body:
         * {
         *   "cargo": {
         *     "nomeCargo": "teste"
         *   }
         * }
         *
         * Ordem de execução:
         * 1. ValidateCargoId
         * 2. ValidateCargoBody
         * 3. CargoController::updateController
         */
        $this->app->put(
            '/clientes/{idCliente}',
            [ClienteController::class, 'updateController']
        )
            ->add(ValidateClienteBody::class)
            ->add(ValidateClienteId::class);

        /**
         * =========================================================
         * DELETE /cargos/{idCargo}
         * =========================================================
         * Remove um cargo pelo ID.
         *
         * Ordem de execução:
         * 1. ValidateCargoId
         * 2. CargoController::deleteController
         */
        $this->app->delete(
            '/clientes/{idCliente}',
            [ClienteController::class, 'deleteController']
        )
            ->add(ValidateClienteId::class);
    }
}