<?php
require '../config/config.php';
require '../config/conexion.php';
$db = new database();
$con = $db->conectar();
$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
print_r($_SESSION);

$listado_productos = array();
$total = 0; // Inicializar $total fuera del bucle foreach

if (!empty($productos)) { // Verificar si $productos no está vacío
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, Nombre, Precio FROM productos WHERE id=?");
        $sql->execute([$clave]);
        $producto = $sql->fetch(PDO::FETCH_ASSOC);
        $producto['cantidad'] = $cantidad; // Agregar la cantidad al arreglo del producto
        $listado_productos[] = $producto;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<style>
    body {
        background: none !important;
    }
</style>
<body>
<header>
<?php  include 'Menu.php'?>

<main>
    <div class="tabla-productos">
        <table class="tabla" border="1">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
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
                        $total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $nombre ?></td>
                            <td><?php echo MONEDA . $precio ?></td>
                            <td>
                                <input type="number" min="1" max="200" step="1" value="<?php echo $cantidad ?>"
                                   size="5" name="" id="cantidad_<?php echo $id ?>" onchange="actualizaCantidad(this.value, <?php echo $id; ?>)">
                            </td>
                            <td>
                                <div id="subtotal_<?php echo $id; ?>" name="subtotal[]">
                                    <?php echo MONEDA . number_format($subtotal, 2) ?></div>
                            </td>
                            <td>
                                <a href="#" class="eliminar" data-id="<?php echo $id ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="3"></td>
                    <td>
                        <p class="h3" id="total"><?php echo MONEDA . number_format($total, 2, ".", ",") ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <?php if (!empty($listado_productos)) { ?>
        <div class="pagar">
            <?php if(isset($_SESSION['user_cliente'])){ ?>
                <a href="#modalPedido">Realizar Pedido</a>
            <?php }else {  ?>
                <a href="login.php?pago">Realizar Pedido</a>
            <?php } ?> 
        </div>
    <?php } ?>
</main>

<!-- Modal para eliminar producto -->
<div id="eliminarProductoModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>¿Estás seguro de que quieres eliminar este producto?</p>
        <button id="confirmarEliminar">Eliminar</button>
        <button id="cancelarEliminar">Cancelar</button>
    </div>
</div>

<!-- Modal para elegir entre domicilio o local -->
<div id="modalPedido" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>¡Ey espera! ¿Quieres a domicilio o para el local?</p>
        <!-- Enlaces para elegir entre domicilio o local -->
        <a href="domicilio.php">Domicilio</a>
        <a href="local.php">Local</a>
    </div>
</div>


<script>
    function actualizaCantidad(cantidad, id) {
    var url = "Actualizar_carrito.php";
    var formData = new FormData();
    formData.append('action', 'agregar');
    formData.append('id', id);
    formData.append('cantidad', cantidad);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors"
    }).then(response => response.json())
        .then(data => {
            if (data.ok) {
                let divsubtotal = document.getElementById("subtotal_"+ id);
                divsubtotal.innerHTML= data.sub;

                let total = 0.0;
                let lista = document.getElementsByName('subtotal[]');
                for (let i = 0; i < lista.length; i++) {
                    total += parseFloat(lista[i].innerHTML.replace(/[$,]/g, ''));
                }

                total = new Intl.NumberFormat('en-US', {
                    minimumFractionDigits: 2
                }).format(total);

                document.getElementById('total').innerHTML = '<?php echo MONEDA; ?>' + total;
            }
        });
    }

    $(document).ready(function() {
    var idProductoEliminar; // Variable global para almacenar el ID del producto a eliminar

    // Mostrar el modal al hacer clic en el enlace "Eliminar"
    $(".eliminar").click(function() {
        idProductoEliminar = $(this).data("id"); // Almacenar el ID del producto en la variable global
        $("#eliminarProductoModal").show();
    });

    // Ocultar el modal al hacer clic en el botón "Cancelar" o en la 'x'
    $(".close, #cancelarEliminar").click(function() {
        $("#eliminarProductoModal").hide();
    });

    // Controlar la eliminación del producto al hacer clic en "Eliminar"
    $("#confirmarEliminar").click(function() {
        eliminarProducto(idProductoEliminar); // Llamar a la función para eliminar el producto
        $("#eliminarProductoModal").hide(); // Ocultar el modal después de confirmar la eliminación
    });
});
    function eliminarProducto(idProducto) {
    var url = "Actualizar_carrito.php";
    var formData = new FormData();
    formData.append('action', 'eliminar');
    formData.append('id', idProducto);

    fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors"
    })
    .then(response => response.json())
    .then(data => {
        if (data.ok) {
            location.reload(); // Recargar la página después de eliminar el producto
        } else {
            alert("No se pudo eliminar el producto.");
        }
    });
}




/*modal para el pedido*/
 // JavaScript para abrir y cerrar el modal
 $(document).ready(function() {
        // Obtener el modal
        var modalPedido = document.getElementById('modalPedido');

        // Obtener el enlace que abre el modal
        var linkRealizarPedido = document.querySelector('.pagar a');

        // Obtener el span para cerrar el modal
        var closeBtnPedido = document.querySelector('#modalPedido .close');

        // Abrir el modal cuando se hace clic en el enlace "Realizar Pedido"
        linkRealizarPedido.onclick = function() {
            modalPedido.style.display = "block";
        }

        // Cerrar el modal cuando se hace clic en la "x"
        closeBtnPedido.onclick = function() {
            modalPedido.style.display = "none";
        }

        // Cerrar el modal cuando se hace clic fuera del contenido
        window.onclick = function(event) {
            if (event.target == modalPedido) {
                modalPedido.style.display = "none";
            }
        }
    });
</script>
</body>
</html>