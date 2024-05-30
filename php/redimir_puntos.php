<?php
require '../config/config.php';
require '../config/conexion.php';

// Verificar si se envió el formulario de redimir puntos
if (isset($_POST['redimir_puntos'])) {
    // Obtener el ID del cliente de la sesión
    $cliente_id = $_SESSION['user_cliente'];

    // Obtener el total de puntos redimidos del cliente
    $puntos_redimidos = $_SESSION['user_cliente'];

    // Calcular el descuento basado en los puntos redimidos (supongamos 1 punto = $1)
    $descuento = $puntos_redimidos;

    // Restar el descuento del total de la compra
    $total = $_SESSION['carrito']['total'];
    $total -= $descuento;

    // Actualizar el total de la compra en la sesión
    $_SESSION['carrito']['total'] = $total;

    // Actualizar los puntos redimidos del cliente en la base de datos
    $sql_actualizar_puntos = $con->prepare("UPDATE clientes SET puntos_redimidos = 0 WHERE id = ?");
    $sql_actualizar_puntos->execute([$cliente_id]);

    // Redireccionar de vuelta a la página de pago
    header("Location: pago.php");
    exit;
}
?>