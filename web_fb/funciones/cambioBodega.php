<?php
include("../controladores/consultas.php");
include("../controladores/ingreso.php");
$consulta = new consultas();

$id = $_SESSION['id_bodega'];
$nombre = utf8_decode($_POST['nombre']);
$calleP = utf8_decode($_POST['calleP']);
$calleC = utf8_decode($_POST['calleC']);
$numero = utf8_decode($_POST['numero']);
$referencias = utf8_decode($_POST['referencias']);

mysqli_query($mysqli, $consulta->sqlCambioBodega($id, $nombre, $calleP, $calleC, $numero, $referencias));

?>
