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

<<<<<<< HEAD
if (!ValidarCodigoRecuperacion($user_id, $codigo, $con)) {
    echo "No se pudo verificar la informacion";
    exit;
}
=======
if(!ValidarCodigoRecuperacion($user_id, $codigo, $con)){
  echo "No se pudo verificar la informacion";
  exit;
} 
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0

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
<<<<<<< HEAD
            echo "<script>window.location.href = '../login.php';</script>";
=======
            echo "<script>window.location.href = 'login.php';</script>";
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
            exit;
        } else {
            $errors[] = "Error al modificar la contraseña. Inténtalo nuevamente";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD

=======
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
<<<<<<< HEAD

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- SWIPER JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <main>
        <?php foreach ($errors as $error) : ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>

        <div class="container-xl mt-5 log">
            <div class="login-container">
                <h2 class="mb-4">Recuperar contraseña</h2>
                <form id="login-form" action="reset_password.php" method="post" autocomplete="off">

                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="codigo" value="<?= $codigo ?>">

                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <div class="diseñoLo">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <input type="password" name="password" id="password" placeholder="Contraseña" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="rep_password">Confirmar Contraseña</label>
                        <div class="diseñoLo">
                            <i class="fa-solid fa-unlock-keyhole"></i>
                            <input type="password" name="rep_password" id="rep_password" placeholder="Confirmar Contraseña" required>
                        </div>
                    </div>
                    <br>

                    <div class="accionLogin">
                        <button type="submit">Continuar</button>
                    </div>
                </form>
                <p id="error-message" class="error-message"></p>
            </div>
        </div>

    </main>
</body>

</html>
=======
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
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
