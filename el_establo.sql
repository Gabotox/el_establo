-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-05-2024 a las 00:26:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `el_establo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administracion`
--

CREATE TABLE `administracion` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) DEFAULT NULL,
  `password` varchar(120) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `codigo_password` varchar(50) DEFAULT NULL,
  `request_password` tinyint(4) DEFAULT 0,
  `rol` enum('empleado','admin') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administracion`
--

INSERT INTO `administracion` (`id`, `usuario`, `password`, `nombres`, `email`, `codigo_password`, `request_password`, `rol`) VALUES
(2, 'admin', '$2y$10$2qz1qaIsjjpcFBuKq4z.yeGD6zeo9EcRvC9Ez/oUxFUC4./BpmJ6.', 'Anderson', 'anjodivi15@gmail.com', NULL, 0, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `puntos_redimidos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `puntos_redimidos`) VALUES
(32, 'Anderson', 'Diaz Vides', 'anjodivi15@gmail.com', '3013786180', 4900),
(33, 'Juan Gabriel ', 'Meza Benítez', 'juanmeza242001@gmail.com', '3115140908', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `email`, `id_cliente`, `total`, `id_administrador`, `id_pedido`) VALUES
(217, '3E1379118J460213G', '2024-05-16 02:54:32', 'COMPLETED', 'anjodivi15@gmail.com', '32', 106000.00, NULL, 44),
(218, '1XW061134M013741B', '2024-05-16 02:56:52', 'COMPLETED', 'anjodivi15@gmail.com', '32', 31610.00, NULL, 45),
(219, '2YY9912325220602X', '2024-05-17 22:10:56', 'COMPLETED', 'anjodivi15@gmail.com', '32', 39000.00, NULL, 48),
(220, '0A3556649R285421H', '2024-05-17 22:13:37', 'COMPLETED', 'anjodivi15@gmail.com', '32', 21000.00, NULL, 49),
(221, '0EX19831SA685810J', '2024-05-17 22:25:22', 'COMPLETED', 'anjodivi15@gmail.com', '32', 21000.00, NULL, 50),
(222, '1KY88835H1046873W', '2024-05-17 22:31:17', 'COMPLETED', 'anjodivi15@gmail.com', '32', 63000.00, NULL, 51),
(223, '4HB78111GD1990629', '2024-05-17 22:43:59', 'COMPLETED', 'anjodivi15@gmail.com', '32', 54.60, NULL, 53),
(224, '42J44702UJ306071J', '2024-05-17 22:48:04', 'COMPLETED', 'anjodivi15@gmail.com', '32', 38.45, NULL, 54),
(225, '0U781284YH9617633', '2024-05-17 23:10:33', 'COMPLETED', 'anjodivi15@gmail.com', '32', 84.94, NULL, 55),
(226, '06S692054B251251B', '2024-05-25 00:21:55', 'COMPLETED', 'anjodivi15@gmail.com', '32', 54.60, NULL, 56),
(227, '99A38322KE1073401', '2024-05-25 00:30:10', 'COMPLETED', 'anjodivi15@gmail.com', '32', 18.20, NULL, 57),
(228, '77L22178VH791470E', '2024-05-30 23:09:11', 'COMPLETED', 'anjodivi15@gmail.com', '32', 18.20, NULL, 59);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`, `id_cliente`) VALUES
(225, 217, 6, 'Picada de Chicharrón y Yuca', 36000.00, 2, 32),
(226, 217, 12, 'Sierra frita', 70000.00, 2, 32),
(227, 218, 6, 'Picada de Chicharrón y Yuca', 18000.00, 1, 32),
(228, 218, 7, 'Deditos y Empanadas 3 y 3', 15000.00, 1, 32),
(229, 219, 2, 'Chip de plátanos', 7000.00, 1, 32),
(230, 219, 5, 'Chorizo, Patacón y Suero', 14000.00, 1, 32),
(231, 219, 6, 'Picada de Chicharrón y Yuca', 18000.00, 1, 32),
(232, 220, 2, 'Chip de plátanos', 7000.00, 1, 32),
(233, 220, 5, 'Chorizo, Patacón y Suero', 14000.00, 1, 32),
(234, 221, 2, 'Chip de plátanos', 7000.00, 1, 32),
(235, 221, 5, 'Chorizo, Patacón y Suero', 14000.00, 1, 32),
(236, 222, 2, 'Chip de plátanos', 7000.00, 1, 32),
(237, 222, 11, 'Mojarra en zumo de coco', 34000.00, 1, 32),
(238, 222, 17, 'Mote de queso en leña', 22000.00, 1, 32),
(239, 223, 2, 'Chip de plátanos', 7000.00, 1, 32),
(240, 223, 5, 'Chorizo, Patacón y Suero', 14000.00, 1, 32),
(241, 224, 6, 'Picada de Chicharrón y Yuca', 18000.00, 1, 32),
(242, 225, 6, 'Picada de Chicharrón y Yuca', 18000.00, 1, 32),
(243, 225, 7, 'Deditos y Empanadas 3 y 3', 15000.00, 1, 32),
(244, 226, 2, 'Chip de plátanos', 7000.00, 1, 32),
(245, 226, 5, 'Chorizo, Patacón y Suero', 14000.00, 1, 32),
(246, 227, 2, 'Chip de plátanos', 7000.00, 1, 32),
(247, 228, 2, 'Chip de plátanos', 7000.00, 1, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `identificacion` int(11) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `barrio` varchar(100) NOT NULL,
  `mesa` int(11) DEFAULT NULL,
  `tipo_envio` enum('domicilio','local') NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `estado_pedido` enum('pendiente de pago','pendiente','En proceso','Completado') NOT NULL,
  `id_administrador` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Precio` decimal(10,2) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `img_producto` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_administrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`ID`, `Nombre`, `Descripcion`, `Precio`, `id_categoria`, `img_producto`, `stock`, `id_administrador`) VALUES
(2, 'Chip de plátanos', 'Deliciosas rodajas finas de plátano, crujientes y sabrosas', 7000.00, 1, 'assets/image/Productos/Entradas/Chip de platano.webp', 0, NULL),
(5, 'Chorizo, Patacón y Suero', 'Una combinación perfecta de chorizo criollo, patacón, plátano verde frito y suero costeño', 14000.00, 1, 'assets/image/Productos/Entradas/Chorizo, Patacon y Suero.webp', 0, NULL),
(6, 'Picada de Chicharrón y Yuca', 'Una mezcla irresistible de chicharrón (piel de cerdo frita) y yuca frita, servidos con salsas para acompañar', 18000.00, 1, 'assets/image/Productos/Entradas/Picada de chicharron y yuca.webp', 0, NULL),
(7, 'Deditos y Empanadas 3 y 3', 'Una selección de deditos de queso (palitos de queso empanizados) y empanadas rellenas de carne, pollo o queso', 15000.00, 1, 'assets/image/Productos/Entradas/Deditos y Empanadas 3y3.webp\n', 0, NULL),
(8, 'Consomé de Gallina', 'Un caldo reconfortante preparado con carne de gallina, verduras y especias', 8000.00, 1, 'assets/image/Productos/Entradas/Consomé de gallina.webp', 0, NULL),
(9, 'Canasta de Plátanos Rellenos ', 'Plátanos maduros ahuecados y rellenos con una mezcla deliciosa de carne, pollo o camarones, gratinados al horno', 17000.00, 1, 'assets/image/Productos/Entradas/Canasta de Platano rellenos.webp', 0, NULL),
(10, 'Mojarra Frita', 'Mojarra fresca frita hasta quedar crujiente, servida con arroz de coco frito, ensalada fresca y frijoles refritos', 30000.00, 2, 'assets/image/Productos/Pescados/Mojarra Frita.webp', 0, NULL),
(11, 'Mojarra en zumo de coco', 'Mojarra fresca cocida en un delicioso zumo de coco, acompañada de arroz de coco frito, ensalada fresca y patacones', 34000.00, 2, 'assets/image/Productos/Pescados/Mojarra en zumo de coco.webp', 0, NULL),
(12, 'Sierra frita', 'Filete de sierra fresca frito al estilo tradicional, acompañado de arroz de coco frito, ensalada fresca y patacones', 35000.00, 2, 'assets/image/Productos/Pescados/Sierra frita.webp', 0, NULL),
(13, 'Sierra en zumo de coco', 'Filete de sierra fresca cocido en un exquisito zumo de coco, servido con arroz de coco frito, ensalada fresca y patacones', 39000.00, 2, 'assets/image/Productos/Pescados/Sierra en zumo de coco.webp', 0, NULL),
(14, 'Bocachico frito', 'Bocachico fresco frito hasta obtener una textura crujiente, acompañado de arroz de coco frito, ensalada fresca y patacones', 35000.00, 2, 'assets/image/Productos/Pescados/Bocachico frito.webp', 0, NULL),
(15, 'Bocachico en zumo de coco', 'Bocachico fresco cocido en un sabroso zumo de coco, servido con arroz de coco frito, ensalada fresca y patacones', 39000.00, 2, 'assets/image/Productos/Pescados/Bocachico en zumo de coco.webp', 0, NULL),
(16, 'Viuda de Bocachico', 'Preparación especial con filete de bocachico fresco, acompañado de arroz de coco frito, ensalada fresca y patacones, en un plato característico de la región', 39000.00, 2, 'assets/image/Productos/Pescados/Viuda de Bocachico.webp', 0, NULL),
(17, 'Mote de queso en leña', 'Una deliciosa combinación de mote de queso cocido a la leña, servido con arroz, tajada madura (plátano frito maduro) y chuleta', 22000.00, 3, 'assets/image/Productos/Platos Tipicos/Mote de queso.webp', 0, NULL),
(18, 'Sancocho de Gallina criolla', 'Un caldo abundante y sabroso preparado con gallina criolla, servido con arroz, trozos de gallina guisada y aguacate fresco', 25000.00, 3, 'assets/image/Productos/Platos Tipicos/Sancocho de Gallina.webp', 0, NULL),
(19, 'Carnero guisado', 'Trozos de carne de carnero cocidos a fuego lento en una salsa de especias y verduras, servidos con arroz, ensalada fresca y yuca cocida', 34000.00, 3, 'assets/image/Productos/Platos Tipicos/Carnero guisado.webp', 0, NULL),
(20, 'Viuda de carne salada', 'Una mezcla única de ñame, plátano maduro y yuca, acompañados de carne salada, todo ahogado en una salsa deliciosa, creando un plato lleno de texturas y sabores contrastantes', 30000.00, 3, 'assets/image/Productos/Platos Tipicos/viuda de carne salada.webp', 0, NULL),
(21, 'Arroz de camarón con patacones', 'Arroz cocido con camarones frescos, servido con patacones (plátanos verdes fritos y aplastados), una combinación deliciosa que resalta los sabores marinos con la textura crujiente de los patacones', 35000.00, 3, 'assets/image/Productos/Platos Tipicos/Arroz de camaron con patacones.webp', 0, NULL),
(22, 'Pechuga al carbón', 'Jugosa pechuga de pollo asada a la parrilla, acompañada de ensalada fresca y opción de yuca o papa cocida', 28000.00, 4, 'assets/image/Productos/Asados/Pechuga al carbon.webp', 0, NULL),
(23, 'Cerdo al carbón ', 'Delicioso cerdo asado a la parrilla, servido con ensalada fresca y opción de yuca o papa cocida', 28000.00, 4, 'assets/image/Productos/Asados/Cerdo al carbon.webp', 0, NULL),
(24, 'Lomito de res al carbón', 'Tierno lomito de res asado a la parrilla, acompañado de ensalada fresca y opción de yuca o papa cocida', 32000.00, 4, 'assets/image/Productos/Asados/Lomito de res al carbon.webp', 0, NULL),
(25, 'Churrasco', 'Jugoso y sabroso churrasco a la parrilla, servido con ensalada fresca y opción de yuca o papa cocida', 35000.00, 4, 'assets/image/Productos/Asados/Churrasco.webp', 0, NULL),
(26, 'Punta gorda', 'Sabrosa punta gorda asada a la parrilla, acompañada de ensalada fresca y opción de yuca o papa cocida', 38000.00, 4, 'assets/image/Productos/Asados/Punta Gorda.webp', 0, NULL),
(27, 'Costillas BBQ', 'Deliciosas costillas de cerdo bañadas en salsa BBQ, servidas con ensalada fresca y opción de yuca o papa cocida', 34000.00, 4, 'assets/image/Productos/Asados/Costillas a la BBQ.webp', 0, NULL),
(28, 'Picada para 2 personas', 'Una selección de carnes que incluye pechuga de pollo, cerdo, lomito de res, chicharrón artesanal y butifarra, acompañadas de ensalada, patacones, papas francesas y tres salsas distintas. Perfecta para compartir y disfrutar en grupo', 45000.00, 4, 'assets/image/Productos/Asados/Picada para 2 personas.webp', 0, NULL),
(29, 'Picada para 4 personas', 'Una selección de carnes que incluye pechuga de pollo, cerdo, lomito de res, chicharrón artesanal y butifarra, acompañadas de ensalada, patacones, papas francesas y tres salsas distintas. Perfecta para compartir y disfrutar en grupo', 90000.00, 4, 'assets/image/Productos/Asados/Picada para 4 personas.webp', 0, NULL),
(30, 'Coctel Margarita Tradicional', 'Refrescante y clásico cóctel preparado con tequila, triple sec y jugo de limón, servido en un vaso escarchado con sal', 17000.00, 5, 'assets/image/Productos/Cocteles/Margarita tradicional.webp', 0, NULL),
(31, 'Coctel Margarita Frutal', 'Una versión frutal y refrescante del clásico Margarita, con la adición de puré de frutas como fresa, mango o maracuyá, que le añaden un toque dulce y tropical', 23000.00, 5, 'assets/image/Productos/Cocteles/Margarita Frutal.webp', 0, NULL),
(32, 'Coctel Mojito', 'Refrescante y vigorizante cóctel hecho con ron blanco, hojas de menta fresca, azúcar, soda y jugo de limón, perfecto para disfrutar en una tarde calurosa', 19000.00, 5, 'assets/image/Productos/Cocteles/Coctel mojito.webp', 0, NULL),
(33, 'Piña Colada', 'Un clásico de los cócteles tropicales, elaborado con ron blanco, crema de coco y jugo de piña, servido con hielo triturado y decorado con una rodaja de piña. Ideal para transportarte a una playa paradisíaca con cada sorbo', 27000.00, 5, 'assets/image/Productos/Cocteles/Piña colada.webp', 0, NULL),
(34, 'Corozo', 'Refrescante bebida hecha a base de corozo, una fruta tropical con un sabor ligeramente ácido y dulce', 5000.00, 6, 'assets/image/Productos/Jugos Naturales/Jugo Corozo.webp', 0, NULL),
(35, 'Tamarindo', 'Bebida refrescante elaborada con pulpa de tamarindo, que ofrece un sabor agridulce único', 5000.00, 6, 'assets/image/Productos/Jugos Naturales/Jugo Tamarindo.webp', 0, NULL),
(36, 'Maracuyá', 'Deliciosa bebida hecha con jugo natural de maracuyá, conocido también como fruta de la pasión', 5000.00, 6, 'assets/image/Productos/Jugos Naturales/Jugo Maracuya.webp', 0, NULL),
(37, 'Limonada', 'Clásica y refrescante bebida preparada con jugo de limón, agua y azúcar', 5000.00, 6, 'assets/image/Productos/Jugos Naturales/Limonada.webp', 0, NULL),
(38, 'Limonada Cerezada', 'Variante de la limonada tradicional con un toque de cereza, que le añade un sabor dulce y ligeramente ácido', 6000.00, 6, 'assets/image/Productos/Jugos Naturales/Limonada Cerezada.webp', 0, NULL),
(39, 'Coca-Cola Personal', 'Una botella individual de 400 ml de Coca-Cola, la bebida carbonatada más popular del mundo', 4000.00, 7, 'assets/image/Productos/Gaseosas/cocacola personal.webp', 0, NULL),
(40, 'Colombiana Personal', 'Una botella individual de 400 ml de Colombiana, una bebida gaseosa colombiana con un sabor dulce y único a base de extracto de cola y frutas', 4000.00, 7, 'assets/image/Productos/Gaseosas/Colombiana personal.webp', 0, NULL),
(41, 'Sprite Personal', 'Una botella individual de 400 ml de Sprite, una bebida refrescante con sabor a lima-limón', 4000.00, 7, 'assets/image/Productos/Gaseosas/Sprite personal.webp', 0, NULL),
(42, 'Pepsi Personal', 'Una botella individual de 400 ml de Pepsi, otra bebida carbonatada muy popular con un sabor distintivo y refrescante', 4000.00, 7, 'assets/image/Productos/Gaseosas/Pepsi personal.webp', 0, NULL),
(43, 'Coca-Cola 1.5', 'Una botella grande de 1.5 litros de Coca-Cola, perfecta para compartir o para tener en casa y disfrutar en cualquier momento', 12000.00, 7, 'assets/image/Productos/Gaseosas/Coca-cola 1.5 l.webp', 0, NULL),
(44, 'Pepsi 1.5', 'Una botella grande de 1.5 litros de Pepsi, ideal para acompañar comidas familiares o reuniones', 12000.00, 7, 'assets/image/Productos/Gaseosas/Pepsi 1.5 l.webp', 0, NULL),
(45, 'Sprite 1.5', 'Una botella grande de 1.5 litros de Sprite, refrescante y perfecta para hidratarse en cualquier ocasión', 12000.00, 7, 'assets/image/Productos/Gaseosas/Sprite 1.5 l.webp', 0, NULL),
(46, 'Colombiana 1.5', 'Una botella grande de 1.5 litros de Colombiana', 12000.00, 7, 'assets/image/Productos/Gaseosas/Colombiana 1.5 l.webp', 0, NULL),
(47, 'Agua 600 ml', 'Botella individual de agua purificada, perfecta para calmar la sed y mantenerse hidratado', 3000.00, 7, 'assets/image/Productos/Gaseosas/Agua 600ml.webp', 0, NULL),
(48, 'Jugo Hit', 'Jugo de frutas refrescante, disponible en una variedad de sabores como naranja, manzana o uva', 4000.00, 7, 'assets/image/Productos/Gaseosas/Jugos Hit.webp', 0, NULL),
(49, 'Bretaña', 'Bebida gaseosa con sabor a lima-limón, refrescante y con un toque cítrico', 5000.00, 7, 'assets/image/Productos/Gaseosas/soda bretaña.webp', 0, NULL),
(50, 'Gatorade', 'Bebida deportiva diseñada para reponer electrolitos perdidos durante el ejercicio intenso, disponible en varios sabores y tamaños', 6000.00, 7, 'assets/image/Productos/Gaseosas/Gatorade.webp', 0, NULL),
(51, 'Águila Negra', 'Una cerveza colombiana de cuerpo completo y sabor robusto, con un carácter maltoso y ligeramente amargo', 4500.00, 8, 'assets/image/Productos/Cervezas/Aguila Negra.webp', 0, NULL),
(52, 'Águila Light', 'Una versión más ligera de la clásica Águila, con un contenido reducido de calorías y un sabor más suave', 4500.00, 8, 'assets/image/Productos/Cervezas/Aguila Ligth.webp', 0, NULL),
(53, 'Club Colombia', 'Una cerveza premium colombiana, con un equilibrio entre el amargor del lúpulo y el dulzor de la malta', 6000.00, 8, 'assets/image/Productos/Cervezas/Club Colombia.webp', 0, NULL),
(54, 'Costeñita', 'Una cerveza ligera y refrescante, perfecta para disfrutar en climas cálidos. Con un sabor suave y equilibrado', 3500.00, 8, 'assets/image/Productos/Cervezas/Costeñita.webp', 0, NULL),
(55, 'Corona', 'Una cerveza mexicana conocida por su sabor suave y refrescante, con un toque de lima', 6000.00, 8, 'assets/image/Productos/Cervezas/Corona.webp', 0, NULL),
(56, 'Stella', 'Una cerveza belga de estilo pilsner, reconocida por su sabor suave y equilibrado, con un aroma floral y un final refrescante', 7000.00, 8, 'assets/image/Productos/Cervezas/Stella.webp', 0, NULL),
(57, 'Porción de Arroz Blanco', 'Porción de arroz blanco cocido al punto', 4000.00, 9, 'assets/image/Productos/Adicionales/Porcion de arroz blanco.webp', 0, NULL),
(58, 'Porción de Arroz de Coco', 'Porción de arroz cocido con leche de coco, que le confiere un sabor dulce y aromático', 5000.00, 9, 'assets/image/Productos/Adicionales/Porcion de arroz de coco.webp', 0, NULL),
(59, 'Porción de Ensalada', 'Porción de ensalada fresca, compuesta por una mezcla de lechuga, tomate, pepino y otros vegetales, aderezada con una vinagreta de la casa', 5000.00, 9, 'assets/image/Productos/Adicionales/Porcion de ensalada.webp', 0, NULL),
(60, 'Porción de Francesas', 'Porción de papas fritas cortadas en forma de bastones, crujientes por fuera y tiernas por dentro', 5.00, 9, 'assets/image/Productos/Adicionales/Porcion de fransesas.webp', 0, NULL),
(61, 'Porción de Suero', 'Porción de papas fritas cortadas en forma de bastones, crujientes por fuera y tiernas por dentro', 2000.00, 9, 'assets/image/Productos/Adicionales/Porcion de suero.webp', 0, NULL),
(62, 'Adicional de Salsas', 'Variedad de salsas para complementar tus platos, que pueden incluir desde salsa de ajo hasta picante o salsa tártara, según tu preferencia', 3000.00, 9, 'assets/image/Productos/Adicionales/Adicional de salsa.webp', 0, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntos_por_compra`
--

CREATE TABLE `puntos_por_compra` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `puntos_ganados` int(11) NOT NULL,
  `fecha_ganado` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion_cuenta` int(11) NOT NULL DEFAULT 0,
  `codigo_activacion` varchar(100) NOT NULL,
  `codigo_recuperacion` varchar(100) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) DEFAULT NULL,
  `id_administracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion_cuenta`, `codigo_activacion`, `codigo_recuperacion`, `password_request`, `id_cliente`, `id_administracion`) VALUES
(22, 'Anderson', '$2y$10$PwPAPEv7xZC.4Ey62wMb6O1QLPWWo3gyEDSFe2/ZrqtIMzG1mYZOm', 1, '', '3ed759e8f19683285e5ee8c33f068e35', 1, 32, NULL),
(23, 'gabotox', '$2y$10$1eDObaTCKFpiLd1CMYUT/uG0eg44VdOnWyYB0BtPe55AwgULD8Yqa', 0, '8233b4608644149dc8f2f044cf2df6f5', NULL, 0, 33, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administracion`
--
ALTER TABLE `administracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_administrador` (`id_administrador`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_compra` (`id_compra`),
  ADD KEY `fk_id_producto` (`id_producto`),
  ADD KEY `fk_cliente` (`id_cliente`);

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_administrador` (`id_administrador`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_administrador_modificacion` (`id_administrador`);

--
-- Indices de la tabla `puntos_por_compra`
--
ALTER TABLE `puntos_por_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_id_cliente` (`id_cliente`),
  ADD KEY `id_administracion` (`id_administracion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administracion`
--
ALTER TABLE `administracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `puntos_por_compra`
--
ALTER TABLE `puntos_por_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `compra_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`);

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_id_compra` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id`),
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`ID`);

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`ID`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_administrador`) REFERENCES `administracion` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_administrador`) REFERENCES `administracion` (`id`);

--
-- Filtros para la tabla `puntos_por_compra`
--
ALTER TABLE `puntos_por_compra`
  ADD CONSTRAINT `puntos_por_compra_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_administracion`) REFERENCES `administracion` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
