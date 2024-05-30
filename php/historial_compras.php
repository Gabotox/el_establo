<?php
require '../config/config.php';
require '../config/conexion.php';
require 'funciones.php';

$db = new database();
$con = $db->conectar();

$id_cliente = $_SESSION['user_cliente'];
$sql = $con->prepare("SELECT id_transaccion, fecha, status, total FROM compra WHERE id_cliente = ? ORDER BY DATE(fecha) DESC");
$sql->execute([$id_cliente]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de compras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include 'Menu.php'; ?>

<main>
    <h3>Historial de compras</h3>
    <hr>
    <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
        <div class="carta">
            <div class="header">
                <?php echo $row['fecha']; ?>
            </div>
            <div class="body">
                <h5>Transaccion: <?php echo $row['id_transaccion']; ?> </h5>
                <p>Total: <?php echo $row['total']; ?> </p>
            </div>
        </div>
    <?php } ?>
</main>
</body>
</html>
