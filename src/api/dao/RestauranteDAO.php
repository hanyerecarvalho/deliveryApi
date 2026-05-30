<?php

namespace Api\DAO;

use Api\Models\Restaurantes;
use Api\Database\MysqlDatabase;
use Exception;

class RestauranteDAO
{
    private MysqlDatabase $database;
    public function __construct(MysqlDatabase $databaseInstance)
    {
        $this->database = $databaseInstance;

        error_log("⬆️ RestauranteDAO::__construct()");
    }

    
    public function create(Restaurantes $objRestaurante): Restaurantes
    {
        error_log("🟢 RestauranteDAO::create()");

        $sql = "
            INSERT INTO restaurantes (nomeRestaurante, telefoneRestaurante, enderecoRestaurante)
            VALUES (:nomeRestaurante, :telefoneRestaurante, :enderecoRestaurante)
        ";

 
         $parametros = [
            ':nomeRestaurante' => $objRestaurante->getNomeRestaurante(),
            ':telefoneRestaurante' => $objRestaurante->getTelefoneRestaurante(),
            ':enderecoRestaurante' => $objRestaurante->getEnderecoRestaurante()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);

        if (!$stmt->execute($parametros)) {
            throw new Exception("Erro ao cadastrar o restaurante.");
        }

        $novoID = (int) $this->database->getConnection()->lastInsertId();
        $objRestaurante->setIdRestaurante($novoID);
        return $objRestaurante;
    }

    public function delete(Restaurantes $objRestauranteModel): bool
    {
        error_log("🟢 RestauranteDAO::delete()");


        $sql = "
            DELETE FROM restaurantes
            WHERE idRestaurante = :idRestaurante
        ";


        $parametros = [
            ':idRestaurante' => $objRestauranteModel->getIdRestaurante()
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);

        return $stmt->rowCount() > 0;
    }

   
    public function update(Restaurantes $objRestauranteModel): bool
    {
        error_log("🟢 RestauranteDAO::update()");


        $sql = "UPDATE restaurantes SET 
            nomeRestaurante = :nomeRestaurante,
            telefoneRestaurante = :telefoneRestaurante,
            enderecoRestaurante = :enderecoRestaurante
            WHERE idRestaurante = :idRestaurante";

        $parametros = [
            ':nomeRestaurante' => $objRestauranteModel->getNomeRestaurante(),
            ':telefoneRestaurante' => $objRestauranteModel->getTelefoneRestaurante(),
            ':enderecoRestaurante' => $objRestauranteModel->getEnderecoRestaurante(),
            ':idRestaurante' => $objRestauranteModel->getIdRestaurante() 
        ];


        $stmt = $this->database->getConnection()->prepare($sql);
        $stmt->execute($parametros);


        return $stmt->rowCount() > 0;
    }

    
    public function findAll(): array
    {
        error_log("🟢 RestauranteDAO::findAll()");

        $sql = "SELECT * FROM restaurantes";
        $stmt = $this->database->getConnection()->query($sql);
        $matrizArrays = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $Restaurantes = [];
      
        foreach ($matrizArrays as $linhaMatriz) {
            $Restaurante = new Restaurantes();

            $Restaurante->setIdRestaurante((int) $linhaMatriz['idRestaurante']);
            $Restaurante->setNomeRestaurante($linhaMatriz['nomeRestaurante']);
            $Restaurante->setTelefoneRestaurante($linhaMatriz['telefoneRestaurante']);
            $Restaurante->setEnderecoRestaurante($linhaMatriz['enderecoRestaurante']);

            $Restaurantes[] = $Restaurante;
        }
        return $Restaurantes;
    }

    public function count(): int
    {
        error_log("🟢 RestauranteDAO::count()");


        $sql = "SELECT COUNT(*) AS qtd FROM restaurantes";

 
        $stmt = $this->database->getConnection()->query($sql);

  
        $linhaMatriz = $stmt->fetch(\PDO::FETCH_ASSOC);


        return (int) $linhaMatriz['qtd'];
    }

    public function findById(int $idRestaurante): ?Restaurantes
    {
        error_log("🟢 RestauranteDAO::findById()");


        $resultado = $this->findByField('idRestaurante', $idRestaurante);

        if (!empty($resultado)) {
            return $resultado[0];
        }

        return null;
    }

    public function findByField(string $field, $value): array
    {
        error_log("🟢 RestauranteDAO::findByField()");


        $camposPermitidos = [
            'idRestaurante',
            'nomeRestaurante',
            'telefoneRestaurante',
            'enderecoRestaurante'
        ];


        if (!in_array($field, $camposPermitidos)) {
            throw new Exception("Campo inválido.");
        }

        /**
         * SQL dinâmica segura.
         */
        $sql = "SELECT * FROM restaurantes WHERE $field = :value";

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

        
        $Restaurantes = [];

        /**
         * Converte linhas em objetos.
         */
        foreach ($matrizArrays as $linhaMatriz) {
            $Restaurante = new Restaurantes();

            $Restaurante->setIdRestaurante((int) $linhaMatriz['idRestaurante']);
            $Restaurante->setNomeRestaurante($linhaMatriz['nomeRestaurante']);
            $Restaurante->setTelefoneRestaurante($linhaMatriz['telefoneRestaurante']);
            $Restaurante->setEnderecoRestaurante($linhaMatriz['enderecoRestaurante']);

            $Restaurantes[] = $Restaurante;
        }

        
        return $Restaurantes;
    }
}