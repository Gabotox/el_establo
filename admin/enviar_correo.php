<?php
require '../config/config.php';
require '../config/conexion.php';
require '../php/Mailer.php'; // Asegúrate de que la ruta sea la correcta

$db = new database();
$con = $db->conectar();

// Verificar si se recibieron los datos del pedido y el nuevo estado
if (isset($_POST['pedido_id']) && isset($_POST['nuevo_estado'])) {
    $pedidoId = $_POST['pedido_id'];
    $nuevoEstado = $_POST['nuevo_estado'];

    // Obtener la información del cliente
    $sql_cliente_info = $con->prepare("SELECT clientes.nombres, clientes.apellidos, clientes.email FROM pedidos INNER JOIN clientes ON pedidos.id_cliente = clientes.id WHERE pedidos.id = ?");
    $sql_cliente_info->execute([$pedidoId]);
    $clienteInfo = $sql_cliente_info->fetch(PDO::FETCH_ASSOC);

    // Combinar nombres y apellidos del cliente
    $nombreCliente = $clienteInfo['nombres'] . ' ' . $clienteInfo['apellidos'];
    $correoCliente = $clienteInfo['email'];

    // Configurar el mensaje a enviar
    $asunto = "Actualizacion de estado de pedido";
   
$cuerpo = "<html>
<head>
  <title>Actualización de estado de pedido</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    h1 {
      font-size: 24px;
      color: #333;
    }
    p {
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class='container'>
    <h1>Actualizacion de estado de pedido</h1>
    <p>Estimado $nombreCliente,</p>
    <p>Su pedido con ID $pedidoId ha sido actualizado con el nuevo estado: <strong>$nuevoEstado</strong>.</p>
    <p>Gracias por confiar en nosotros.</p>
    <p>Saludos cordiales,</p>
    <p>Att: El Establo</p>
  </div>
</body>
</html>";

    // Crear una instancia de la clase Mailer
    $mailer = new Mailer();

    // Enviar correo electrónico utilizando la función enviarEmail() de la clase Mailer
    $envioCorreo = $mailer->enviarEmail($correoCliente, $asunto, $cuerpo);

    // Verificar si el correo se envió correctamente
    if ($envioCorreo) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error: Datos del pedido no recibidos";
}
?>
