<?php
require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';

$db = new database();
$con = $db->conectar();

$errors = [];


// Consulta el correo electrónico del cliente usando el ID



if (!empty($_POST)) {
    $nombre = $_POST['nombre'];
    $identificacion = $_POST['identificacion'];
    $direccion = $_POST['direccion'];
    $barrio = $_POST['barrio'];
    $telefono = $_POST['telefono'];

   
    // Validar que los campos no estén vacíos
    if (EsNulo([$nombre, $identificacion, $direccion, $barrio, $telefono])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        // Obtener la fecha y hora actual en el formato 'Y-m-d H:i:s'
        $fecha_pedido = date('Y-m-d H:i:s');

        // Establecer la dirección y el tipo de envío
        
        $tipo_envio = "Domicilio";
        $id_cliente = $_SESSION['user_cliente'];

        $sql = $con->prepare("SELECT email FROM clientes WHERE id = ?");
        $sql->execute([$id_cliente]);
        $cliente = $sql->fetch(PDO::FETCH_ASSOC);

        // Extraer el correo electrónico del array obtenido de la consulta
        $email = $cliente['email'];
        
        $estado_pedido = "Pendiente de Pago";

        // Realizar la inserción en la base de datos
        $sql_insert_pedido = $con->prepare("INSERT INTO pedidos (id_cliente, nombre, identificacion, direccion, barrio, telefono, tipo_envio, fecha_pedido) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $sql_insert_pedido->execute([$id_cliente, $nombre, $identificacion, $direccion, $barrio, $telefono, $tipo_envio, $fecha_pedido]);

        // Verificar si la consulta se ejecutó correctamente
        if ($sql_insert_pedido) {
            // Almacenar el ID del pedido en una variable de sesión
            $_SESSION['id_pedido'] = $con->lastInsertId();

            require 'Mailer.php';

            $asunto = 'Confirmacion de pedido a domicilio';
            $cuerpo = '<h3>¡Gracias por su pedido!</h3>';
            $cuerpo .= '<p>Hemos recibido su pedido a domicilio y lo estamos procesando.</p>';
            $cuerpo .= '<p>Detalles del pedido:</p>';
            $cuerpo .= '<ul>';
            $cuerpo .= '<li>ID del Pedido: <b>' . $id_pedido . '</b></li>';
            $cuerpo .= '<li>Nombre: <b>' . $nombre . '</b></li>';
            $cuerpo .= '<li>Identificación: <b>' . $identificacion . '</b></li>';
            $cuerpo .= '<li>Dirección: <b>' . $direccion . '</b></li>';
            $cuerpo .= '<li>Barrio: <b>' . $barrio . '</b></li>';
            $cuerpo .= '<li>Teléfono: <b>' . $telefono . '</b></li>';
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
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">

   
    
    
</head>
<body>
<header>
<?php  include 'Menu.php';
?>

</header>

<main>
    <h2>Datos Envio</h2>

    <?php MostrarMensajes($errors);?>

    <form action="domicilio.php" method="post" autocomplete="off">

        <div class="">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div class="">
            <label for="identificacion">Identificacion</label>
            <input type="number" name="identificacion" id="identificacion" required>
        </div>

        <div class="">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" id="direccion" required>
        </div>

        <div class="registro">
            <label for="barrio">Barrio</label>
            <input type="text" name="barrio" id="barrio" required>
        </div>

        <div class="registro">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono" id="telefono" required>
        </div>

        <div class="btn-form">
            <button type="submit">Ir a pagar</button>
            <button type="submit">Cancelar</button>
        </div>

    </form>
</main>

<script src="../assets/js/ValidaFormulario.js"></script>
</body>
</html>

