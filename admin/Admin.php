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
    <title>Iniciar Sesión - Administración</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <header>
       
    </header>
    <main>
        <h2>Iniciar sesión</h2>
        <form action="admin.php" method="post" autocomplete="off">
            <div>
                <input type="text" name="usuario" placeholder="Usuario" required>
                <label for="usuario">Usuario</label>
            </div>
            <div>
                <input type="password" name="password" placeholder="Contraseña" required>
                <label for="password">Contraseña</label>
            </div>
            <?php echo MostrarMensajes($errors); ?>
            <div>
                <a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a>
            </div>
            <div>
                <button type="submit">Ingresar</button>
            </div>
        </form>
    </main>
    <script src="../assets/js/ValidaFormulario.js"></script>
</body>
</html>