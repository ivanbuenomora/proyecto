<?php
// PARA LOCAL
$server = 'localhost';
$database = 'proyecto'; 
$username = 'root';
$password = '1234';

// PARA HOSTING
//  $server = 'fdb33.atspace.me';
//  $database = '4060876_proyecto'; 
//  $username = '4060876_proyecto';
//  $password = 'proyecto3726';

// Conexion al servidor
//  PDO significa PHP Data Objects, Objetos de Datos de PHP, una extensión para acceder a bases de datos.

try {
  $con = new PDO("mysql:host=$server;", $username, $password);
} catch (PDOException $e) {
  die('Conexion fallida: ' . $e->getMessage());
}

// Si en el servidor no existe la base de datos, se crea
$con->query("CREATE DATABASE IF NOT EXISTS $database");

// Conexion a la base de datos del servidor
try {
  $con = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  die('Conexion fallida: ' . $e->getMessage());
}

$url="http://".$_SERVER['HTTP_HOST']."/proyecto";

// Si no existe la tabla, se crea
// TABLA GALERIA
$con->query("CREATE TABLE IF NOT EXISTS galeria (
  ID_FOTO INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  RUTA_FOTO VARCHAR(50) NOT NULL)");

// TABLA MENSAJES
$con->query("CREATE TABLE IF NOT EXISTS mensajes (
  ID_MENSAJE INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  NOMBRE VARCHAR(50) NOT NULL,
  EMAIL VARCHAR(50) NOT NULL,
  ASUNTO VARCHAR(50) NOT NULL,
  MENSAJE VARCHAR(200) NOT NULL)");

// TABLA MUSICA
$con->query("CREATE TABLE IF NOT EXISTS musica (
  ID_MUSICA INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  RUTA_MUSICA VARCHAR(50) NOT NULL)");

// TABLA USUARIOS
$con->query("CREATE TABLE IF NOT EXISTS usuarios (
  ID_USUARIO INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  USUARIO VARCHAR(50) NOT NULL,
  NOMBRE VARCHAR(50) NOT NULL,
  APELLIDOS VARCHAR(50) NOT NULL,
  EMAIL VARCHAR(50) NOT NULL,
  PASSWORD VARCHAR(100) NOT NULL,
  TELEFONO VARCHAR(9) DEFAULT NULL,
  DIRECCION VARCHAR(100) DEFAULT NULL,
  PROVINCIA VARCHAR(50) DEFAULT NULL,
  CODIGO_POSTAL VARCHAR(5) DEFAULT NULL,
  LOCALIDAD VARCHAR(50) DEFAULT NULL)");

// TABLA PEDIDOS
$con->query("CREATE TABLE IF NOT EXISTS pedidos (
  ID_PEDIDO INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  ID_USUARIO INT NOT NULL,
  FECHA_PEDIDO DATETIME NOT NULL,
  KEY ID_USUARIO (ID_USUARIO),
  CONSTRAINT pedidos_ibfk_1 FOREIGN KEY (ID_USUARIO) REFERENCES usuarios (ID_USUARIO))");

// TABLA PRODUCTOS
$con->query("CREATE TABLE IF NOT EXISTS productos (
  ID_PRODUCTO INT PRIMARY KEY NOT NULL AUTO_INCREMENT, 
  NOMBRE_PROD VARCHAR(50) NOT NULL,
  DESCRIPCION VARCHAR(200) NOT NULL,
  PRECIO DECIMAL(5,2) NOT NULL,
  RUTA_IMAGEN VARCHAR(50) NOT NULL)");

// TABLA PEDIDOS_PRODUCTOS
$con->query("CREATE TABLE IF NOT EXISTS pedidos_productos (
  ID_PEDIDO INT NOT NULL, 
  ID_PRODUCTO INT NOT NULL,
  CANTIDAD INT NOT NULL,
  MONTO_TOTAL DECIMAL(6,2) NOT NULL,
  KEY ID_PEDIDO (ID_PEDIDO),
  KEY ID_PRODUCTO (ID_PRODUCTO),
  CONSTRAINT pedidos_productos_ibfk_1 FOREIGN KEY (ID_PEDIDO) REFERENCES pedidos (ID_PEDIDO),
  CONSTRAINT pedidos_productos_ibfk_2 FOREIGN KEY (ID_PRODUCTO) REFERENCES productos (ID_PRODUCTO))");

// --PARA INSERTAR DATOS EN LAS TABLAS--

// $con->query("INSERT INTO `galeria` (`ID_FOTO`, `RUTA_FOTO`) VALUES
// (1, '1654102516_foto_0050.jpg'),
// (2, '1654102528_foto_0005.jpg'),
// (3, '1654113862_IMG_5853.jpg'),
// (4, '1654102613_IMG_4599.jpg'),
// (5, '1654102658_IMG_2030.jpg'),
// (6, '1654113813_IMG_4624.jpg'),
// (7, '1654102810_foto_0001.jpg'),
// (8, '1654102826_foto_0015.jpg'),
// (9, '1654103536_foto_0237.jpg'),
// (10, '1654103577_ayer-carnaval-landete-2020-275.jpg'),
// (11, '1654103588_ayer-carnaval-landete-2020-327.jpg'),
// (12, '1654103611_ayer-carnaval-landete-2020-2.jpg'),
// (13, '1654103642_IMG_2044.jpg'),
// (14, '1654103661_IMG_2545.jpg'),
// (15, '1654103691_IMG_2575.jpg'),
// (16, '1654104101_IMG_4175.jpg'),
// (17, '1654104113_IMG_5861.jpg'),
// (18, '1654133334_ayer-carnaval-landete-2020-260.jpg'),
// (19, '1654133054_ayer-carnaval-landete-2020-200.jpg'),
// (21, '1654105434_IMG_2572.jpg'),
// (22, '1654105447_IMG_4061.jpg'),
// (23, '1654105494_IMG_4640.jpg'),
// (24, '1654105579_foto_0224.jpg'),
// (25, '1654105663_foto_0198.jpg'),
// (27, '1654133405_ayer-carnaval-landete-2020-192.jpg');");

// $con->query("INSERT INTO `productos` (`ID_PRODUCTO`, `NOMBRE_PROD`, `DESCRIPCION`, `PRECIO`, `RUTA_IMAGEN`) VALUES
// (1, 'camiseta', 'camiseta blanca con logo negro', '19.95', 'camiseta.webp'),
// (7, 'gorra', 'gorra negra con logo blanco', '14.95', '1654131390_gorra negra.jpg'),
// (10, 'sudadera', 'sudadera negra con logo blanco', '29.95', 'sudadera negra.jpg'),
// (11, 'mascarilla', 'mascarilla negra con logo blanco', '4.50', 'mascarilla negra.jpg'),
// (16, 'gorra', 'gorra blanca con logo negro', '14.95', '1654131182_gorra blanca.jpg');");

// $con->query("INSERT INTO `productos` (`ID_PRODUCTO`, `NOMBRE_PROD`, `DESCRIPCION`, `PRECIO`, `RUTA_IMAGEN`) VALUES
// (17, 'mochila', 'mochila negra con logo blanco ', '24.95', '1655248912_mochila.jpg'),
// (18, 'camiseta', 'camiseta negra con logo delantero en el pecho   ', '19.50', '1655249018_camiseta negra.jpg'),
// (19, 'camiseta', 'camiseta negra con logo en la parte posterior ', '19.50', '1655249087_camiseta negra posterior.jpg'),
// (20, 'gorra', 'gorra blanca con logo negro', '14.95', '1655249140_gorra blanca.jpg'),
// (21, 'gorra', 'gorra negra con logo blanco   ', '14.95', '1655251081_gorra negra.jpg'),
// (22, 'sudadera', 'sudadera negra con logo blanco en la parte posterior   ', '29.95', '1655249386_sudadera negra.jpg'),
// (23, 'mascarilla', 'mascarilla negra con logo blanco   ', '4.90', '1655249420_mascarilla negra.jpg'),
// (24, 'pulsera', 'pulsera blanca con logo negro   ', '3.50', '1655249459_pulsera.jpg');");

// Incluimos la comprobacion de si hay una sesion de usuario para tenerlo siempre controlado
include('comprobar_sesion.php');

?>