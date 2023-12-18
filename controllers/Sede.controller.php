<?php
    require_once "../models/Sede.php";

    if(isset($_GET['Solicitud'])){
        $sede = new Sede();

        if($_GET['Solicitud']=='listar')
        {
            $resultado = $sede->getAll();
            echo json_encode($resultado);
        }
    }