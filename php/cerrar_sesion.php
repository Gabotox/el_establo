<?php
require '../config/config.php';
require '../config/conexion.php';

session_destroy();

header ('Location: ../index.php');


?>