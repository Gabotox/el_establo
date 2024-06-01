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
    <title>Formulario local</title>
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- SWIPER JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />



    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <nav class="navbar navbar-expand-lg pt-4">
        <div class="container-fluid px-5 py-0 cont_prin barr">
            <a class="navbar-brand" href="#">
                <img src="../assets/img/logo2.png" alt="" width="100px" id="logo">
            </a>

            <div class="row carrito_diseño">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

        </div>
    </nav>


    <div class="container-xl mt-5 log">
        <div class="login-container">
            <h2 class="mb-4">Formulario de envío local</h2>
            <form id="login-form" action="locall.php" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="username">Nombres</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="nombre" required placeholder="Ingrese nombre">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Identificación</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="tel" name="identificacion" id="telefono" required placeholder="# de identificación">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Teléfono</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="tel" name="telefono" id="telefono" required placeholder="# de teléfono">
                    </div>
                </div>

                <div class="form-group">
                    <label for="mesa">Número de Mesa</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="number" name="mesa" id="barrio" required placeholder="# de mesa">
                    </div>
                </div>

                <div class="accionLogin">
                    <button type="submit">Ir a pagar</button>
                    <button type="submit" style="background: red !important;">Cancelar</button>
                </div>
            </form>

        </div>
    </div>






</body>

</html>