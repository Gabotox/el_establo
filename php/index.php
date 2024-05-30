<?php
require '../config/config.php';
require '../config/conexion.php';
$db = new database();
$con = $db->conectar();
$sql = $con->prepare("SELECT id, Nombre, Descripcion, Precio, id_categoria, img_producto, stock FROM productos ORDER BY id_categoria");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

function obtenerNombreCategoria($id_categoria)
{
    switch ($id_categoria) {
        case 1:
            return "Entradas";
        case 2:
            return "Pescados";

        case 3:
            return "Platos Tipicos";
        case 4:
            return "Asados";
        case 5:
            return "Cócteles";
        case 6:
            return "Jugos Naturales";
        case 7:
            return "Gaseosas";
        case 8:
            return "Cervezas";
        case 9:
            return "Adicionales";
        default:
            return "Otra categoría";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../assets/js/script.js"></script>

</head>

<body>
    <main>
        <div class="categorias">
            <?php
            $categoria_actual = null;
            foreach ($resultado as $row) {
                if ($row['id_categoria'] != $categoria_actual) {
                    // Si la categoría actual es diferente a la categoría anterior, muestra el título de la nueva categoría
                    if ($categoria_actual !== null) {
                        echo "</div>"; // Cierra el contenedor de productos de la categoría anterior
                    }
                    $categoria_actual = $row['id_categoria'];
                    echo "<div class='categoria'>";
                    echo "<h2>" . obtenerNombreCategoria($categoria_actual) . "</h2>";
                    echo "<div class='productos'>";
                }
            ?>
                <div class="producto">
                    <img src="<?php echo $row['img_producto']; ?>" alt="">
                    <h5><?php echo $row['Nombre']; ?></h5>
                    <p>$<?php echo number_format($row['Precio'], 2, '.', ','); ?></p>
                    <a class="detalle" href="#" data-id="<?php echo $row['id']; ?>">Detalles</a>

                    <button class="agregar-producto" id="<?php echo $row['id']; ?>">Agregar</button>
                </div>
            <?php
            }
            echo "</div>"; // Cierra el contenedor de productos de la última categoría
            ?>
        </div>
    </main>

    <!-- Modal -->
    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <img id="modal-imagen" src="" alt=""> <!-- Agregar el elemento img -->
            <h2 id="modal-nombre"></h2>
            <h2 id="modal-precio"></h2>
            <p id="modal-descripcion"></p>
            <div class="compra">
                <button id="add-to-cart">agregar al carrito</button>
            </div>
        </div>
    </div>

    </div>

    <script>
        $(document).ready(function() {
            $(".detalle").click(function() {
                $("#myModal").show();
                var idProducto = $(this).data("id"); // Obtener el ID del producto del enlace
                var detalles = <?php echo json_encode($resultado); ?>;
                var producto = detalles.find(item => item.id === idProducto); // Buscar el producto por su ID
                if (producto) {
                    $("#modal-nombre").text(producto.Nombre);
                    $("#modal-precio").text('<?php echo MONEDA; ?>' + producto.Precio);
                    $("#modal-descripcion").text(producto.Descripcion);
                    $("#modal-imagen").attr("src", producto.img_producto); // Establecer la URL de la imagen
                    $("#add-to-cart").attr("data-id", producto.id); // Establecer el ID del producto al botón "Agregar al carrito"
                }
            });


            $(".close").click(function() {
                $("#myModal").hide();
            });

            // Agrega un controlador de eventos para el clic en el botón "Agregar"
            $(".agregar-producto").click(function() {
                var id = $(this).attr("id"); // Obtener el id del producto del botón
                addProducto(id); // Llama a la función addProducto con el id del producto
            });

            $("#add-to-cart").click(function() {
                var id = $(this).attr("data-id");
                addProducto(id);
            });
        });

        function addProducto(id) {
            var url = "carrito.php";
            var formData = new FormData();
            formData.append('id', id);

            fetch(url, {
                    method: "POST",
                    body: formData,
                    mode: "cors"
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        var elemento = document.getElementById("num");
                        elemento.innerHTML = data.numero;
                    }
                });
        }
    </script>
</body>

</html>