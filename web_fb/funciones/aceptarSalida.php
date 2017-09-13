<?php
include("../controladores/ingreso.php");
include("../controladores/consultas.php");
$consulta = new consultas();

$hoja = $_POST['hoja'];
$item = $_POST['item'];
$num = count($item);

$result = mysqli_query($mysqli, "select d.ID_BODEGA from HOJA_DE_CONTROL h, DESPACHO d WHERE h.ID_HOJA = d.ID_HOJA and h.ID_HOJA = ".$hoja." GROUP BY d.ID_BODEGA");
$filas = mysqli_fetch_array($result);
$bodega = $filas['ID_BODEGA'];
$sql = "update DESPACHO d set d.SALIO = 1, d.FECHA_DESPACHO = CURRENT_DATE() where d.ID_HOJA = ".$hoja;

mysqli_query($mysqli, $sql);
for ($i=0; $i < $num; $i++) {
  mysqli_query($mysqli, "insert into DETALLE_DESPACHO (CI_USUARIO, ID_BODEGA, ID_ITEM, ID_HOJA)
  values('".$ci."', ".$bodega.", ".$item[$i].", ".$hoja.")");
}
?>
