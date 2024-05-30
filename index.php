<?php
require 'config/config.php';

require 'config/conexion.php';


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


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <!-- SWIPER JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- LOGO EN EL NAVEGADOR -->
    <link rel="shortcut icon" href="assets/img/logo2.png" type="image/x-icon">


    <!-- HOJA DE CSS -->
    <link rel="stylesheet" href="assets/css/style.css">


    <title>El Establo - Restaurante Campestre</title>

</head>

<body>

    <nav class="navbar navbar-expand-lg pt-4">
        <div class="container-fluid px-5 py-0 cont_prin">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo2.png" alt="" id="logo">
            </a>

            <div class="iconos ms-auto">
                <a href="carrito.php" class="carrito icono">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <p id="num" class="carrito contador"><?php echo $num; ?></p>
                </a>

                <?php if (isset($_SESSION['user_id'])) {  ?>
                    <div class="dropdown">
                        <button class="dropbtn">
                            <a href="#"><?php echo substr($_SESSION['user_name'], 0, 2) . '' ?>
                                <i class="fa-solid fa-user"></i>
                            </a>
                        </button>
                        <div class="dropdown-content">
                            <a href="php/cerrar_sesion.php">Cerrar Sesion</a>
                            <a href="php/historial_compras.php">Historial de compras</a>

                        </div>
                    </div>

                <?php } else { ?>
                    <a class="user icono" href="login.php">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php } ?>


            </div>

        </div>
    </nav>

    <div class="container-xl buscar px-5 pt-4">
        <form class="form-inline d-flex">
            <input class="form-control" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn_buscar" type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>
    </div>



    <div class="container-xl categorias mt-5 mb-5">
        <?php
        $categoria_actual = null;
        foreach ($resultado as $row) {
            if ($row['id_categoria'] != $categoria_actual) {
                // Si la categoría actual es diferente a la categoría anterior, cierra los contenedores de la categoría y del slider
                if ($categoria_actual !== null) {
                    echo '</div>'; // Cierra el contenedor del slider
                    echo '</div>'; // Cierra el contenedor de la categoría
                }
                $categoria_actual = $row['id_categoria'];
                echo "<div class='container-fluid categoria'>";
                echo "<h2 class='titulo_categoria'>" . obtenerNombreCategoria($categoria_actual) . "</h2>";
                echo '<div class="swiper mySwiper">'; // Abre el contenedor del slider
                echo '<div class="swiper-wrapper">'; // Abre el wrapper del slider
            }
        ?>
            <div class="swiper-slide carta_producto">
                <div class="superior_producto">
                    <img src="<?php echo $row['img_producto']; ?>" alt="" class="img_producto">
                </div>
                <div class="inferior_producto">
                    <div class=" info_producto">
                        <h3 class="titulo_producto"><?php echo $row['Nombre']; ?></h3>
                        <p class="descripcion_producto">
                            $<?php echo number_format($row['Precio'], 2, '.', ','); ?>
                        </p>
                    </div>
                    <div class="btn_carrito">
                        <a class="detalle" href="#" data-id="<?php echo $row['id']; ?>">Detalles</a>
                        <button class="agregar-producto" id="<?php echo $row['id']; ?>"><i class="fa-solid fa-cart-shopping"></i></button>
                    </div>
                </div>
            </div>

        <?php
        }
        // Cierre de los contenedores después de que el bucle ha terminado
        echo '</div>'; // Cierra el wrapper del slider
        echo '</div>'; // Cierra el contenedor del slider
        echo '</div>'; // Cierra el contenedor de la última categoría
        ?>
    </div>



    <div class="container-xl pie mt-5">
        <footer class="footer row align-items-center py-5">
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
            var url = "php/carrito.php";
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

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- SWIPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="assets/js/index.js"></script>


    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 20,
            freeMode: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            loop: true,
            loopAdditionalSlides: 1,
        });
    </script>
</body>

</html>