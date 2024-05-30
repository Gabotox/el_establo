<?php



require '/config/config.php';
require '../config/conexion.php';
require 'funciones.php';
$db = new database();
$con = $db->conectar();

$errors = [];

if (!empty($_POST)) {


    $correo = $_POST['correo'];


    if (EsNulo([$correo])) {
        $errors[] = "debe llenar todos los campos";
    }

    if (!EsEmail($correo)) {
        $errors[] = "La direccion de correo no es valida";
    }



    if (count($errors) == 0) {

        if (EmailExiste($correo, $con)) {

            $sql = $con->prepare("SELECT usuarios.id, clientes.nombres 
            FROM usuarios 
            INNER JOIN clientes ON usuarios.id_cliente = clientes.id 
            WHERE clientes.email LIKE ? LIMIT 1");
            $sql->execute([$correo]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $user_id = $row['id'];
            $nombres = $row['nombres'];

            $codigo = SolicitaPassword($user_id, $con);

            if ($codigo !== null) {
                require 'Mailer.php';
                $Mailer = new Mailer();

                $url = SITE_URL . '/php/reset_password.php?id=' . $user_id . '&codigo_activacion=' . $codigo;

                $asunto = "Recuperar contraseña - El establo";
                $cuerpo = "Estimado $nombres: <br> Si has solicitado el cambio de tu contraseña 
                            has click en el siguiente link <a href='$url'>Recuperar Contraseña</a>";
                $cuerpo .= "<br> En caso de que no hayas solicitado el cambio de contraseña
                            puedes ignorar este correo";
                if ($Mailer->enviarEmail($correo, $asunto, $cuerpo)) {
                    echo "<script>alert(' Hemos enviado un correo electrónico a la dirección $correo para restablecer la contraseña.');</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                    exit;
                }
            }

            ////////////////////////



        } else {
            $errors[] = "No existe una cuenta asociada a esta direccion de correo";
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
        <h3>Recuperar Contraseña</h3>
        <?php MostrarMensajes($errors); ?>
        <form action="recuperar_contraseña.php" method="post" autocomplete="off">

            <div>
                <input type="email" name="correo" id="correo" placeholder="correo electronico" required>
                <label for="correo">Correo electronico</label>
            </div>

            <div>
                <button type="submit">Continuar</button>
            </div>


        </form>



    </main>


</body>

</html>