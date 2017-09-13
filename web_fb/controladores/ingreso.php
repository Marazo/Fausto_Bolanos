<?php

session_start();
include("conexion.php");

if (!isset($_SESSION["ci"])) {
  header("Location: inicio.php");
}

$ci =   $_SESSION['ci'];

$scriptSQL = "select NOMBRE_USUARIO, APELLIDO_USUARIO, ALIAS_USUARIO, TELEFONO_USUARIO, CLAVE_USUARIO from USUARIO where CI_USUARIO = '".$ci."'";
if ($result = mysqli_query($mysqli, $scriptSQL)) {
  $filas = mysqli_fetch_array($result);
}

 ?>
