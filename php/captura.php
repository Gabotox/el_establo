<?php
require '../config/config.php';
require '../config/conexion.php';
$db = new database();
$con = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json, true);
if (is_array($datos)) {
    $id_cliente = $_SESSION['user_cliente'];
    $sql = $con->prepare("SELECT email FROM clientes WHERE id=?");
    $sql->execute([$id_cliente]);
    $row_cliente = $sql->fetch(PDO::FETCH_ASSOC);

    $id_transaccion = $datos['detalles']['id'];
    $total = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $total2 = $total * 0.0026;
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $nueva_fecha = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $row_cliente['email'];

    $sql = $con->prepare("INSERT INTO compra (id_pedido, id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->execute([$_SESSION['id_pedido'], $id_transaccion, $nueva_fecha, $status, $email, $id_cliente, $total2]);
    $id = $con->lastInsertId();

    if ($id > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
        if ($productos != null) {
            $total_puntos = 0;
    
            $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad, id_cliente) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($productos as $clave => $cantidad) {
                $sql = $con->prepare("SELECT id, Nombre, Precio FROM productos WHERE id=?");
                $sql->execute([$clave]);
                $row_producto = $sql->fetch(PDO::FETCH_ASSOC);
                $precio = $row_producto['Precio'];
                $subtotal = $precio * $cantidad;
            
                $sql_insert->execute([$id, $clave, $row_producto['Nombre'], $subtotal, $cantidad, $id_cliente]);
            }

            // Actualizar el total en la tabla pedidos
            if(isset($_SESSION['id_pedido'])) {
                $id_pedido = $_SESSION['id_pedido'];
                $nuevo_estado = "pendiente";
                $sql_actualizar_total = $con->prepare("UPDATE pedidos SET estado_pedido = ?, total = ? WHERE id = ?");
                $sql_actualizar_total->execute([$nuevo_estado,$total2, $id_pedido]);
            }

            // Envía el correo electrónico de confirmación de la compra
            require 'Mailer.php';

// Asunto y cuerpo del correo electrónico
$asunto = 'Detalle de su compra';
$cuerpo = '<h3>¡Gracias por su compra!</h3>';
$cuerpo .= '<p>Hemos recibido su pago y su pedido está siendo procesado.</p>';
$cuerpo .= '<p>El ID de su compra es <b>' . $id_transaccion . '</b>.</p>';
$cuerpo .= '<p>Estado del pedido: <b>Pendiente</b></p>';
$cuerpo .= '<p>Se le estará informando sobre el estado de su compra.</p>';

// Detalles de la transacción
$cuerpo .= '<h4>Detalles de la transacción:</h4>';
$cuerpo .= '<p>ID de la transacción: <b>' . $id_transaccion . '</b></p>';
$cuerpo .= '<p>Fecha de la transacción: <b>' . $nueva_fecha . '</b></p>';
$cuerpo .= '<p>Estado de la transacción: <b>' . $status . '</b></p>';

// Detalles de los productos
$cuerpo .= '<h4>Detalles de los productos:</h4>';
foreach ($productos as $producto_id => $cantidad) {
    $sql_producto = $con->prepare("SELECT Nombre, Precio FROM productos WHERE id = ?");
    $sql_producto->execute([$producto_id]);
    $producto = $sql_producto->fetch(PDO::FETCH_ASSOC);
    $cuerpo .= '<p>Producto: <b>' . $producto['Nombre'] . '</b>, Precio: <b>$' . $producto['Precio'] . '</b>, Cantidad: <b>' . $cantidad . '</b></p>';
}

// Envío del correo electrónico
$Mailer = new Mailer();
$Mailer->enviarEmail($email, $asunto, $cuerpo);
        }
    }
    unset($_SESSION['carrito']);
}
?>
