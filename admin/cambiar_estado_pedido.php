<?php
require '../config/config.php';
require '../config/conexion.php';

$db = new database();
$con = $db->conectar();

// Verificar si se recibieron los datos del pedido y el nuevo estado
if (isset($_POST['pedido_id']) && isset($_POST['nuevo_estado'])) {
    $pedidoId = $_POST['pedido_id'];
    $nuevoEstado = $_POST['nuevo_estado'];

    // Realizar la actualización del estado del pedido en la base de datos
    $db = new database();
    $con = $db->conectar();
    $sql_update_estado = $con->prepare("UPDATE pedidos SET estado_pedido = ? WHERE id = ?");
    $sql_update_estado->execute([$nuevoEstado, $pedidoId]);

    // Verificar si se actualizó correctamente el estado del pedido
    if ($sql_update_estado) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
