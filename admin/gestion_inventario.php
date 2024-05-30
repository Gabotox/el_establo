<?php
require '../config/config.php';
require '../config/conexion.php';
require 'AdminFunciones.php';

$db = new database();
$con = $db->conectar();

// Obtener todos los productos de la base de datos
$sql_productos = "SELECT * FROM productos";
$resultado_productos = $con->query($sql_productos);

// Verificar si hay resultados
if ($resultado_productos && $resultado_productos->rowCount() > 0) {
    // Almacenar los productos en un array
    $productos = $resultado_productos->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no hay resultados, inicializar el array de productos como vacío
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de productos</title>
    
    <style>
        /* Estilos para la lista de productos */
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
    <h2>Gestión de Productos</h2>

    <?php if (!empty($productos)): ?>
    <div class="productos-lista">
        <?php foreach ($productos as $producto): ?>
            <div>
                <p><strong>ID producto:</strong> <?php echo htmlspecialchars($producto['ID']); ?></p>
                <p><strong>Descripción:</strong> <?php echo htmlspecialchars($producto['Descripcion']); ?></p>
                <p><strong>Precio:</strong> <?php echo htmlspecialchars($producto['Precio']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>No hay productos disponibles.</p>
    <?php endif; ?>
</main>
</body>
</html>

