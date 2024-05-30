<?php
require '../config/config.php';

if (!isset($_SESSION['admin_id'])) {
    // Si el usuario no está autenticado, redirige a la página de inicio de sesión
    header("Location: Admin.php");
    exit(); // Termina la ejecución del script para evitar que el contenido se cargue
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../admin/css/estilos.css">
</head>
<body>

<header>
    <?php if (isset($_SESSION['admin_name'])) : ?>
        <div class="dropdown">
            <button class="dropbtn"><a href="#"><?php echo $_SESSION['admin_name']; ?></a></button>
            <div class="dropdown-content">
                <a href="cerrarSesion.php">Cerrar Sesión</a>
                <!-- Agrega aquí más enlaces si es necesario -->
            </div>
        </div>
    <?php else : ?>
        <a href="login.php">Ingresar</a>
    <?php endif; ?>
</header>

<div class="sidebar">
    <h2>Panel de Administración</h2>
    <ul>
        <li><a href="#" onclick="cargarContenido('panel_admin.php')">Inicio</a></li>
        <li><a href="#" onclick="cargarContenido('gestion_inventario.php')">Gestión de Inventario</a></li>
        <li><a href="#" onclick="cargarContenido('estado_pedido.php')">Gestión de Pedidos</a></li>
        <li>
            <a href="#" onclick="toggleSubMenu()">Gestión de Usuarios</a>
            <ul id="submenu" class="sub-menu">
                <li><a href="#" onclick="cargarContenido('clientes.php')">Clientes</a></li>
                <li><a href="#" onclick="cargarContenido('empleados.html')">Empleados</a></li>
                <li><a href="#" onclick="cargarContenido('admin.html')">Administradores</a></li>
            </ul>
        </li>
    </ul>
</div>

<div id="panel" class="content">
    <!-- Contenido se cargará aquí -->
    
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Función para cargar el contenido y guardar la sección actual en el almacenamiento local
    function cargarContenido(url) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('panel').innerHTML = xhr.responseText;
                ejecutarScripts(xhr.responseText); // Ejecutar scripts después de cargar el contenido
                guardarSeccionActual(url); // Guardar la página actual en localStorage
            }
        };
        xhr.send();
    }

    // Cargar la página guardada en localStorage al cargar la ventana
    window.onload = function() {
        var seccionActual = localStorage.getItem('seccionActual');
        if (seccionActual) {
            cargarContenido(seccionActual);
        } else {
            cargarContenido('panel_admin.php'); // Si no hay página guardada, cargar panel_admin.php por defecto
        }
    };

    // Función para ejecutar scripts después de cargar el contenido
    function ejecutarScripts(html) {
        // Extraer los scripts del HTML cargado
        var scripts = html.match(/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi);
        if (scripts) {
            // Iterar sobre los scripts y ejecutarlos
            scripts.forEach(function(script) {
                // Eliminar las etiquetas <script> para obtener el código JavaScript puro
                var scriptCode = script.replace(/<script[^>]*>/i, '').replace(/<\/script>/i, '');
                // Ejecutar el código JavaScript
                if (scriptCode.trim() !== '') {
                    // Solo ejecutar el script si el código no está vacío
                    eval(scriptCode);
                }
            });
        }
    }

    // Función para abrir y cerrar el submenú
    function toggleSubMenu() {
        var submenu = document.getElementById('submenu');
        submenu.classList.toggle('open');
    }

    // Función para guardar la página actual en localStorage
    function guardarSeccionActual(url) {
        localStorage.setItem('seccionActual', url);
    }
</script>

</body>
</html>
