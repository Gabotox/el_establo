<?php
require 'config/config.php';
require 'config/conexion.php';
$db = new database();
$con = $db->conectar();
$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;


$listado_productos = array();
$total = 0; // Inicializar $total fuera del bucle foreach

if (!empty($productos)) { // Verificar si $productos no está vacío
    foreach ($productos as $clave => $cantidad) {
        $sql = $con->prepare("SELECT id, Nombre, Precio, img_producto FROM productos WHERE id=?");
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


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


    <title>El Establo - Restaurante Campestre</title>

</head>

<body>

    <nav class="navbar navbar-expand-lg pt-4">
        <div class="container-fluid px-5 py-0 cont_prin barr">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo2.png" alt="" width="100px" id="logo">
            </a>

            <div class="row carrito_diseño">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

        </div>
    </nav>

    <div class="container-xl px-4">
        <div class="alert mt-5" role="alert">
            A simple primary alert—check it out!
        </div>
    </div>

    <div class="container-xl px-4 mb-5" style="color: #fff !important;">
        <?php if (empty($listado_productos)) { ?>
            <div class="texto">
                <b>Lista vacía</b>
            </div>
        <?php } else { ?>
            <div class="row carrito_producto mt-3 d-flex align-items-center">
                <div class="col-3 col-sm-3">
                    <h4>Imagen</h4>
                </div>
                <div class="col-3 col-sm-2">
                    <h4>Nombre</h4>
                </div>
                <div class="col-3 col-sm-3">
                    <h4>Cantidad</h4>
                </div>
                <div class="col-3 col-sm-3">
                    <h4>Acción</h4>
                </div>
            </div>
            <?php foreach ($listado_productos as $producto) {
                $id = $producto['id'];
                $nombre = $producto['Nombre'];
                $precio = $producto['Precio'];
                $cantidad = $producto['cantidad'];
                $subtotal = $precio * $cantidad;
                $total += $subtotal;
                $img_producto = $producto['img_producto'];
            ?>
                <div class="row carrito_producto mt-3 d-flex align-items-center">
                    <div class="col-3 col-sm-3 col_img">
                        <img src="<?php echo $img_producto ?>" alt="" width="" class="">
                    </div>
                    <div class="col-4 col-sm-3 des_car">
                        <div class="row">
                            <div class="col">
                                <h4><?php echo $nombre ?></h4>
                                <span><?php echo MONEDA . $precio ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 col-sm-6 acciones_carrito">
                        <input type="number" min="1" max="200" step="1" value="<?php echo $cantidad ?>" size="5" name="" id="cantidad_<?php echo $id ?>" onchange="actualizaCantidad(this.value, <?php echo $id; ?>)">
<<<<<<< HEAD
                        <a href="#" id="el" class="eliminar" data-id="<?php echo $id ?>">Eliminar</a>
=======
                        <a href="#" class="eliminar" data-id="<?php echo $id ?>">Eliminar</a>
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="subtotal_<?php echo $id; ?>" name="subtotal[]">
                            <span>Sub Total: </span><?php echo MONEDA . number_format($subtotal, 2) ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>



    <div class="row mt-5">
        <div class="col">
            <p class="h3" id="total" style="color: #fff !important;">Total a pagar: <?php echo MONEDA . number_format($total, 2, ".", ",") ?></p>
        </div>
    </div>
<<<<<<< HEAD

    <?php if (isset($_SESSION['user_cliente'])) { ?>
        <button class="btn btn-btn mt-4 p-3" id="pagara">
            Ir a pagar
        </button>
    <?php } else {  ?>
        <a href="login.php" class="init">Primero debes iniciar sesión</a>
        <br>
        <br>
    <?php } ?>

=======
    <button class="btn btn-btn mt-4 p-3" id="pagara">
        Ir a pagar
    </button>
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
    </div>



    <div class="modali">
    </div>

    <div class="submodali">
        <div class="submodal">
            <h5>¡Ey Espera!</h5>
            <p>¿Quieres a domicilio o para el local?</p>

            <div class="acciones_modal">
<<<<<<< HEAD
                <a href="php/locall.php">
=======
                <a href="#">
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
                    <i class="fa-solid fa-shop"></i>
                </a>
                <a href="php/domicilioo.php">
                    <i class="fa-solid fa-truck-fast"></i>
                </a>
            </div>

        </div>
    </div>


    <div class="container-xl pie">
        <footer class="footer row align-items-center py-4">
            <div class="col-4">
                <div class="row text-center">
                    <img src="assets/img/logo2.png" alt="" id="logo" style="margin: 0 auto;">
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <h4>El Establo</h4>
                </div>
                <div class="row d-flex justify-content-center mt-3">
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-facebook"></i>
                        </a>

                    </div>
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="#" class="redes">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>


<<<<<<< HEAD
    <!-- Modal para eliminar producto -->
    <div id="eliminarProductoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>¿Estás seguro de que quieres eliminar este producto?</p>
            <button id="confirmarEliminar">Eliminar</button>
            <br>
            <button id="cancelarEliminar">Cancelar</button>
        </div>
    </div>

    <style>
        /* Estilos para el modal */
        /* Estilos para el modal */
        #cancelarEliminar {
            background: red;
        }
        #eliminarProductoModal 
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        #el {
            text-decoration: none;
            background: red;
            color: #fff;
            padding: .3rem .5rem;
            border-radius: 10px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

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


=======
>>>>>>> 841e038f69ce0849f54286d4b5e2daa999df85c0
    <script src="assets/js/index.js"></script>

    <script>
        function actualizaCantidad(cantidad, id) {
            var url = "php/Actualizar_carrito.php";
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
                        let divsubtotal = document.getElementById("subtotal_" + id);
                        divsubtotal.innerHTML = data.sub;

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
            var url = "php/Actualizar_carrito.php";
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
    </script>

</body>

</html>