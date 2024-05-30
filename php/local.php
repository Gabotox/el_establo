<?php

require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';

$db = new database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {
    $nombre = $_POST['nombre'];
    $identificacion = $_POST['identificacion'];
    $telefono = $_POST['telefono'];
    $mesa = $_POST['mesa'];

    // Obtener la fecha actual en el formato 'Y-m-d H:i:s'
    $fecha_pedido = date('Y-m-d H:i:s');

    // Establecer la dirección, el barrio y el tipo de envío
    $direccion = "El Establo";
    $barrio = "Villa Mady";
    $tipo_envio = "Local";

    // Validar que los campos no estén vacíos
    if (EsNulo([$nombre, $identificacion, $telefono, $mesa])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        // Realizar la inserción en la base de datos
        $id_cliente = $_SESSION['user_cliente']; // Obtener el id_cliente de la sesión

        // Obtener el correo electrónico del cliente
        $sql = $con->prepare("SELECT email FROM clientes WHERE id = ?");
        $sql->execute([$id_cliente]);
        $cliente = $sql->fetch(PDO::FETCH_ASSOC);
        $email = $cliente['email'];

        // Estado del pedido
        $estado_pedido = "Pendiente de Pago";

        // Realizar la inserción en la base de datos
        $sql_insert_pedido = $con->prepare("INSERT INTO pedidos (id_cliente, nombre, identificacion, telefono, mesa, direccion, barrio, tipo_envio, fecha_pedido, estado_pedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $sql_insert_pedido->execute([$id_cliente, $nombre, $identificacion, $telefono, $mesa, $direccion, $barrio, $tipo_envio, $fecha_pedido, $estado_pedido]);

        // Verificar si la consulta se ejecutó correctamente
        if ($sql_insert_pedido) {
            // Almacenar el ID del pedido en una variable de sesión
            $_SESSION['id_pedido'] = $con->lastInsertId();

            // Enviar correo electrónico de confirmación del pedido
            require 'Mailer.php';

            $asunto = 'Confirmacion de pedido local';
            $cuerpo = '<h3>¡Gracias por su pedido!</h3>';
            $cuerpo .= '<p>Hemos recibido su pedido en el restaurante y lo estamos procesando.</p>';
            $cuerpo .= '<p>Detalles del pedido:</p>';
            $cuerpo .= '<ul>';
            $cuerpo .= '<li>ID del Pedido: <b>' . $id_pedido . '</b></li>';
            $cuerpo .= '<li>Nombre: <b>' . $nombre . '</b></li>';
            $cuerpo .= '<li>Identificación: <b>' . $identificacion . '</b></li>';
            $cuerpo .= '<li>Teléfono: <b>' . $telefono . '</b></li>';
            $cuerpo .= '<li>Mesa: <b>' . $mesa . '</b></li>';
            $cuerpo .= '<li>Tipo de envío: <b>' . $tipo_envio . '</b></li>';
            $cuerpo .= '<li>Fecha del pedido: <b>' . $fecha_pedido . '</b></li>';
            $cuerpo .= '<li>Estado del pedido: <b>' . $estado_pedido . '</b></li>';
            $cuerpo .= '</ul>';

            // Envío del correo electrónico
            $Mailer = new Mailer();
            $correo_enviado = $Mailer->enviarEmail($email, $asunto, $cuerpo);

            // Redirigir a otra página
            header("Location: pago.php");
            exit();
        } else {
            $errors[] = "Error al procesar el pedido. Por favor, inténtelo de nuevo más tarde.";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de compra</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <?php include 'Menu.php' ?>
</header>

<main>
    <h2>Formulario de compra</h2>

    <?php MostrarMensajes($errors); ?>

    <form action="local.php" method="post" autocomplete="off">

        <div class="">
            <label for="nombre">Nombres</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="">
            <label for="identificacion">Identificación</label>
            <input type="number" name="identificacion" id="identificacion" required>
        </div>

        <div class="">
            <label for="telefono">Teléfono</label>
            <input type="tel" name="telefono" id="telefono" required>
        </div>

        <div class="">
            <label for="mesa">Número de Mesa</label>
            <input type="number" name="mesa" id="mesa" required>
        </div>

        <div class="btn-form">
            <button type="submit">Enviar</button>
            <button type="reset">Limpiar</button>
        </div>

    </form>
</main>

</body>
</html>
