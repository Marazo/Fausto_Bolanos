<?php

include("conexion.php");
session_start();

$_SESSION['Item_id'] = $_POST['item'];

?>
