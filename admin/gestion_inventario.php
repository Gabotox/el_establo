<?php
require '../config/config.php';
require '../config/conexion.php';
require 'AdminFunciones.php';

$db = new database();
$con = $db->conectar();

// Obtener todos los pedidos de la base de datos
$sql_pedidos = "SELECT * FROM productos";
$resultado_pedidos = $con->query($sql_pedidos);

// Verificar si hay resultados
if ($resultado_pedidos && $resultado_pedidos->rowCount() > 0) {
    // Almacenar los pedidos en un array
    $productos = $resultado_pedidos->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no hay resultados, inicializar el array de pedidos como vacío
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de productos</title>
    
    <style>
        /* Estilos para la lista de pedidos */
        .productos-lista {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
  
    </style>
</head>
<body>
<header></header>
<main>

    <h2>Gestión de Pedidos</h2>
 

    <?php if (!empty($productos)): ?>
        <div class="productos-lista">
    <?php foreach ($productos as $producto): ?>
        <div class="producto">
            <p><strong>ID producto:</strong> <?php echo $producto['ID']; ?></p>
            <p><strong>Nombre:</strong> <?php echo $producto['Nombre']; ?></p>
            <p><strong>ID Cliente:</strong> <?php echo $producto['Descripcion']; ?></p>
            <p><strong>Precio:</strong> <?php echo $producto['Precio']; ?></p>
        </div>
    <?php endforeach; ?>
</div>
    <?php endif; ?>
  
</main>
</body>
<<<<<<< HEAD
</html>
=======
</html>

>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
