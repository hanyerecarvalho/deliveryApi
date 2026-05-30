<?php

namespace Api\DAO;

use Api\Models\Produtos;
use Api\Database\MysqlDatabase;
use Exception;

class ProdutosDAO
{
    private MysqlDatabase $database;
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ ProdutosDAO::__construct()");
    }

    
    public function create(Produtos $objProduto): Produtos
    {
        error_log("🟢 ProdutosDAO::create()");

        /**
         * SQL de inserção.
         */
        $sql = "
            INSERT INTO produtos (nomeProduto, valorProduto, idRestaurante)
            VALUES (:nomeProduto, :valorProduto, :idRestaurante)
        ";

        /**
         * Valores da query.
         */
         $parametros = [
            ':nomeProduto' => $objProduto->getNomeProduto(),
            ':valorProduto' => $objProduto->getValorProduto(),
            ':idRestaurante' => $objProduto->getIdRestaurante()
        ];

        /**
         * Prepara e executa.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar o produto.");
        }

        /**
         * Retorna ID criado.
         */
        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objProduto->setIdProduto($novoID);
        return $objProduto;
    }

    public function delete(Produtos $objProdutosModel): bool
    {
        error_log("🟢 ProdutosDAO::delete()");

        $sql = "
            DELETE FROM produtos
            WHERE idProduto = :idProduto
        ";

        $parametros = [
            ':idProduto' => $objProdutosModel->getIdProduto()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

 
        return $stmt->rowCount() > 0;
    }

   
    public function update(Produtos $objProdutosModel): bool
    {
        error_log("🟢 ProdutosDAO::update()");

  
        $sql = "
            UPDATE produtos
            SET nomeProduto = :nomeProduto,
            valorProduto = :valorProduto,
            idRestaurante = :idRestaurante
            WHERE idProduto = :idProduto
        ";

        $parametros = [
            ':nomeProduto' => $objProdutosModel->getNomeProduto(),
            ':valorProduto' => $objProdutosModel->getValorProduto(),
            ':idRestaurante' => $objProdutosModel->getIdRestaurante(),
            ':idProduto' => $objProdutosModel->getIdProduto()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

    
    public function findAll(): array
    {
        error_log("🟢 ProdutosDAO::findAll()");

        $sql = "SELECT * FROM produtos";
        $stmt = $this->database->getConnection()->query($sql);
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $Produtos = [];
      
        foreach ($matrizArrays as $linhaMatriz) {
            $Produto = new Produtos();

            $Produto->setIdProduto((int) $linhaMatriz['idProduto']);
            $Produto->setNomeProduto($linhaMatriz['nomeProduto']);
            $Produto->setValorProduto($linhaMatriz['valorProduto']);
            $Produto->setIdRestaurante((int) $linhaMatriz['idRestaurante']);

            $Produtos[] = $Produto;
        }
        return $Produtos;
    }

    public function count(): int
    {
        error_log("🟢 ProdutoDAO::count()");

   
        $sql = "SELECT COUNT(*) AS qtd FROM produtos";

   
        $stmt = $this->database->getConnection()->query($sql);

  
        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

 
        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $idProduto): ?Produtos
    {
        error_log("🟢 ProdutoDAO::findById()");

        /**
         * Busca reutilizando método genérico.
         */
        $resultado = $this->findByField('idProduto', $idProduto);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 ProdutoDAO::findByField()");

  
        $camposPermitidos = [
            'idProduto',
            'nomeProduto',
            'valorProduto',
            'idRestaurante'
        ];


        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        $sql = "SELECT * FROM produtos WHERE $field = :value";


        $stmt = $this->database->getConnection()->prepare($sql);

 
        $stmt->execute([
            ':value' => $value
        ]);


        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        
        $Produtos = [];


        foreach ($matrizArrays as $linhaMatriz) {
            $Produto = new Produtos();

            $Produto->setIdProduto((int) $linhaMatriz['idProduto']);
            $Produto->setNomeProduto($linhaMatriz['nomeProduto']);
            $Produto->setValorProduto($linhaMatriz['valorProduto']);
            $Produto->setIdRestaurante((int) $linhaMatriz['idRestaurante']);

            $Produtos[] = $Produto;
        }

        
        return $Produtos;
    }
}