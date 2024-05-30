<?php
require '../config/config.php';
require '../config/conexion.php';
require 'AdminFunciones.php';

$db = new database();
$con = $db->conectar();

// Obtener todos los pedidos de la base de datos
$sql_pedidos = "SELECT * FROM pedidos";
$resultado_pedidos = $con->query($sql_pedidos);

// Verificar si hay resultados
if ($resultado_pedidos && $resultado_pedidos->rowCount() > 0) {
    // Almacenar los pedidos en un array
    $pedidos = $resultado_pedidos->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si no hay resultados, inicializar el array de pedidos como vacío
    $pedidos = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    
    <style>
        /* Estilos para la lista de pedidos */
        .pedidos-lista {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        /* Estilos para cada pedido */
        .pedido {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Estilos para los encabezados dentro de cada pedido */
        .pedido strong {
            color: #333;
        }

        /*modal para detalles de compra*/
        /* Estilos para el modal */
        .modal {
            display: none; /* Ocultar el modal por defecto */
            position: fixed; /* Fijar el modal en la ventana del navegador */
            z-index: 1; /* Establecer la superposición */
            left: 0;
            top: 0;
            width: 100%; /* Ancho completo */
            height: 100%; /* Altura completa */
            overflow: auto; /* Habilitar el desplazamiento */
            background-color: rgba(0,0,0,0.4); /* Fondo oscuro semi-transparente */
        }

        /* Estilos para el contenido del modal */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% de margen superior y automático a los lados */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Ancho del contenido */
        }

        /* Estilos para el botón de cerrar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        
    </style>
</head>
<body>
<header></header>
<main>

    <h2>Gestión de Pedidos</h2>
    <div class="filters">
        <label for="filtro_estado">Filtrar por Estado:</label>
        <select name="filtro_estado" id="filtro_estado">
            <option value="todos">Todos</option>
            <option value="Pendiente de Pago">Pendiente de Pago</option>
            <option value="Pendiente">Pendiente</option>
            <option value="En proceso">En Proceso</option>
            <option value="Completado">Completado</option>
        </select>
    </div>

    <?php if (!empty($pedidos)): ?>
    <div class="pedidos-lista">
        <?php foreach ($pedidos as $pedido): ?>
            <div class="pedido" data-estado="<?php echo $pedido['estado_pedido']; ?>">
            <button class="btnDetalleCompra" data-id-pedido="<?php echo $pedido['id']; ?>">Ver Detalles de Compra</button>

            <p><strong>ID Pedido:</strong> <?php echo $pedido['id']; ?></p>
            <p><strong>ID Cliente:</strong> <?php echo $pedido['id_cliente']; ?></p>
            <p><strong>Nombre:</strong> <?php echo $pedido['nombre']; ?></p>
            <p><strong>Identificación:</strong> <?php echo $pedido['identificacion']; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $pedido['telefono']; ?></p>
            <p><strong>Mesa:</strong> <?php echo $pedido['mesa']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $pedido['direccion']; ?></p>
            <p><strong>Barrio:</strong> <?php echo $pedido['barrio']; ?></p>
            <p><strong>Tipo de Envío:</strong> <?php echo $pedido['tipo_envio']; ?></p>
            <p><strong>Total del Pago:</strong> <?php echo $pedido['total']; ?></p>
            <p><strong>Fecha de Pedido:</strong> <?php echo $pedido['fecha_pedido']; ?></p>
            <label for="estado_pedido">Estado del Pedido:</label>
            <select name="estado_pedido" id="estado_pedido_<?php echo $pedido['id']; ?>">
               <option value="<?php echo $pedido['estado_pedido']; ?>" selected><?php echo $pedido['estado_pedido']; ?></option>
               <option value="Pendiente de Pago">Pendiente de Pago</option>
               <option value="pendiente">pendiente</option>
               <option value="En proceso">En proceso</option>
               <option value="Completado">Completado</option>
            </select>
            <button name="guardar_estado" data-pedido-id="<?php echo $pedido['id']; ?>">Guardar Estado</button>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <p>No hay pedidos registrados.</p>
    <?php endif; ?>

    <div id="modalDetalleCompra" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="contenidoDetalleCompra">
                <h2>Detalle de compra</h2>
                <div class="detalles-container">
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Scripts al final del body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script>
    $(document).ready(function() {
        // Evento clic para mostrar el modal de detalles de compra
        $(document).on("click", ".btnDetalleCompra", function() {
            // Obtener el ID del pedido
            var pedidoId = $(this).data("id-pedido");

            // Realizar una solicitud AJAX para obtener los detalles de la compra
            $.ajax({
                url: "detalles_compra.php", // Ruta al script PHP que obtiene los detalles de la compra
                method: "POST",
                data: { pedido_id: pedidoId },
                success: function(response) {
                    // Mostrar los detalles de la compra en el modal
                    $("#contenidoDetalleCompra").html(response);
                    $("#modalDetalleCompra").show();
                },
                error: function(xhr, status, error) {
                    console.error("Error al obtener los detalles de la compra:", error);
                }
            });
        });

        // Evento clic para cerrar el modal de detalles de compra
        $(document).on("click", ".close", function() {
            $("#modalDetalleCompra").hide();
        });

        // Función para cambiar el estado del pedido
        function cambiarEstadoPedido(pedidoId, nuevoEstado) {
    $.ajax({
        url: "cambiar_estado_pedido.php", // Ruta al script PHP que actualiza el estado del pedido
        method: "POST",
        data: { pedido_id: pedidoId, nuevo_estado: nuevoEstado },
        success: function(response) {
            // Verificar si se actualizó el estado correctamente
            if (response === "success") {
                // Actualizar el estado en la interfaz de usuario
                $("#estado_pedido_" + pedidoId).val(nuevoEstado);
                alert("Estado del pedido actualizado correctamente.");

                // Enviar correo electrónico
                $.ajax({
                    url: "enviar_correo.php", // Ruta al script PHP que envía el correo electrónico
                    method: "POST",
                    data: { pedido_id: pedidoId, nuevo_estado: nuevoEstado },
                    success: function(response) {
                        console.log("Correo electrónico enviado con éxito");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al enviar el correo electrónico:", error);
                    }
                });
            } else {
                alert("Error al actualizar el estado del pedido.");
            }
        },
        error: function(xhr, status, error) {
            console.error("Error al cambiar el estado del pedido:", error);
        }
    });
}


        // Evento clic para el botón "Guardar Estado"
       $(document).on("click", "[name='guardar_estado']", function() {
    var pedidoId = $(this).data("pedido-id"); // Obtener el ID del pedido
    var nuevoEstado = $("#estado_pedido_" + pedidoId).val(); // Obtener el nuevo estado seleccionado
    cambiarEstadoPedido(pedidoId, nuevoEstado); // Llamar a la función para cambiar el estado del pedido
    filtrarPedidos($("#filtro_estado").val()); // Filtrar los pedidos según el estado seleccionado
});
       
});

$(document).ready(function() {
    // Evento de cambio para el filtro de estado
    $("#filtro_estado").change(function() {
        var estadoSeleccionado = $(this).val();
        filtrarPedidos(estadoSeleccionado);
    });

    // Función para mostrar u ocultar los pedidos según el estado seleccionado
    function filtrarPedidos(estado) {
    $(".pedido").each(function() {
        var estadoPedido = $(this).data("estado").toLowerCase(); // Convertir a minúsculas
        if (estado === "todos" || estadoPedido === estado.toLowerCase()) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}
});
</script>

</body>
</html>

