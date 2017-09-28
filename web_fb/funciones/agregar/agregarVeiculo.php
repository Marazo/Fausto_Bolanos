<?php
include("../../controladores/consultas.php");
include("../../controladores/ingreso.php");
$consulta = new consultas();

$placas = $_POST['placas'];
$descripcion = $_POST['descripcion'];
$dueno = $_POST['dueno'];

if ($dueno == 'sindueno') {
  echo "no";
}else {
  mysqli_query($mysqli, $consulta->sqlAgregarautomovil($placas, $descripcion));
  mysqli_query($mysqli, $consulta->sqlAgregarVeiculo($placas, $dueno));
  echo "si";
}

?>
