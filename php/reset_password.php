<?php
require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$codigo = $_GET['codigo_activacion'] ?? $_POST['codigo'] ?? '';



if ($user_id == '' || $codigo == '') {
    header('location: index.php');
    exit;
}

$db = new database();
$con = $db->conectar();
$errors = [];

if(!ValidarCodigoRecuperacion($user_id, $codigo, $con)){
  echo "No se pudo verificar la informacion";
  exit;
} 

if (!empty($_POST)) {
    $password = $_POST['password'];
    $rep_password = $_POST['rep_password'];

    if (EsNulo([$user_id, $codigo, $password, $rep_password])) {
        $errors[] = "Debe llenar todos los campos";
    }

    if (!ValidaPassword($password, $rep_password)) {
        $errors[] = "Las contraseñas no coinciden";
    }

    if (count($errors) == 0) {
        $pash_hash = password_hash($password, PASSWORD_DEFAULT);
        if (ActualizarPassword($user_id, $pash_hash, $con)) {
            echo "<script>alert('Contraseña Modificada');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
            exit;
        } else {
            $errors[] = "Error al modificar la contraseña. Inténtalo nuevamente";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <a href="checkout.php">Carrito
        <span id="num" class="carrito"><?php echo $num; ?></span>
    </a>
</header>

<main>
    <h3>Cambiar Contraseña</h3>
    <?php foreach ($errors as $error) : ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>
    <form action="reset_password.php" method="post" autocomplete="off">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="hidden" name="codigo" value="<?= $codigo ?>">
        <div>
            <input type="password" name="password" id="password" placeholder="Contraseña" required>
            <label for="password">Nueva Contraseña</label>
        </div>
        <div>
            <input type="password" name="rep_password" id="rep_password" placeholder="Confirmar Contraseña" required>
            <label for="rep_password">Confirmar Contraseña</label>
        </div>
        <div>
            <button type="submit">Continuar</button>
        </div>
    </form>
</main>
</body>
</html>
