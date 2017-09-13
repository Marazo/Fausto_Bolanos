<?php

include("conexion.php");
session_start();

$_SESSION['Proyecto_id'] = $_POST['proyecto'];

?>
