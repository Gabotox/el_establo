<?php

require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';

$id = isset($_GET['id']) ? $_GET['id'] : '';
$codigo_activacion = isset($_GET['codigo_activacion']) ? $_GET['codigo_activacion'] : '';

if ($id == '' || $codigo_activacion == '') {
    header("location: ../index.php");
    exit; // Agrega esta línea para detener la ejecución del script si faltan parámetros
}

$db = new database();
$con = $db->conectar();

// Guarda el mensaje de activación de la cuenta en una variable
$msg = ValidarCodigo($id, $codigo_activacion, $con);

// Imprime el mensaje en la página
echo $msg;

?>
