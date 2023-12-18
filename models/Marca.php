<?php
require_once "Conexion.php";

class Marca extends Conexion
{

    private $pdo;

    public function __CONSTRUCT()
    {
        $this->pdo = parent::getConexion();
    }

    public function getAll()
    {
        try {
            $consulta = $this->pdo->prepare("CALL spu_marcas_listar()");
            $consulta->execute();
            return $consulta->fetchALL(PDO::FETCH_ASSOC);
        } 
        catch (Exception $e) {
            die($e->getMessage());
        }
    }
}


