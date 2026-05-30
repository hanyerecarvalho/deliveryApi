<?php

namespace Api\DAO;

use Api\Models\Pedidos;
use Api\Database\MysqlDatabase;
use Exception;

class PedidosDAO
{
    private MysqlDatabase $database;
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ PedidoDAO::__construct()");
    }

    
    public function create(Pedidos $objPedido): Pedidos
    {
        error_log("🟢 PedidoDAO::create()");

        /**
         * SQL de inserção.
         */
        $sql = "
            INSERT INTO pedidos (valorTotal, idCliente, idRestaurante)
            VALUES (:valorTotal, :idCliente, :idRestaurante)
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':valorTotal' => $objPedido->getValorTotal(),
            ':idCliente' => $objPedido->getIdCliente(),
            'idRestaurante' => $objPedido->getIdRestaurante()
        ];

        /**
         * Prepara e executa.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar o pedido.");
        }

        /**
         * Retorna ID criado.
         */
        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objPedido->setIdPedido($novoID);
        return $objPedido;
    }

    public function delete(Pedidos $objPedidosModel): bool
    {
        error_log("🟢 PedidoDAO::delete()");

        /**
         * SQL de exclusão.
         */
        $sql = "
            DELETE FROM pedidos
            WHERE idPedido = :idPedido
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':idPedido' => $objPedidosModel->getIdPedidos()
        ];

        /**
         * Executa exclusão.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se removeu registro.
         */
        return $stmt->rowCount() > 0;
    }

   
    public function update(Pedidos $objPedidoModel): bool
    {
        error_log("🟢 PedidoDAO::update()");


        $sql = "
            UPDATE pedidos
            SET valorTotal = :valorTotal,
            idCliente = :idCliente,
            idRestaurante = :idRestaurante
            WHERE idPedido = :idPedido
        ";

        $parametros = [
            ':valorTotal' => $objPedidoModel->getValorTotal(),
            ':idCliente' => $objPedidoModel->getIdCliente(),
            ':idRestaurante' => $objPedidoModel->getIdRestaurante(),
            ':idPedido' => $objPedidoModel->getIdPedidos()
        ];

        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

  
        return $stmt->rowCount() > 0;
    }

   
    public function findAll(): array
    {
        error_log("🟢 PedidoDAO::findAll()");

        $sql = "SELECT * FROM pedidos";
        $stmt = $this->database->getConnection()->query($sql);
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $Pedidos = [];
      
        foreach ($matrizArrays as $linhaMatriz) {
            $Pedido = new Pedidos();

            $Pedido->setIdPedido((int) $linhaMatriz['idPedido']);
            $Pedido->setValorTotal($linhaMatriz['valorTotal']);
            $Pedido->setIdCliente((int) $linhaMatriz['idCliente']);
            $Pedido->setIdRestaurante((int) $linhaMatriz['idRestaurante']);

            $Pedidos[] = $Pedido;
        }
        return $Pedidos;
    }

    public function count(): int
    {
        error_log("🟢 PedidoDAO::count()");

   
        $sql = "SELECT COUNT(*) AS qtd FROM pedidos";

   
        $stmt = $this->database->getConnection()->query($sql);


        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $idPedido): ?Pedidos
    {
        error_log("🟢 PedidoDAO::findById()");

    
        $resultado = $this->findByField('idPedido', $idPedido);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 PedidoDAO::findByField()");

        /**
         * Campos permitidos.
         */
        $camposPermitidos = [
            'idPedido',
            'valorTotal',
            'idCliente',
            'idRestaurante'
        ];

        /**
         * Valida campo informado.
         */
        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        /**
         * SQL dinâmica segura.
         */
        $sql = "SELECT * FROM pedidos WHERE $field = :value";

        /**
         * Prepara consulta.
         */
        $stmt = $this->database->getConnection()->prepare($sql);

        /**
         * Executa busca.
         */
        $stmt->execute([
            ':value' => $value
        ]);

        /**
         * Matriz retornada.
         */
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        
        $Pedidos = [];

        /**
         * Converte linhas em objetos.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $Pedido = new Pedidos();

            $Pedido->setIdPedido((int) $linhaMatriz['idPedido']);
            $Pedido->setValorTotal($linhaMatriz['valorTotal']);
            $Pedido->setIdCliente((int) $linhaMatriz['idCliente']);
            $Pedido->setIdRestaurante((int) $linhaMatriz['idRestaurante']);

            $Pedidos[] = $Pedido;
        }

        
        return $Pedidos;
    }
}