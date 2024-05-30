<?php
require '../config/config.php';
require '../config/conexion.php';

$db = new database();
$con = $db->conectar();

if(isset($_POST['pedido_id'])) {
    $pedido_id = $_POST['pedido_id'];

    // Consulta para obtener los detalles de la compra principal
    $sql_compra = "SELECT * FROM compra WHERE id_pedido = :pedido_id";
    $stmt_compra = $con->prepare($sql_compra);
    $stmt_compra->bindParam(':pedido_id', $pedido_id);
    $stmt_compra->execute();
    $compra = $stmt_compra->fetchAll(PDO::FETCH_ASSOC);

    // Consulta para obtener los detalles de la tabla detalle_compra
    $sql_detalles_compra = "SELECT * FROM detalle_compra WHERE id_compra IN (SELECT id FROM compra WHERE id_pedido = :pedido_id)";
    $stmt_detalles_compra = $con->prepare($sql_detalles_compra);
    $stmt_detalles_compra->bindParam(':pedido_id', $pedido_id);
    $stmt_detalles_compra->execute();
    $detalles_compra = $stmt_detalles_compra->fetchAll(PDO::FETCH_ASSOC);

    // Combinar los datos de la compra principal con los detalles de compra
    $compra_con_detalles = array();
    foreach ($compra as $c) {
        $detalles = array();
        foreach ($detalles_compra as $detalle) {
            if ($c['id'] === $detalle['id_compra']) {
                $detalles[] = $detalle;
            }
        }
        $c['detalles'] = $detalles;
        $compra_con_detalles[] = $c;
    }

    // Imprimir los datos con formato HTML
    echo "<div class='compra-container'>";
    foreach ($compra_con_detalles as $compra) {
        echo "<div class='compra'>";
        echo "<p><strong>ID de Compra:</strong> " . $compra['id'] . "</p>";
        echo "<p><strong>ID de Cliente:</strong> " . $compra['id_cliente'] . "</p>";
        echo "<p><strong>ID de Transacción:</strong> " . $compra['id_transaccion'] . "</p>";
        echo "<p><strong>Fecha:</strong> " . $compra['fecha'] . "</p>";
        echo "<p><strong>Status:</strong> " . $compra['status'] . "</p>";
        echo "<p><strong>Correo Electrónico:</strong> " . $compra['email'] . "</p>";
        echo "<p><strong>Detalles:</strong></p>";
        foreach ($compra['detalles'] as $detalle) {
            echo "<div class='detalle'>";
            echo "-----------------------------";
            echo "<p><strong>Producto:</strong> " . $detalle['nombre'] . "</p>";
            echo "<p><strong>Precio:</strong> $" . $detalle['precio'] . "</p>";
            echo "<p><strong>Cantidad:</strong> " . $detalle['cantidad'] . "</p>";
            echo "</div>"; // Fin del detalle
        }
        echo "</div>"; // Fin de la compra
    }
    echo "</div>"; // Fin del contenedor de compras
}
?>
