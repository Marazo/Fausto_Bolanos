<?php

include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$nombre = utf8_decode($_POST['nombre']);
$calleP = utf8_decode($_POST['calleP']);
$calleC = utf8_decode($_POST['calleC']);
$numero = utf8_encode($_POST['numero']);
$ciudad = utf8_encode($_POST['ciudad']);
$referencias = utf8_decode($_POST['referencias']);
$tipo = $_POST['tipo'];

mysqli_query($mysqli, $consulta->sqlAgregarProyecto($calleP, $calleC, $numero, $referencias, $ciudad, $nombre, $tipo));

 ?>
