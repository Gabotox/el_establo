<?php


function EsNulo(array $parametros){

    foreach ($parametros as $parametro) {
        // determinar la longitud de la cadena
        if (strlen(trim($parametro))<1) {
            return true;
        }
    }
    return false;
    
}



function UsuarioExiste($usuario, $con)  {
    $sql = $con->prepare("SELECT id FROM  usuarios  WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
      if ($sql->fetchColumn() > 0) {
        return true;
      }
      return false;
}

function EmailExiste($email, $con)  {
    $sql = $con->prepare("SELECT id FROM  clientes  WHERE email LIKE ? LIMIT 1");
    $sql->execute([$email]);
      if ($sql->fetchColumn() > 0) {
        return true;
      }
      return false;
}

function MostrarMensajes(array $errors){
    if (count($errors) > 0) {
        echo 'errores';
        foreach ($errors as $error) {
            echo '<br>';
            echo '<li>'.$error.'</li><br>';
        }
    }

}




function Login($usuario, $password, $con) {
    $sql = $con->prepare("SELECT id, usuario, password, nombres, rol FROM administracion WHERE usuario LIKE ? LIMIT 1");
    $sql->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['usuario'];
            $_SESSION['rol_user'] = $row['rol'];

            if ($_SESSION['rol_user'] == 'admin') {
                header("Location: panel_admin.php");
                exit();
            } elseif ($_SESSION['rol_user'] == 'empleado') {
                header("Location: panel_empleado.php");
                exit();
            }
        } 
    }

    return ['El usuario o la contraseña son incorrectos']; // Devuelve un array de errores
}




function SolicitaPassword($user_id,$con) {
    $codigo =generarCodigo();
    $sql = $con->prepare("UPDATE usuarios SET codigo_recuperacion = ?, password_request = 1 WHERE id = ? ");
    if ($sql->execute([$codigo, $user_id])) {
        return $codigo;
    }

    return null;
}


function ValidarCodigoRecuperacion($user_id, $codigo, $con) {
    $sql = $con->prepare("SELECT id FROM usuarios WHERE id=? AND codigo_recuperacion LIKE ? AND
    password_request =1 LIMIT 1");
    $sql->execute([$user_id, $codigo]);
    if ($sql->fetchColumn()>0) {
       return true;
    }

    return false;
    
}

function ActualizarPassword($user_id, $password, $con) {
    $sql = $con->prepare("UPDATE usuarios SET password=?, codigo_recuperacion = '', password_request=0 WHERE id = ?");
    if ($sql->execute([$password,$user_id])) {
       return true;
    }

    return false;
    
}

?>