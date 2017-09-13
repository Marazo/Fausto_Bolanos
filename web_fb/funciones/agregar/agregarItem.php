<?php

include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$nombre = utf8_decode($_POST['nombre']);
$unidad = $_POST['unidad'];
$categoria = $_POST['categoria'];

mysqli_query($mysqli, $consulta->sqlAgregarItem($nombre, $unidad, $categoria));

 ?>
