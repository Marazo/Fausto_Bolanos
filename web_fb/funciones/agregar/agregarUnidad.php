<?php

include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$nombre = utf8_decode($_POST['nombre']);
$abrebiatura = $_POST['abrebiatura'];

mysqli_query($mysqli, $consulta->sqlAgregarUnidad($nombre, $abrebiatura));

 ?>
