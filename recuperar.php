<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


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
        <div class="container-fluid px-5 py-0 cont_prin barr">
            <a class="navbar-brand" href="#">
                <img src="assets/img/logo2.png" alt="" width="100px" id="logo">
            </a>

            <div class="row carrito_diseño">
                <i class="fa-solid fa-user"></i>
            </div>

        </div>
    </nav>

    <div class="container-xl mt-5 log">
        <div class="login-container">
            <h2 class="mb-4">Cambiar contraseña</h2>
            <form id="login-form" method="post">
                
                <div class="form-group">
                    <label for="password">Nueva contraseña</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <input type="password" id="password" name="password" required placeholder="Nueva contraseña">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Confirmar contraseña</label>
                    <div class="diseñoLo">
                        <i class="fa-solid fa-unlock-keyhole"></i>
                        <input type="password" id="password" name="password" required placeholder="Repita su nueva contraseña">
                    </div>
                </div>

                <br>

                <div class="accionLogin">
                    <button type="submit">Cambiar</button>
                </div>
            </form>
            <p id="error-message" class="error-message"></p>
        </div>
    </div>
<br>
<br>

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


    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <!-- SWIPER JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


    <script src="assets/js/index.js"></script>
</body>

</html>