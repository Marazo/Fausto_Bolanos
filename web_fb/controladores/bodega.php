<?php

include("conexion.php");
session_start();

$_SESSION['id_bodega'] = $_POST['bodega'];

?>
