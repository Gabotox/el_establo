<?php

require_once '../config/conexion.php';
require_once 'funciones.php';


$datos=[];

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    $db = new database();
    $con = $db->conectar();
    
    if ($action=="existeUsuario") {
        
        $datos['ok']= UsuarioExiste($_POST['usuario'], $con);
      
    }elseif ($action = "existeEmail") {
        $datos['ok']= EmailExiste($_POST['email'], $con);
    }
}

echo json_encode($datos);
?>