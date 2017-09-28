<?php
include("../controladores/ingreso.php");
include("../controladores/consultas.php");
$consulta = new consultas();

$hoja = $_POST['hoja'];
$observacion = $_POST['ob'];
$sql = "update RECEPCION d set d.RESIVIO = 1, d.FECHA_RECEPCION = CURRENT_DATE(), d.OBSERVACION_RECEPCION = '".utf8_encode($observacion)."' where d.ID_HOJA = '".$hoja."'";
$result = mysqli_query($mysqli, "select p.ID_PROYECTO from PROYECTO p, RECEPCION r, HOJA_DE_CONTROL h WHERE p.ID_PROYECTO = r.ID_PROYECTO and r.ID_HOJA = h.ID_HOJA and h.ID_HOJA = ".$hoja);
$filas = mysqli_fetch_array($result);
$proyecto = $filas['ID_PROYECTO'];

mysqli_query($mysqli, $sql);
mysqli_query($mysqli, "insert into DETALLE_RECEPCION (CI_USUARIO, ID_PROYECTO, ID_HOJA) values ('".$ci."', ".$proyecto.", ".$hoja.")");
?>
