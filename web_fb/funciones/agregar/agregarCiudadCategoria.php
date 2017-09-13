<?php

include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$nombre = utf8_decode($_POST['nombre']);
$tipo = $_POST['tipo'];

mysqli_query($mysqli, $consulta->sqlAgregarCiudadCategoria($nombre, $tipo));

 ?>
