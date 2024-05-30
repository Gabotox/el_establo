<?php

require '../config/config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if (isset($_SESSION['carrito']['productos'][$id])) {
        $_SESSION['carrito']['productos'][$id] += 1;
    } else {
        $_SESSION['carrito']['productos'][$id] = 1;
    }

    $num = count($_SESSION['carrito']['productos']);
    $_SESSION['num'] = $num;

    $datos['numero'] = $num;
    $datos['ok'] = true;
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);
?>