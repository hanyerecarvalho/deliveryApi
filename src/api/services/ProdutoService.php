<?php

namespace Api\Services;

use Api\Models\Produtos;
use Api\DAO\ProdutosDAO;
use Api\Http\ErrorResponse;
use stdClass;

class ProdutoService
{
    private ProdutosDAO $produtosDAO;

    public function __construct(ProdutosDAO $produtosDAODependency)
    {
        error_log("⬆️ ProdutoService::__construct()");
        $this->produtosDAO = $produtosDAODependency;
    }

    public function createService(stdClass $objPHP): Produtos
    {
        error_log("🟣 ProdutoService::createService()");

        $idProduto = new Produtos();
        $idProduto->setIdProduto($objPHP->Produtos->idProduto);
        $idProduto->setIdRestaurante($objPHP->Produtos->idRestaurante);
        $idProduto->setNomeProduto($objPHP->Produtos->nomeProduto);
        $idProduto->setValorProduto($objPHP->Produtos->valorProduto);

        
        $resultado = $this->produtosDAO->findByField(
            'idProduto', $idProduto->getIdProduto()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Produto já existe",
                [
                    "message" =>
                        "O produto {$idProduto->getIdProduto()} já existe"
                ]
            );
        }

        return $this->produtosDAO->create($idProduto);
    }

    
    public function countService(): int
    {
        error_log("🟣 ProdutoService::countService()");
        return $this->produtosDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 ProdutoService::findAllService()");
        return $this->produtosDAO->findAll();
    }

    public function findByIdService(int $idProduto): ?Produtos
    {
        error_log("🟣 ProdutoService::findByIdService()");
        return $this->produtosDAO->findById($idProduto);
    }

    public function updateService(int $idRestaurante, int $idProduto, string $nomeProduto, float $valorProduto): bool
    {
        error_log("🟣 ProdutoService::updateService()");

        $produtoExiste = $this->produtosDAO->findById($idProduto);

        if (!$produtoExiste) {
            throw new ErrorResponse(
                404,
                "Produto não encontrado",
                [
                    "message" =>
                        "Não existe Produto com id {$idProduto}"
                ]
            );
        }


        $Produto = new Produtos();
        $Produto->setIdRestaurante($idRestaurante);
        $Produto->setIdProduto($idProduto);
        $Produto->setNomeProduto($nomeProduto);
        $Produto->setValorProduto($valorProduto);

        return $this->produtosDAO->update($Produto);
    }

   
    public function deleteService(int $idProduto): bool
    {
        error_log("🟣 ProdutoService::deleteService()");

 
        $produtoExiste = $this->produtosDAO->findById($idProduto);

        if (!$produtoExiste) {
            throw new ErrorResponse(
                404,
                "Produto não encontrado",
                [
                    "message" =>
                        "Não existe Produto com id {$idProduto}"
                ]
            );
        }

        /**
         * Monta objeto para exclusão.
         */
        $Produto = new Produtos();
        $Produto->setIdProduto($idProduto);

        return $this->produtosDAO->delete($Produto);
    }
}