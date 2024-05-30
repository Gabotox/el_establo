<?php

define("SITE_URL","http://localhost/el_establo");


define("CLIENT_ID", "AWOnU1dNNSbsotgHmr5FPe0kxko6vIc076M1DH5l6akE3Ax1bNwiAkjLgbm437AAL-Qfqle9sUlMVkCK");
define("TOKEN_MP", "TEST-5622736659025444-042817-e7c5506725397d2ca18bc6f40a47167d-653174302");
define("MONEDA","$");


//CORREO ELECTRONICO

define("MAIL_HOST","smtp.gmail.com");
define("MAIL_USER","andersondiazvides05@gmail.com");
define("MAIL_PASS","wytl ldcx kjqw yudt");
define("MAIL_PORT","587");



session_start();
/////
if (!isset($_SESSION['carrito']['productos'])) {
    $_SESSION['carrito']['productos'] = array();
}
/////

$num = 0;
if (isset($_SESSION['carrito']['productos'])) {
    $num = count($_SESSION['carrito']['productos']);
}


?>