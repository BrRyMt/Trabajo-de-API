<?php
require_once '../models/Empleado.php';


if (isset($_POST['operacion'])) {

    $empleado = new Empleado();

    if ($_POST['operacion'] == 'Registrar') {

        $datoregistrar = [

            "idsede"             => $_POST["idsede"],
            "apellidos"          => $_POST["apellidos"],
            "nombres"            => $_POST["nombres"],
            "nrodocumento"       => $_POST["nrodocumento"],
            "fechanac"           => $_POST["fechanac"],
            "telefono"           => $_POST["telefono"]

        ];

        $idobtenido = $empleado->AddEmp($datoregistrar);
        echo json_encode($idobtenido);
    }
    
    if ($_POST['operacion'] == 'searchEmp') {

        $respuesta =  $empleado->searchEmp(["nrodocumento" => $_POST['nrodocumento']]);

        sleep(2);
        echo json_encode($respuesta);
    }

    if($_POST['operacion'] == 'getAll'){

        $respuesta = $empleado->getAll();

        echo json_encode($respuesta);
    }

    if($_POST['operacion'] == 'GrupoSede'){

        $respuesta = $empleado->GrupoSede();

        echo json_encode($respuesta);
    }
}
