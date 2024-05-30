<?php
require '../config/config.php';
require '../config/conexion.php';
$db = new database();
$con = $db->conectar();

// Definición de la función obtenerPuntosAcumulados()
function obtenerPuntosAcumulados($cliente_id, $con)
{
    $sql = $con->prepare("SELECT puntos_redimidos FROM clientes WHERE id=?");
    $sql->execute([$cliente_id]);
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    return $row['puntos_redimidos'];
}

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$listado_productos = array();
$total = 0; // Inicializar $total fuera del bucle foreach
$total_puntos = 0; // Inicializar $total_puntos fuera del bucle foreach

if (!empty($productos)) { // Verificar si $productos no está vacío
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, Nombre, Precio FROM productos WHERE id=?");
        $sql->execute([$clave]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
        $producto['cantidad'] = $cantidad; // Agregar la cantidad al arreglo del producto
        $listado_productos[] = $producto;
        $total += $producto['Precio'] * $cantidad; // Sumar el precio del producto al total

        // Calcular los puntos por producto y sumarlos al total de puntos
        $subtotal = $producto['Precio'] * $cantidad;
        $puntos_por_producto = floor($subtotal / 10); // Ejemplo: 1 punto por cada $10 gastados
        $total_puntos += $puntos_por_producto; // Sumar puntos por producto al total de puntos
    }
}

// Obtener el ID del cliente actual (asumiendo que se guarda en la sesión)
$id_cliente = $_SESSION['user_cliente']; // Corregido para obtener el ID del cliente de la sesión

// Asumiendo que la función valorPunto() devuelve el valor de cada punto
$valor_punto = 0.1; // Ejemplo: Cada punto vale 0.1 unidad monetaria

// Calcular el descuento máximo permitido (70%)
$descuento_maximo = $total * 0.7;

// Verificar si el cliente tiene suficientes puntos para redimir
$puntos_acumulados = obtenerPuntosAcumulados($id_cliente, $con);
$descuento_disponible = min($puntos_acumulados * $valor_punto, $descuento_maximo); // Seleccionar el mínimo entre los puntos disponibles y el descuento máximo permitido

// Calcular el porcentaje de descuento aplicado
$porcentaje_descuento = 0; // Inicializar el porcentaje de descuento

// Aplicar descuento por puntos acumulados si el cliente elige redimir puntos
if (isset($_POST['redimir_puntos']) && $descuento_disponible > 0) {
    // Restar el descuento al total de la compra solo si hay puntos suficientes para redimir
    $total -= $descuento_disponible; // Resta el descuento al total de la compra

    // Reducir los puntos redimidos del cliente en la base de datos
    $sql_update_puntos = $con->prepare("UPDATE clientes SET puntos_redimidos = puntos_redimidos - ? WHERE id = ?");
    $sql_update_puntos->execute([$descuento_disponible / $valor_punto, $id_cliente]);

    // Calcular el porcentaje de descuento aplicado
    $porcentaje_descuento = ($descuento_disponible / ($total + $descuento_disponible)) * 100;
} elseif (empty($_POST['redimir_puntos'])) {
    // Si no se redimen puntos, agregar los puntos ganados por la compra a la tabla de clientes
    $puntos_ganados = floor($total / 10); // Ejemplo: 1 punto por cada $10 gastados
    $sql_update_puntos = $con->prepare("UPDATE clientes SET puntos_redimidos = puntos_redimidos + ? WHERE id = ?");
    $sql_update_puntos->execute([$puntos_ganados, $id_cliente]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://www.paypal.com/sdk/js?client-id=<?php echo CLIENT_ID ?>&currency=USD"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<style>
    body {
        color: #000 !important;
        background: none !important;
        font-family: Arial, Helvetica, sans-serif !important;
    }
</style>

<body>
    <?php include 'Menu.php' ?>

    <main>

        <br>
        <br>
        <br>
        <br>
        <div class="row">
            <div class="col-6">
                <h4>Detalles de pago</h4>
            </div>
            <br>
            <br>
            <div id="paypal-button-container"></div>
        </div>

        <div class="col-6">
            <div class="tabla-productos">
                <table class="tabla">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listado_productos)) {
                            echo '<tr><td colspan="5" class="texto"><b>Lista vacía</b></td></tr>';
                        } else {
                            foreach ($listado_productos as $producto) {
                                $id = $producto['id'];
                                $nombre = $producto['Nombre'];
                                $precio = $producto['Precio'];
                                $cantidad = $producto['cantidad'];
                                $subtotal = $precio * $cantidad;
                        ?>
                                <tr>
                                    <td><?php echo $nombre ?></td>
                                    <td>
                                        <div id="subtotal_<?php echo $id; ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2) ?></div>
                                    </td>

                                </tr>
                        <?php
                            }
                        }
                        ?>
                        <tr>
                            <br>
                            <br>
                            <td>
                                <p class="h3" id="total">TOTAL A PAGAR: <?php echo MONEDA . number_format($total, 2, ".", ",") ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <br>
        <form method="post" onsubmit="return confirm('¿Estás seguro de que deseas redimir tus puntos? Esta acción es irreversible.\nDescuento disponible: $<?php echo $descuento_disponible; ?>.')">
            <button type="submit" name="redimir_puntos" <?php if ($porcentaje_descuento > 0) echo "disabled"; ?>>Redimir Puntos</button>
        </form>
    </main>

    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: <?php echo $total; ?>
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                let URl = 'captura.php';
                actions.order.capture().then(function(detalles) {
                    console.log(detalles);
                    let url = 'captura.php';
                    return fetch(url, {
                        method: 'POST',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            detalles: detalles
                        })
                    }).then(function(response) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Pago realizado correctamente",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href = "../index.php";
                        });
                    });
                });
            },
            onCancel: function(data) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pago cancelado!',
                }).then(function() {
                    console.log(data);
                });
            }

        }).render('#paypal-button-container');

        // Mostrar una alerta con el porcentaje de descuento si se aplica
    </script>

</body>

</html>