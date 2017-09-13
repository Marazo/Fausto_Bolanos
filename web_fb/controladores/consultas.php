<?php
/**
 *
 */
class consultas
{
  private $miScript;

  function sqlDetalleBodega($bodega, $categoria){

    if ($bodega == '1' && $categoria == '1') {
      $miScript = "select b.NOMBRE_BODEGA, m.NOMBRE_ITEM, d.CANTIDAD from BODEGA
      b, MAQUINARIA_MATERIALES m, DETALLE_BODEGA d where b.ID_BODEGA = d.ID_BODEGA
      and m.ID_ITEM = d.ID_ITEM order by m.NOMBRE_ITEM";
      return $miScript;
    }if ($categoria == '1') {
      $miScript = "select b.NOMBRE_BODEGA, m.NOMBRE_ITEM, d.CANTIDAD, c.NOMBRE_CATEGORIA,
      u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD, m.ID_ITEM from BODEGA b, MAQUINARIA_MATERIALES m, DETALLE_BODEGA d,
      CATEGORIA c, UNIDAD u WHERE b.ID_BODEGA = d.ID_BODEGA and m.ID_ITEM = d.ID_ITEM
      and m.ID_CATEGORIA = c.ID_CATEGORIA and m.ID_UNIDAD = u.ID_UNIDAD and b.NOMBRE_BODEGA ='".utf8_encode($bodega)."' order by m.NOMBRE_ITEM";
      return $miScript;
    } if($bodega == '1'){
      $miScript = "select b.NOMBRE_BODEGA, m.NOMBRE_ITEM, d.CANTIDAD from BODEGA
      b, MAQUINARIA_MATERIALES m, DETALLE_BODEGA d where b.ID_BODEGA = d.ID_BODEGA
      and m.ID_ITEM = d.ID_ITEM and m.ID_CATEGORIA = (select c.ID_CATEGORIA from categoria c where c.NOMBRE_CATEGORIA = '".$categoria."')
      order by m.NOMBRE_ITEM";
      return $miScript;
    }else {
      $miScript = "select b.NOMBRE_BODEGA, m.NOMBRE_ITEM, d.CANTIDAD from BODEGA
      b, MAQUINARIA_MATERIALES m, DETALLE_BODEGA d where b.ID_BODEGA = d.ID_BODEGA
      and m.ID_ITEM = d.ID_ITEM and b.NOMBRE_BODEGA ='".utf8_encode($bodega)."'
      and m.ID_CATEGORIA = (select c.ID_CATEGORIA from categoria c where c.NOMBRE_CATEGORIA = '".utf8_encode($categoria)."') order by m.NOMBRE_ITEM";
      return $miScript;
    }
  }//function sqlDetalleBodega

  function sqlDetalleBodegaID($bodega){
    $miScript="select m.ID_ITEM, m.NOMBRE_ITEM, u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD, c.NOMBRE_CATEGORIA, d.CANTIDAD
    from DETALLE_BODEGA d, BODEGA b, MAQUINARIA_MATERIALES m, UNIDAD u, CATEGORIA c
    WHERE b.ID_BODEGA = d.ID_BODEGA and d.ID_ITEM = m.ID_ITEM and c.ID_CATEGORIA = m.ID_CATEGORIA and u.ID_UNIDAD = m.ID_UNIDAD
    and b.ID_BODEGA = '".utf8_encode($bodega)."'
    ORDER by m.NOMBRE_ITEM";
    return $miScript;
  }

  function sqlDetalleProyectoID($id){
    $miScript = "select m.NOMBRE_ITEM, u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD, c.NOMBRE_CATEGORIA, SUM(d.CANTIDAD_DESPACHO), m.ID_ITEM
    FROM PROYECTO p, HOJA_DE_CONTROL h, RECEPCION r, DESPACHO d, MAQUINARIA_MATERIALES m, UNIDAD u, CATEGORIA c
    WHERE d.ID_HOJA = h.ID_HOJA and m.ID_ITEM = d.ID_ITEM and r.ID_HOJA = h.ID_HOJA and p.ID_PROYECTO = r.ID_PROYECTO
    and u.ID_UNIDAD = m.ID_UNIDAD and m.ID_CATEGORIA = c.ID_CATEGORIA and p.ID_PROYECTO = ".$id."
    GROUP BY m.ID_ITEM";
    return $miScript;
  }

  function sqlBodega($id){
    $miScript = "select b.ID_BODEGA, b.NOMBRE_BODEGA, d.CALLE_PRINCIPAL, d.CALLE_SECUNDARIA,
    d.NUMERO, d.REFERENCIAS, c.NOMBRE_CIUDAD from BODEGA b, direccion d, ciudad c where
    b.ID_DIRECCION = d.ID_DIRECCION and d.ID_CIUDAD = c.ID_CIUDAD and b.ID_BODEGA like '".$id."%'";
    return $miScript;
  }//function sqlBodega

  function sqlCategoria(){
    $miScript = "select c.NOMBRE_CATEGORIA, c.ID_CATEGORIA from CATEGORIA c order by c.NOMBRE_CATEGORIA";
    return $miScript;
  }

  function sqlDespacho(){
    $miScript = "select h.ID_HOJA, u.APELLIDI_DUENO, u.NOMBRE_DUENO, h.PLACAS, b.NOMBRE_BODEGA
    from DESPACHO d, HOJA_DE_CONTROL h, DUENO u, VEICULO v, DETALLE_BODEGA de, BODEGA b
    where d.ID_HOJA = h.ID_HOJA and h.CI_DUENO = u.CI_DUENO and h.PLACAS = v.PLACAS
    and d.ID_BODEGA = de.ID_BODEGA and b.ID_BODEGA = de.ID_BODEGA and d.SALIO = 0
    GROUP BY  h.ID_HOJA";
    return $miScript;
  }

  function sqlRecepcion(){
    $miScript = "select h.ID_HOJA, d.NOMBRE_DUENO, d.APELLIDI_DUENO, v.PLACAS, p.NOMBRE_PROYECTO
    from RECEPCION r, HOJA_DE_CONTROL h, VEICULO v, DUENO d, PROYECTO p
    WHERE r.ID_HOJA = h.ID_HOJA and v.PLACAS = h.PLACAS and d.CI_DUENO = h.CI_DUENO
    and r.ID_PROYECTO = p.ID_PROYECTO and r.RESIVIO = 0";
    return $miScript;
  }

  function sqlRecepcionInfo($id){
    $miScript = "select u.NOMBRE_USUARIO, u.APELLIDO_USUARIO, p.NOMBRE_PROYECTO, v.PLACAS, d.NOMBRE_DUENO, d.APELLIDI_DUENO
    from DETALLE_RECEPCION dr, USUARIO u, PROYECTO p, HOJA_DE_CONTROL h, DUENO d, VEICULO v
    WHERE dr.ID_PROYECTO = p.ID_PROYECTO and dr.CI_USUARIO = u.CI_USUARIO and h.ID_HOJA = dr.ID_HOJA
    and h.PLACAS = v.PLACAS and h.CI_DUENO = d.CI_DUENO and h.ID_HOJA = ".$id;
    return $miScript;
  }

  function sqlDespachoInfo($id){
    $miScript = "select u.NOMBRE_USUARIO, u.APELLIDO_USUARIO, b.NOMBRE_BODEGA
    from DETALLE_DESPACHO dd, USUARIO u, BODEGA b, HOJA_DE_CONTROL h
    WHERE dd.ID_BODEGA = b.ID_BODEGA and dd.ID_HOJA = h.ID_HOJA and dd.CI_USUARIO = u.CI_USUARIO
    and h.ID_HOJA = ".$id." GROUP BY h.ID_HOJA";
    return $miScript;
  }

  function sqlDespachoID($hoja){
    $miScript = "select m.NOMBRE_ITEM, m.ID_ITEM, d.CANTIDAD_DESPACHO, c.NOMBRE_CATEGORIA, u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD
    from HOJA_DE_CONTROL h, DESPACHO d, MAQUINARIA_MATERIALES m, UNIDAD u, CATEGORIA c
    WHERE d.ID_HOJA = h.ID_HOJA and d.ID_ITEM = m.ID_ITEM and u.ID_UNIDAD = m.ID_UNIDAD
    and c.ID_CATEGORIA = m.ID_CATEGORIA and h.ID_HOJA = ".$hoja." ";
    return $miScript;
  }

  function sqlCambioBodega($id, $nombre, $calleP, $calleC, $numero, $referencias){
    $miScript = "update DIRECCION set DIRECCION.CALLE_PRINCIPAL = '".$calleP."', DIRECCION.CALLE_SECUNDARIA = '".$calleC."',
    DIRECCION.NUMERO = '".$numero."', DIRECCION.REFERENCIAS = '".$referencias."'
    WHERE DIRECCION.ID_DIRECCION = (SELECT b.ID_DIRECCION FROM bodega b WHERE b.ID_BODEGA = '".$id."')";
    return $miScript;
  }

  function sqlCambioUsuario($nombre, $apellido, $alias, $telefono, $ci){
      $miScript = "update USUARIO u set u.NOMBRE_USUARIO = '".$nombre."',
      u.APELLIDO_USUARIO = '".$apellido."', u.ALIAS_USUARIO = '".$alias."',
      u.TELEFONO_USUARIO = '".$telefono."' where u.CI_USUARIO ='".$ci."'";
      return $miScript;

  }

  function sqlCambioClave($clave, $ci, $antigua){
      $miScript = "update USUARIO u set u.CLAVE_USUARIO = sha1('".$clave."') where
      u.CI_USUARIO = '".$ci."' and u.CLAVE_USUARIO = sha1('".$antigua."')";
      return $miScript;
  }

  function sqlUnidad(){
    $miScript = "select u.ID_UNIDAD, u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD from UNIDAD u";
    return $miScript;
  }

  function sqlProyecto(){
    $miScript = "select p.ID_PROYECTO, p.NOMBRE_PROYECTO, c.NOMBRE_CIUDAD, d.CALLE_PRINCIPAL,
    d.CALLE_SECUNDARIA, d.NUMERO FROM PROYECTO p, DIRECCION d, CIUDAD c
    where d.ID_DIRECCION = p.ID_DIRECCION and d.ID_CIUDAD = c.ID_CIUDAD";
    return $miScript;
  }

  function sqlProyectoID($id){
    $miScript = "select p.NOMBRE_PROYECTO, c.NOMBRE_CIUDAD, d.CALLE_PRINCIPAL, d.CALLE_SECUNDARIA, d.NUMERO
    FROM PROYECTO p, DIRECCION d, CIUDAD c
    where d.ID_DIRECCION = p.ID_DIRECCION and d.ID_CIUDAD = c.ID_CIUDAD
    and p.ID_PROYECTO = ".$id;
    return $miScript;
  }

  function sqlItemBodega($id){
    $miScript = "select m.ID_ITEM, m.NOMBRE_ITEM, u.NOMBRE_UNIDAD, c.NOMBRE_CATEGORIA
FROM CATEGORIA c, UNIDAD u, MAQUINARIA_MATERIALES m
WHERE m.ID_UNIDAD = u.ID_UNIDAD and m.ID_CATEGORIA = c.ID_CATEGORIA and
m.ID_ITEM NOT IN (SELECT d.ID_ITEM FROM DETALLE_BODEGA d WHERE d.ID_BODEGA = ".$id.")";
    return $miScript;
  }

  function sqlItem(){
    $miScript = "select m.ID_ITEM, m.NOMBRE_ITEM, u.NOMBRE_UNIDAD, c.NOMBRE_CATEGORIA
    FROM CATEGORIA c, UNIDAD u, MAQUINARIA_MATERIALES m
    WHERE m.ID_UNIDAD = u.ID_UNIDAD and m.ID_CATEGORIA = c.ID_CATEGORIA";
    return $miScript;
  }

  function sqlCiudad(){
    $miScript = "select c.NOMBRE_CIUDAD, c.ID_CIUDAD from CIUDAD c";
    return $miScript;
  }

  function sqlAgregarDetalleBodega($bodega, $item){
    $miScript = "insert into DETALLE_BODEGA (ID_BODEGA, ID_ITEM, CANTIDAD) values ('".$bodega."','".$item."', 0)";
    return $miScript;
  }

  function sqlUsuario(){
    $miScript = "select u.CI_USUARIO, u.NOMBRE_USUARIO, u.APELLIDO_USUARIO, u.ALIAS_USUARIO, u.TELEFONO_USUARIO, r.NOMBRE_ROL
from USUARIO u, ROL r WHERE r.ID_ROL = u.ID_ROL";
    return $miScript;
  }

  function sqlDueno(){
    $miScript = "select d.CI_DUENO, d.NOMBRE_DUENO, d.APELLIDI_DUENO, d.TELEFONO from DUENO d ORDER BY d.APELLIDI_DUENO";
    return $miScript;
  }

  function sqlVeiculo(){
    $miScript = "select v.PLACAS from VEICULO v ORDER by v.PLACAS";
    return $miScript;
  }

  function sqlTransporte()
  {
    $miScript = "select d.NOMBRE_DUENO, d.APELLIDI_DUENO, d.TELEFONO, v.PLACAS
    from TRANSPORTE t, DUENO d, VEICULO v
    WHERE d.CI_DUENO = t.CI_DUENO and v.PLACAS = t.PLACAS and t.DUENO_TRANSPORTE = 1
    ORDER by v.PLACAS";
    return $miScript;
  }

  function sqlRol(){
    $miScript = "select r.NOMBRE_ROL, r.ID_ROL from ROL r";
    return $miScript;
  }

  function sqlHojaDeControl(){
    $miScript = "select h.ID_HOJA, b.NOMBRE_BODEGA, p.NOMBRE_PROYECTO, h.FECHA_HOJA
    FROM HOJA_DE_CONTROL h, RECEPCION r, DESPACHO d, BODEGA b, PROYECTO p
    WHERE h.ID_HOJA = r.ID_HOJA and h.ID_HOJA = d.ID_HOJA and d.ID_BODEGA = b.ID_BODEGA
    and r.ID_PROYECTO = p.ID_PROYECTO and d.SALIO = 1 and r.RESIVIO = 1
    GROUP By h.ID_HOJA;";
    return $miScript;
  }

  function sqlAgregarProyecto($calleP, $calleC, $numero, $referencias, $ciudad, $nombre, $tipo){
    $miScript = "call incertar_".$tipo." ('".$calleP."', '".$calleC."', '".$numero."',
    '".$referencias."', ".$ciudad.", '".$nombre."')";
    return $miScript;
  }

  function sqlAgregarCiudadCategoria($nombre, $tipo){
    $miScript = "insert into ".$tipo." (NOMBRE_".$tipo.") VALUES ('".$nombre."')";
    return $miScript;
  }

  function sqlAgregarUnidad($nombre, $abrebiatura){
    $miScript = "insert into UNIDAD (NOMBRE_UNIDAD, ABREBIATURA_UNIDAD) values ('".$nombre."', '".$abrebiatura."')";
    return $miScript;
  }

  function sqlAgregarItem($nombre, $unidad, $categoria){
    $miScript = "insert into MAQUINARIA_MATERIALES (ID_UNIDAD, ID_CATEGORIA, NOMBRE_ITEM) VALUES ('".$unidad."', '".$categoria."', '".$nombre."')";
    return $miScript;
  }

  function sqlAgregarUsuario($ci, $nombre, $apellido, $telefono, $usuario, $clave, $tipo){
    $miScript = "insert into usuario (CI_USUARIO, NOMBRE_USUARIO, APELLIDO_USUARIO, TELEFONO_USUARIO, ALIAS_USUARIO, CLAVE_USUARIO, ID_ROL)
    VALUES ('".$ci."', '".$nombre."', '".$apellido."', '".$telefono."', '".$usuario."', SHA1('".$clave."'), '".$tipo."')";
    return $miScript;
  }

  function sqlAgregarHoja($ci, $dueno, $placas){
    $miScript = "insert into HOJA_DE_CONTROL (CI_USUARIO, CI_DUENO, PLACAS, FECHA_HOJA)
    VALUES ('".$ci."', '".$dueno."', '".$placas."', CURDATE())";
    return $miScript;
  }

  function sqlAgregarDespacho($bodega, $item, $hoja, $cantidad){
    $miScript = "insert INTO DESPACHO (ID_BODEGA, ID_ITEM, ID_HOJA, FECHA_DESPACHO, CANTIDAD_DESPACHO, SALIO)
    VALUES ('".$bodega."', '".$item."', '".$hoja."', CURDATE(), ".$cantidad.", 0)";
    return $miScript;
  }

  function sqlAgregarRecepcion($proyecto, $hoja){
    $miScript = "insert INTO RECEPCION (ID_PROYECTO, ID_HOJA, FECHA_RECEPCION, RESIVIO)
    VALUES ('".$proyecto."', '".$hoja."', CURRENT_DATE(), '0')";
    return $miScript;
  }

  function sqlAgregarDueno($ci, $nombre, $apellido, $telefono){
    $miScript = "insert INTO DUENO (CI_DUENO, NOMBRE_DUENO, APELLIDI_DUENO, TELEFONO)
    VALUES ('".$ci."', '".$nombre."', '".$apellido."', '".$telefono."')";
    return $miScript;
  }

  function sqlAgregarautomovil($placas, $descripcion){
    $miScript = "insert into VEICULO (PLACAS, DESCRIPCION_VEICULO)
    VALUES ('".$placas."', '".$descripcion."')";
    return $miScript;
  }

  function sqlAgregarVeiculo($placas, $dueno){
    $miScript = "insert into TRANSPORTE (CI_DUENO, PLACAS, DUENO_TRANSPORTE)
    VALUES ('".$dueno."', '".$placas."', 1)";
    return $miScript;
  }

  function sqlActualizarCantidad($bodega, $item, $cantidad, $tipo){
    $miScript = "update DETALLE_BODEGA set CANTIDAD = (CANTIDAD ".$tipo." ".$cantidad.") where DETALLE_BODEGA.ID_BODEGA = ".$bodega." and DETALLE_BODEGA.ID_ITEM = ".$item." ";
    return $miScript;
  }

}

 ?>
