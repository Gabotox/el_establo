<?php


require '../config/config.php';
require '../config/conexion.php';
require 'Adminfunciones.php';
$db = new database();
$con = $db->conectar();



/*
$usuario = 'admin';
$password = password_hash('admin1234', PASSWORD_DEFAULT); // Hasheamos la contraseña
$nombres = 'Anderson';
$email = 'admin@example.com';
$rol = 'admin'; // Definimos el rol del usuario

$sql = "INSERT INTO administracion(usuario, password, nombres, email, rol) 
        VALUES ('$usuario', '$password', '$nombres', '$email', '$rol')";
$con->query($sql);*/

$errors = [];

if (!empty($_POST)) {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    if (esNulo([$usuario, $password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors = Login($usuario, $password, $con);
    }
}

// Verificar si el usuario ya está autenticado
/*
if (isset($_SESSION['usuario_id'])) {
    // Redirigir al usuario al panel correspondiente según su rol
    if ($_SESSION['rol'] == 'admin') {
        header("Location: panel_admin.php");
        exit();
    } elseif ($_SESSION['rol'] == 'empleado') {
        header("Location: panel_empleado.php");
        exit();
    }
}*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- SWIPER JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="../assets/img/logo2.png" type="image/x-icon">


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">


    <title>El Establo - Restaurante Campestre</title>
</head>

<body>

    <main>

    <div class="loginAd">
        <div class="container-xl mt-5 log">
            <div class="login-container">
                <h2 class="mb-4">Iniciar sesión</h2>
                <form id="login-form" action="admin.php" method="post" autocomplete="off">

                    <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <div class="diseñoLo">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="usuario" placeholder="Usuario" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="diseñoLo">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <input type="password" name="password" placeholder="Contraseña" required>
                        </div>
                    </div>

                    <?php echo MostrarMensajes($errors); ?>
                    <div>
                        <a href="recuperar_contraseña.php"><i class="fa-solid fa-question"></i> ¿Olvidó su contraseña?</a>
                    </div>
                    <div class="accionLogin">
                        <button type="submit">Ingresar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    </main>

    <script src="../assets/js/ValidaFormulario.js"></script>
</body>

</html>