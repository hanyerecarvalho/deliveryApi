<?php

namespace Api\DAO;

use Api\Models\ItensPedido;
use Api\Database\MysqlDatabase;
use Exception;

class ItensPedidoDAO
{
    private MysqlDatabase $database;
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ ItensPedidoDAO::__construct()");
    }

    
    public function create(ItensPedido $objItensPedido): ItensPedido
    {
        error_log("🟢 ItensPedidoDAO::create()");


        $sql = "
            INSERT INTO itens_pedidos (idItemPedido, quantidade, idPedido, idProduto)
            VALUES (:idItemPedido, :quantidade, :idPedido, :idProduto)
        ";

 
        $parametros = [
            ':idItemPedido' => $objItensPedido->getIdItemPedido(),
            ':quantidade' => $objItensPedido->getQuantidade(),
            ':idPedido' => $objItensPedido->getIdPedido(),
            'idProduto' => $objItensPedido->getIdProduto()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar os itens do pedido.");
        }

  
        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objItensPedido->setIdItemPedido($novoID);
        return $objItensPedido;
    }

    public function delete(ItensPedido $objItensPedidoModel): bool
    {
        error_log("🟢 ItensPedidoDAO::delete()");


        $sql = "
            DELETE FROM itens_pedidos
            WHERE idItemPedido = :idItemPedido
        ";
        

 
        $parametros = [
            ':idItemPedido' => $objItensPedidoModel->getIdItemPedido()
        ];;

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

    
    public function update(ItensPedido $objItensPedidoModel): bool
    {
        error_log("🟢 ItensPedidoDAO::update()");


        $sql = "
            UPDATE itens_pedidos
            SET quantidade = :quantidade,
            idPedido = :idPedido,
            idProduto = :idProduto
            WHERE idItemPedido = :idItemPedido
        ";


        $parametros = [
            ':quantidade' => $objItensPedidoModel->getQuantidade(),
            ':idPedido' => $objItensPedidoModel->getIdPedido(),
            ':idProduto' => $objItensPedidoModel->getIdProduto(),
            ':idItemPedido' => $objItensPedidoModel->getIdItemPedido() // ← estava faltando
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }


    public function findAll(): array
    {
        error_log("🟢 ItensPedidoDAO::findAll()");

        $sql = "SELECT * FROM itens_pedidos";
        $stmt = $this->database->getConnection()->query($sql);
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $itensPedido = [];
      
        foreach ($matrizArrays as $linhaMatriz) {
            $itemPedido = new ItensPedido();

            $itemPedido->setIdItemPedido((int) $linhaMatriz['idItemPedido']);
            $itemPedido->setIdPedido((int) $linhaMatriz['idPedido']);
            $itemPedido->setQuantidade($linhaMatriz['quantidade']);
            $itemPedido->setIdProduto((int) $linhaMatriz['idProduto']);

            $itensPedido[] = $itemPedido;
        }
        return $itensPedido;
    }

    public function count(): int
    {
        error_log("🟢 itensPedidoDAO::count()");

   
        $sql = "SELECT COUNT(*) AS qtd FROM itens_pedido";

 
        $stmt = $this->database->getConnection()->query($sql);

        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $idItemPedido): ?itensPedido
    {
        error_log("🟢 itensPedidoDAO::findById()");

  
        $resultado = $this->findByField('idItemPedido', $idItemPedido);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 itensPedidoDAO::findByField()");


        $camposPermitidos = [
            'idItemPedido',
            'quantidade',
            'idPedido',
            'idProduto'
        ];

  
        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }


        $sql = "SELECT * FROM itens_pedidos WHERE $field = :value";

        $stmt = $this->database->getConnection()->prepare($sql);


        $stmt->execute([
            ':value' => $value
        ]);

   
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $itensPedido = [];


        foreach ($matrizArrays as $linhaMatriz) {
            $itemPedido = new itensPedido();

            $itemPedido->setIdItemPedido((int) $linhaMatriz['idItemPedido']);
            $itemPedido->setQuantidade($linhaMatriz['quantidade']);
            $itemPedido->setIdPedido($linhaMatriz['idPedido']);
            $itemPedido->setIdProduto($linhaMatriz['idProduto']);

            $itensPedido[] = $itemPedido;
        }

        return $itensPedido;
    }
}