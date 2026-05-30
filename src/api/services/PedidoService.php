<?php

namespace Api\Services;

use Api\Models\Pedidos;
use Api\DAO\PedidosDAO;
use Api\Http\ErrorResponse;
use stdClass;

class PedidoService
{
    private PedidosDAO $pedidosDAO;

    public function __construct(PedidosDAO $pedidosDAODependency)
    {
        error_log("⬆️ PedidoService::__construct()");
        $this->pedidosDAO = $pedidosDAODependency;
    }

    public function createService(stdClass $objPHP): Pedidos
    {
        error_log("🟣 PedidoService::createService()");

        $pedido = new Pedidos();
        
        $pedido->setValorTotal($objPHP->pedidos->valorTotal);
        $pedido->setIdCliente($objPHP->pedidos->idCliente);
        $pedido->setIdRestaurante($objPHP->pedidos->idRestaurante);

        return $this->pedidosDAO->create($pedido);
    }

    
    public function countService(): int
    {
        error_log("🟣 PedidoService::countService()");
        return $this->pedidosDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 PedidoService::findAllService()");
        return $this->pedidosDAO->findAll();
    }

    public function findByIdService(int $idPedido): ?Pedidos
    {
        error_log("🟣 PedidoService::findByIdService()");

        $Pedido = new Pedidos();
        $Pedido->setIdPedido($idPedido);

        return $this->pedidosDAO->findById($Pedido->getIdPedidos());
    }

    
    public function updateService(int $idPedido, float $valorTotal, int $idCliente, int $idRestaurante): bool
    {
        error_log("🟣 PedidoService::updateService()");

        $pedidoExiste = $this->pedidosDAO->findById($idPedido);

        if (!$pedidoExiste) {
            throw new ErrorResponse(
                404,
                "Pedido não encontrado",
                [
                    "message" =>
                        "Não existe pedido com id {$idPedido}"
                ]
            );
        }

   
        $Pedido = new Pedidos();
        $Pedido->setIdPedido($idPedido);
        $Pedido->setValorTotal($valorTotal);
        $Pedido->setIdCliente($idCliente);
        $Pedido->setIdRestaurante($idRestaurante);

        return $this->pedidosDAO->update($Pedido);
    }


    public function deleteService(int $idPedido): bool
    {
        error_log("🟣 PedidoService::deleteService()");


        $pedidoExiste = $this->pedidosDAO->findById($idPedido);

        if (!$pedidoExiste) {
            throw new ErrorResponse(
                404,
                "Pedido não encontrado",
                [
                    "message" =>
                        "Não existe Pedido com id {$idPedido}"
                ]
            );
        }

        /**
         * Monta objeto para exclusão.
         */
        $Pedido = new Pedidos();
        $Pedido->setIdPedido($idPedido);

        return $this->pedidosDAO->delete($Pedido);
    }
}