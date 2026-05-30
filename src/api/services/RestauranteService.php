<?php

namespace Api\Services;

use Api\Models\Restaurantes;
use Api\DAO\RestauranteDAO;
use Api\Http\ErrorResponse;
use stdClass;

class RestauranteService
{
    private RestauranteDAO $restauranteDAO;

    public function __construct(RestauranteDAO $restauranteDAODependency)
    {
        error_log("⬆️ RestauranteService::__construct()");
        $this->restauranteDAO = $restauranteDAODependency;
    }

    public function createService(stdClass $objPHP): Restaurantes
    {
        error_log("🟣 RestauranteService::createService()");

        $idRestaurante = new Restaurantes();
        $idRestaurante->setIdRestaurante($objPHP->Restaurantes->idRestaurante);
        $idRestaurante->setNomeRestaurante($objPHP->Restaurantes->nomeRestaurante);
        $idRestaurante->setTelefoneRestaurante($objPHP->Restaurantes->telefoneRestaurante);
        $idRestaurante->setEnderecoRestaurante($objPHP->Restaurantes->enderecoRestaurante);

        
        $resultado = $this->restauranteDAO->findByField(
            'idRestaurante', $idRestaurante->getIdRestaurante()
        );

        if (count($resultado) > 0) {
            throw new ErrorResponse(
                400,
                "Restaurante já existe",
                [
                    "message" =>
                        "O restaurante {$idRestaurante->getIdRestaurante()} já existe"
                ]
            );
        }
        if (empty($objPHP->Restaurantes->enderecoRestaurante)) {
            throw new ErrorResponse(400, "enderecoRestaurante nao pode ser vazio", []);
        }

        return $this->restauranteDAO->create($idRestaurante);
    }

    
    public function countService(): int
    {
        error_log("🟣 RestauranteService::countService()");
        return $this->restauranteDAO->count();
    }

    public function findAllService(): array
    {
        error_log("🟣 RestauranteService::findAllService()");
        return $this->restauranteDAO->findAll();
    }
    public function findByIdService(int $idRestaurante): ?Restaurantes
    {
        error_log("🟣 RestauranteService::findByIdService()");
        return $this->restauranteDAO->findById($idRestaurante);
    }

    public function updateService(int $idRestaurante, string $nomeRestaurante, string $telefoneRestaurante, string $enderecoRestaurante): bool
    {
        error_log("🟣 RestauranteService::updateService()");


        $restauranteExiste = $this->restauranteDAO->findById($idRestaurante);

        if (!$restauranteExiste) {
            throw new ErrorResponse(
                404,
                "Restaurante não encontrado",
                [
                    "message" =>
                        "Não existe Restaurante com id {$idRestaurante}"
                ]
            );
        }

        $Restaurante = new Restaurantes();
        $Restaurante->setIdRestaurante($idRestaurante);
        $Restaurante->setNomeRestaurante($nomeRestaurante);
        $Restaurante->setTelefoneRestaurante($telefoneRestaurante);
        $Restaurante->setEnderecoRestaurante($enderecoRestaurante);

        return $this->restauranteDAO->update($Restaurante);
    }

    public function deleteService(int $idRestaurante): bool
    {
        error_log("🟣 RestauranteService::deleteService()");

        $restauranteExiste = $this->restauranteDAO->findById($idRestaurante);

        if (!$restauranteExiste) {
            throw new ErrorResponse(
                404,
                "Restaurante não encontrado",
                [
                    "message" =>
                        "Não existe Restaurante com id {$idRestaurante}"
                ]
            );
        }

        /**
         * Monta objeto para exclusão.
         */
        $Restaurante = new Restaurantes();
        $Restaurante->setIdRestaurante($idRestaurante);

        return $this->restauranteDAO->delete($Restaurante);
    }
}