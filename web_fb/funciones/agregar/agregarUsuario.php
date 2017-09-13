<?php
include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$ci = $_POST['ci'];
$nombre = utf8_decode($_POST['nombre']);
$apellido = utf8_decode($_POST['apellido']);
$telefono = $_POST['telefono'];
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];
$tipo = $_POST['tipo'];

mysqli_query($mysqli, $consulta->sqlAgregarUsuario($ci, $nombre, $apellido, $telefono, $usuario, $clave, $tipo));
?>
