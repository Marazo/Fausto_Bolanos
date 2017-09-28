<?php

include("../controladores/consultas.php");
include("../controladores/ingreso.php");
session_start();

$consulta = new consultas();

$id = $_SESSION['Item_id'];
$nombre = utf8_decode($_POST['nombre']);
$unidad = $_POST['unidad'];
$categoria = $_POST['categoria'];

mysqli_query($mysqli, $consulta->sqlEditarItem($nombre, $unidad, $categoria, $id));

 ?>
