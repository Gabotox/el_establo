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
        date_default_timezone_set('America/Bogota'); // Establecer la zona horaria a Colombia
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


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- SWIPER JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />



    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">


    <title>El Establo - Restaurante Campestre</title>


</head>

<body>

    <nav class="navbar navbar-expand-lg pt-4">
        <div class="container-fluid px-5 py-0 cont_prin barr">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo2.png" alt="" width="100px" id="logo">
            </a>

            <div class="row carrito_diseño">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

        </div>
    </nav>



    <div class="container-xl mt-5 log">
        <div class="login-container">
            <h2 class="mb-4">Formulario de envío</h2>
            <form id="login-form" action="domicilioo.php" method="post" autocomplete="off">
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
                        <input type="tel" name="identificacion" id="telefono" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Teléfono</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="tel" name="telefono" id="telefono" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Barrio</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" id="username" name="barrio" required placeholder="Barrio">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Dirección</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-hashtag"></i>
                        <input type="text" id="username" name="direccion" required placeholder="Dirección">
                    </div>
                </div>

                <div class="accionLogin">
                    <button type="submit">Ir a pagar</button>
                    <button type="submit" style="background: red !important;">Cancelar</button>
                </div>
            </form>
            
        </div>
    </div>




    <div class="container-xl pie">
        <footer class="footer row align-items-center py-4">
            <div class="col-4">
                <div class="row text-center">
                    <img src="assets/img/logo2.png" alt="" id="logo" style="margin: 0 auto;">
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <h4>El Establo</h4>
                </div>
                <div class="row d-flex justify-content-center mt-3">
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                    </div>
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>


    <script src="assets/js/index.js"></script>

</body>

</html>