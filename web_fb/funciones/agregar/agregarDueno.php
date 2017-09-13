<?php
include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$ci = $_POST['ci'];
$nombre = utf8_decode($_POST['nombre']);
$apellido = utf8_decode($_POST['apellido']);
$telefono = $_POST['telefono'];

mysqli_query($mysqli, $consulta->sqlAgregarDueno($ci, $nombre, $apellido, $telefono));
?>
