<?php

include("../controladores/consultas.php");
include("../controladores/ingreso.php");
$consulta = new consultas();

$clave = $_POST['clave'];
$antigua = $_POST['antigua'];

if (mysqli_query($mysqli, $consulta->sqlCambioClave($clave, $ci, $antigua))){
  echo "si";
}else {
  echo "no";
}

 ?>
