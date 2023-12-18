<?php
//1. Acceso al archivo 
require 'Conexion.php';

//2. Heredar sus atributos y metodos
class Vehiculo extends Conexion
{

  //Este objeto almacenara la conexion y se la dfacilitara a todos los metodos
   //3. Almacenar la conexion en el objeto 
  private $pdo;


  public function __CONSTRUCT()
  {
    $this->pdo = parent::getConexion();
  }
  //Data es un arreglo asociativio que contiene los valores
  //requeridos por el SPU para registro devehiculos
  public function add($data = [])
  {
    try {
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_registrar(?,?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idmarca'],
          $data['modelo'],
          $data['color'],
          $data['tipocombustible'],
          $data['peso'],
          $data['afabricacion'],
          $data['placa']
        )
      );
      //Actualizacion, ahora retirnamos el idvehiculos 
      return $consulta->fetch(PDO::FETCH_ASSOC);

    } catch (Exception $e) {

      die($e->getMessage());
    }
  }


  public function search($data = [])
  {
    try {
      //Procedimiento requiere el numero de placa
      $consulta = $this->pdo->prepare("CALL spu_vehiculos_buscar(?)");
      $consulta->execute(
        array($data['placa'])
      );
      //Devolver el registro encontrado
      //fetch()    : retorna la primera coincidencia
      //fetchAll() : retorna todas las conincidencias (n)
      //FETCH_ASSOC: define el resultado como un objeto
      return $consulta->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function getResumenTCombustible(){
    try {
      $consulta = $this->pdo->prepare("CALL spu_resumen_tpcombustible");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }
}

//Prueba - NO OLVIDES BORRAR ESTO
/*
$vehiculo = new Vehiculo();
$registro = $vehiculo->search(["placa"=>"ABC-111"]);

var_dump($registro);*/