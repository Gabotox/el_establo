<?php


require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';
$db = new database();
$con = $db->conectar();

$errors =[];

if (!empty($_POST)) {

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $telefono= $_POST['telefono'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $rep_password = $_POST['rep_password'];

    if (EsNulo([$nombres, $apellidos,$correo,$telefono,$usuario,$password, $rep_password])) {
        $errors [] = "debe llenar todos los campos";
    }

    if (!EsEmail($correo)) {
        $errors [] = "La direccion de correo no es valida";
    }

    if (!ValidaPassword($password, $rep_password)) {
        $errors [] = "Las contraseñas no coinciden";
    }

    if (UsuarioExiste($usuario,$con)) {
        $errors [] = "El nombre de usuario $usuario ya existe";
    }

    if (EmailExiste($correo,$con)) {
        $errors [] = "El correo electronicos $correo ya existe";
    }

    if (count($errors) == 0) {
        $id= registrarCliente([$nombres,$apellidos,$correo,$telefono], $con);

        if ($id>0) {

            require 'Mailer.php';
            $Mailer = new Mailer();
            $codigo_activacion = generarCodigo();
           

            $pash_hash = password_hash($password,PASSWORD_DEFAULT);
            $idUsuario = RegistrarUsuario([$usuario, $pash_hash, $codigo_activacion, $id], $con);
            
            if($idUsuario > 0){

                

                $url = SITE_URL.'/php/activar_cliente.php?id='.$idUsuario.'&codigo_activacion='.$codigo_activacion;

                $asunto = "Activar cuenta - El establo";
                $cuerpo = "Estimado $nombres: <br> Para continuar con el proceso de registro hara click en el siguiente enlace <a href='$url'>Activar Cuenta</a>";
                
                if ($Mailer->enviarEmail($correo,$asunto,$cuerpo)) {
                    
                    echo "<script>alert('para terminar el proceso de registro siga las instrucciones que le hemos enviado $correo');</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                    exit;
                }


            }else{
                $errors[]= "error al registrar usuario";

            }
        }else{
            $errors[]= "error al registrar cliente";
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
<a href="checkout.php">carrito
 <span id="num" class="carrito"><?php echo $num; ?></span>
</a>
</header>

<main>
<h2>Datos del cliente</h2>

<?php  MostrarMensajes($errors);?>

<form action="registro.php" method = "post" autocomplete = "off">

<div class="registro">
    <label for="nombres">Nombres</label>
    <input type="text" name ="nombres" id = "nombres" requireda>
</div>

<div class="registro">
    <label for="apellidos">Appellidos</label>
    <input type="text" name ="apellidos" id = "apellidos" requireda>
</div>

<div class="registro">
    <label for="correo">Correo electronico</label>
    <input type="email" name ="correo" id = "correo" requireda>
    <span id = validaCorreo></span>
</div>

<div class="registro">
    <label for="telefono">Telefono</label>
    <input type="tel" name ="telefono" id = "telefono" requireda>
</div>

<div class="registro">
    <label for="usuario">Usuario</label>
    <input type="text" name ="usuario" id = "usuario" requireda>
    <span id = validausuario></span>
</div>

<div class="registro">
    <label for="password">Contraseña</label>
    <input type="password" name ="password" id = "password" requireda>
</div>

<div class="registro">
    <label for="rep_password"> Repetir Contraseña</label>
    <input type="password" name ="rep_password" id = "rep_password" requireda>
</div>

<div class="btn-form">
    <button type = "submit">Registrar</button>
</div>

</form>
</main>

<script src="../assets/js/ValidaFormulario.js"></script>
</body>
</html>


