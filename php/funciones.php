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

function EsEmail($email){
   if( filter_var($email,FILTER_VALIDATE_EMAIL)){
    return true;
   }
   return false;
}

function ValidaPassword($password, $rep_password) {
    // se compara las dos contraseñas
    if (strcmp($password, $rep_password) === 0) {
        return true;
    }
    return false;
}


function generarCodigo(){
    return md5(uniqid(mt_rand(), false));
}



function registrarCliente(array $datos, $con){
    $sql = $con ->prepare("INSERT INTO clientes (nombres, apellidos,email,telefono) VALUES (?,?,?,?)");

    if ($sql->execute($datos)) {
        return $con->lastInsertId();

    }
    return 0;
}

function RegistrarUsuario(array $datos, $con)  {
    $sql = $con->prepare("INSERT INTO usuarios (usuario, password, codigo_activacion, id_cliente) VALUES (?,?,?,?)");
    if($sql->execute($datos)){
        return $con->lastInsertId();
    }
    return 0;
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

function ValidarCodigo($id, $codigo_activacion,$con)  {
    $msg = "";
    $sql = $con->prepare("SELECT id FROM  usuarios  WHERE id =? AND codigo_activacion LIKE ? LIMIT 1");
    $sql->execute([$id, $codigo_activacion]);
      if ($sql->fetchColumn() > 0) {
        if(ActivarUsuario($id,$con)){
          // Mensaje de éxito
    $msg = "¡La cuenta ha sido activada con éxito!";

    // Alerta y redirección con JavaScript
    echo "<script>alert('$msg');</script>";
    echo "<script>window.location.href = '../login.php';</script>";
        }else{
            $msg = "Error al activar cuenta";
            echo "<script>alert('$msg');</script>";
            echo "<script>window.location.href = '../login.php';</script>";
        }
      }else{
        $msg = "No existe el registro del cliente";
        echo "<script>alert('$msg');</script>";
            echo "<script>window.location.href = '../login.php';</script>";
      }
      return $msg;
}
function ActivarUsuario($id, $con){
    $sql = $con->prepare("UPDATE usuarios SET activacion_cuenta = 1, codigo_activacion= '' WHERE id=?");
   return  $sql->execute([$id]);

}

function Login($usuario, $password, $con, $proceso) {
    $sql = $con->prepare("SELECT id, usuario, password, id_cliente FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql ->execute([$usuario]);
    if ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        if (EsActivo($usuario, $con)) {
           if( password_verify($password,$row['password'])){
             $_SESSION['user_id']= $row['id'];
             $_SESSION['user_name'] = $row['usuario'];
             $_SESSION['user_cliente'] = $row['id_cliente'];
            
             if ($proceso == 'pago') {
                header('Location: checkout.php');
             }else{
<<<<<<< HEAD
                header('location: index.php');
=======
                header('location:index.php');
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0

             }
             
             exit;
           }
        }else{
            return 'el usuario no ha sido activado';
        }
    }

    return 'El usuario o la contraseña son incorrectos';
    
}

function EsActivo($usuario,$con){
    $sql = $con->prepare("SELECT activacion_cuenta FROM usuarios WHERE usuario LIKE ? LIMIT 1");
    $sql ->execute([$usuario]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    if ($row['activacion_cuenta'] == 1) {
        return true; 
    }

    return false;
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