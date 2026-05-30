<?php

namespace Api\Services;

use Api\Models\ItensPedido;
use Api\DAO\ItensPedidoDAO;
use Api\DAO\PedidosDAO;
use Api\Http\ErrorResponse;
use stdClass;

class ItensPedidoService
{
    private ItensPedidoDAO $itensPedidoDAO;
    private PedidosDAO $pedidosDAO;

    public function __construct(ItensPedidoDAO $itensPedidoDAODependency, PedidosDAO $PedidosDAODependency)
    {
        error_log("⬆️ ItensPedidoService::__construct()");
        $this->itensPedidoDAO = $itensPedidoDAODependency;
        $this->pedidosDAO = $PedidosDAODependency;
    }

    public function createService(stdClass $objPHP): ItensPedido
{
    $item = new ItensPedido();
    $item->setIdItemPedido($objPHP->itensPedidos->idItemPedido);
    $item->setQuantidade($objPHP->itensPedidos->quantidade);
    $item->setIdPedido($objPHP->itensPedidos->idPedido);
    $item->setIdProduto($objPHP->itensPedidos->idProduto);

    $pedidoExiste = $this->pedidosDAO->findById($item->getIdPedido());

    if (!$pedidoExiste) {
        throw new ErrorResponse(
            404,
            "Pedido não encontrado",
            ["message" => "O pedido {$item->getIdPedido()} não existe"]
        );
    }

    $itemExiste = $this->itensPedidoDAO->findByField('idItemPedido', $item->getIdItemPedido());

    if (count($itemExiste) > 0) {
        throw new ErrorResponse(
            400,
            "Item já existe",
            ["message" => "O item {$item->getIdItemPedido()} já existe"]
        );
    }

    return $this->itensPedidoDAO->create($item);
}

    
    public function countService(): int
    {
        error_log("🟣 ItensPedidoService::countService()");
        return $this->itensPedidoDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 ItensPedidoService::findAllService()");
        return $this->itensPedidoDAO->findAll();
    }

    public function findByIdService(int $idItemPedido): ?ItensPedido
    {
    error_log("🟣 ItensPedidoService::findByIdService()");

    return $this->itensPedidoDAO->findById($idItemPedido);
    }

    public function updateService(int $idPedido, int $idProduto, int $quantidade, int $idItemPedido): bool
    {
        error_log("🟣 ItensPedidoService::updateService()");

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

        $Pedido = new ItensPedido();
        $Pedido->setIdPedido($idPedido);
        $Pedido->setIdItemPedido($idItemPedido);
        $Pedido->setQuantidade($quantidade);
        $Pedido->setIdProduto($idProduto);

        return $this->itensPedidoDAO->update($Pedido);
    }

    public function deleteService(int $idItemPedido): bool
    {
        $itemExiste = $this->itensPedidoDAO->findById($idItemPedido);

        if (!$itemExiste) {
            throw new ErrorResponse(
                404,
                "Item não encontrado",
                ["message" => "Não existe item com id {$idItemPedido}"]
            );
        }

        // ✅ Passa objeto, não int
        $item = new ItensPedido();
        $item->setIdItemPedido($idItemPedido);

        return $this->itensPedidoDAO->delete($item);
    }
    
}