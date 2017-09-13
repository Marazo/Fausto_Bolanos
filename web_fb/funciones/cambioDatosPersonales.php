<?php

include("../controladores/consultas.php");
include("../controladores/ingreso.php");
$consulta = new consultas();

$nombre = utf8_decode($_POST['nombre']);
$apellido = utf8_decode($_POST['apellido']);
$alias = utf8_encode($_POST['alias']);
$telefono = utf8_encode($_POST['telefono']);

mysqli_query($mysqli, $consulta->sqlCambioUsuario($nombre, $apellido, $alias, $telefono, $ci));

echo "principal.php";

 ?>
