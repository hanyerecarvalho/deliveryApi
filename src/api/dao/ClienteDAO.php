<?php

namespace Api\DAO;

use Api\Models\Clientes;
use Api\Database\MysqlDatabase;
use Exception;

class ClienteDAO
{
    private MysqlDatabase $database;
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ ClienteDAO::__construct()");
    }

    
    public function create(Clientes $ojbCliente): Clientes
    {
        error_log("🟢 ClienteDAO::create()");


        $sql = "
            INSERT INTO clientes (nomeCliente, telefoneCliente)
            VALUES (:nomeCliente, :telefoneCliente)
        ";

        $parametros = [
            ':nomeCliente' => $ojbCliente->getNomeCliente(),
            ':telefoneCliente' => $ojbCliente->getTelefoneCliente()
        ];

  
        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar cliente.");
        }

        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $ojbCliente->setIdCliente($novoID);
        return $ojbCliente;
    }

    public function delete(Clientes $objClienteModel): bool
    {
        error_log("🟢 ClienteDAO::delete()");

        /**
         * SQL de exclusão.
         */
        $sql = "
            DELETE FROM clientes
            WHERE idCliente = :idCliente
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':idCliente' => $objClienteModel->getIdCliente()
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

    
    public function update(Clientes $objClienteModel): bool
    {
        error_log("🟢 ClienteDAO::update()");

        /**
         * SQL de atualização.
         */
        $sql = "
            UPDATE clientes
            SET nomeCliente = :nomeCliente,
            telefoneCliente = :telefoneCliente
            WHERE idCliente = :idCliente
        ";

        /**
         * Valores da query.
         */
        $parametros = [
            ':idCliente' => $objClienteModel->getIdCliente(),
            ':nomeCliente' => $objClienteModel->getNomeCliente(),
            ':telefoneCliente' => $objClienteModel->getTelefoneCliente()            
        ];

        /**
         * Executa atualização.
         */
        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        /**
         * True se alterou registro.
         */
        return $stmt->rowCount() > 0;
    }

    /**
     * Retorna todos os cargos cadastrados.
     *
     * @return array
     */
    public function findAll(): array
    {
        error_log("🟢 ClienteDAO::findAll()");

        $sql = "SELECT * FROM clientes";
        $stmt = $this->database->getConnection()->query($sql);
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $clientes = [];
      
        foreach ($matrizArrays as $linhaMatriz) {
            $cliente = new Clientes();

            $cliente->setIdCliente((int) $linhaMatriz['idCliente']);
            $cliente->setNomeCliente($linhaMatriz['nomeCliente']);
            $cliente->setTelefoneCliente($linhaMatriz['telefoneCliente']);

            $clientes[] = $cliente;
        }
        return $clientes;
    }

    public function count(): int
    {
        error_log("🟢 ClienteDAO::count()");

        /**
         * SQL de contagem.
         */
        $sql = "SELECT COUNT(*) AS qtd FROM clientes";

        /**
         * Executa consulta.
         */
        $stmt = $this->database->getConnection()->query($sql);

        /**
         * Resultado único.
         */
        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);

        /**
         * Retorna total.
         */
        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $idCliente): ?Clientes
    {
        error_log("🟢 ClienteDAO::findById()");

        /**
         * Busca reutilizando método genérico.
         */
        $resultado = $this->findByField('idCliente', $idCliente);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 ClienteDAO::findByField()");

        /**
         * Campos permitidos.
         */
        $camposPermitidos = [
            'idCliente',
            'nomeCliente',
            'telefoneCliente'
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
        $sql = "SELECT * FROM clientes WHERE $field = :value";

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

        /**
         * Lista final de objetos Cargo.
         */
        $clientes = [];

        /**
         * Converte linhas em objetos.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $cliente = new Clientes();

            $cliente->setIdCliente((int) $linhaMatriz['idCliente']);
            $cliente->setNomeCliente($linhaMatriz['nomeCliente']);
            $cliente->setTelefoneCliente($linhaMatriz['telefoneCliente']);

            $clientes[] = $cliente;
        }

        /**
         * Retorna lista.
         */
        return $clientes;
    }
}