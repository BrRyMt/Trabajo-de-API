<?php
//include_once
//require_once
//require
//include

//Incorpora el archivo externo 1 sola  vez
//Si detecta un error, se detiene 
require_once '../models/Vehiculo.php';


//1. Recibira peticiones (GET - POST - REQUEST)

//2. Realizara el proceso (MODELO - CLASE)

//3. Devolver el resultador (JSON)


if (isset($_POST['operacion'])) {
    $vehiculo = new Vehiculo();

    if ($_POST['operacion'] == 'search') {

        //Instaciar la clase
        $respuesta =  $vehiculo->search(["placa" => $_POST['placa']]);

        sleep(2);
        echo json_encode($respuesta);
    }
    //Nuevo proceso
    if ($_POST['operacion'] == 'add') {

        //Alamacenar los datos recibiendo de la vista es un arreglo 
        $datosrecibidos = [
            "idmarca"           => $_POST["idmarca"],
            "modelo"            => $_POST["modelo"],
            "color"             => $_POST["color"],
            "tipocombustible"   => $_POST["tipocombustible"],
            "peso"              => $_POST["peso"],
            "afabricacion"      => $_POST["afabricacion"],
            "placa"             => $_POST["placa"]
        ];


        //Enviamos el arreglo como parametro del metodo add
        $idobtenido = $vehiculo->add($datosrecibidos);
        echo json_encode($idobtenido);
    }


}

    
if(isset($_GET['operacion'])){
    $vehiculo = new Vehiculo();

    if($_GET['operacion']=='getResumenTCombustible'){
        echo json_encode(($vehiculo->getResumenTCombustible()));
    }
}



//KEY= VALUE
