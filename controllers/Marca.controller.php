<?php
require_once '../models/Marca.php';

//1.Recibre solicitud
//2.Realiza proceso
//3.Entrega resultado


if (isset($_GET['operacion'])) {
    $marca = new Marca();

    if ($_GET['operacion'] == 'listar') {
        $resultado = $marca->getAll();
        echo json_encode($resultado);
    }
}
