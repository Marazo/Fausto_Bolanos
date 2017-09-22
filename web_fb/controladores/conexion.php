<?php

$mysqli = new mysqli("localhost", "root", "", "fb_bodega");

if (mysqli_connect_errno()) {
  echo "Conexion fallida: ".mysqli_connect_errno();
  exit();
}

 ?>
