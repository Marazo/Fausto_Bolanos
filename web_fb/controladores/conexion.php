<?php

$mysqli = new mysqli("localhost", "root", "", "bodega_FB");

if (mysqli_connect_errno()) {
  echo "Conexion fallida: ".mysqli_connect_errno();
  exit();
}

 ?>
