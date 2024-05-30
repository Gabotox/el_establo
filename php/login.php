<?php


require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';
$db = new database();
$con = $db->conectar();

$proceso = isset($_GET['pago'])? 'pago': 'login';


$errors =[];

if (!empty($_POST)) {

    //$correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $proceso = $_POST['proceso']?? 'login';


    if (EsNulo([$usuario,$password])) {
        $errors [] = "debe llenar todos los campos";
    }

    if (count($errors) == 0) {
        $errors [] = Login($usuario,$password, $con, $proceso);
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
<a href="checkout.php">carrito
 <span id="num" class="carrito"><?php echo $num; ?></span>
</a>
</header>

<main>
<h2>Iniciar sesion</h2>
<?php  MostrarMensajes($errors);?>

<form action="login.php" method="post" autocomplete="off">

<input type="hidden" name="proceso" value = "<?php  echo $proceso;?>">

    <div>
        <input type="text" name="usuario"  placeholder="usuario" required>
        <label for="usuario">Usuario</label>
    </div>

    <div>
        <input type="password" name="password" id="password" placeholder="Contraseña" required>
        <label for="password">Contraseña</label>
    </div>

    <div>
        <a href="recuperar_contraseña.php">¿Olvidaste tu contraseña?</a>
    </div>

    <div>
        <button type="submit">Ingresar</button>
    </div>

    <div>
        <p>¿Aun tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</form>
</main>

<script src="../assets/js/ValidaFormulario.js"></script>
</body>
</html>
