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
                    echo "<script>window.location.href = '../login.php';</script>";
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


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


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



    <nav class="navbar navbar-expand-lg pt-4">
        <div class="container-fluid px-5 py-0 cont_prin barr">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo2.png" alt="" width="100px" id="logo">
            </a>

            <div class="row carrito_diseño">
                <i class="fa-solid fa-user"></i>
            </div>

        </div>
    </nav>

    <div class="container-xl mt-5 log">
        <div class="login-container">
            <h2 class="mb-4">Registro de usuario</h2>
            <form id="login-form" method="post"  autocomplete="off">
                <div class="form-group">
                    <label for="username">Nombres</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="nombres" required placeholder="Ingrese sus nombres">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Apellidos</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="apellidos" required placeholder="Ingrese sus apellidos">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Correo electrónico</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" id="username" name="correo" required placeholder="Ingrese su correo electrónico">
                    </div>
                </div>

                <div class="form-group">
                    <label for="username"># De celular</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-phone"></i>
                        <input type="tel" name ="telefono" id = "telefono" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username">Usuario</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" id="username" name="usuario" required placeholder="Ingrese su usuario">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Repetir contraseña</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <input type="password" id="password" name="rep_password" required placeholder="Repetir contraseña contraseña">
                    </div>
                </div>
                <br>

                <div class="accionLogin">
                    <button type="submit">Crear cuenta</button>
                </div>
            </form>
            <p id="error-message" class="error-message"></p>
        </div>
    </div>
<br>
<br>

    <div class="container-xl pie mt-5">
        <footer class="footer row align-items-center py-5">
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


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- SWIPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="assets/js/index.js"></script>
</body>

</html>