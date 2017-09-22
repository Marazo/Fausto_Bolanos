<?php
session_start();
include("conexion.php");

$usuario = $_POST['us'];
$pass = $_POST['clave'];
$encriptacion_pass = sha1($pass);

$scriptSQL = "select u.CI_USUARIO, r.NOMBRE_ROL from USUARIO u, ROL r where r.ID_ROL = u.ID_ROL and u.ALIAS_USUARIO ='".$usuario."' and u.CLAVE_USUARIO = '".$encriptacion_pass."'";

if ($result = mysqli_query($mysqli, $scriptSQL)) {

  if ($filas = mysqli_fetch_array($result))
  {
    $_SESSION['ci'] = $filas['CI_USUARIO'];
    $_SESSION['rol'] = $filas['NOMBRE_ROL'];

    echo "principal.php";
  }else {
    echo "1";
  }
}else {
  echo"ERROR scriptSQL";
}
 ?>