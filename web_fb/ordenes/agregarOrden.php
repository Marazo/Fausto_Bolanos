
<div class="w3-responsive">
  <table class="w3-table w3-bordered w3-animate-top w3-striped w3-centered">
    <tr class="w3-signal-black">
      <th></th>
      <th>ITEM</th>
      <th>UNIDAD</th>
      <th>CATEGORIA</th>
      <th>CANTIDAD</th>
      <th></th>
    </tr>

    <?php
    include("../controladores/ingreso.php");
    include("../controladores/consultas.php");

    $consulta = new consultas();

    $id = $_POST['id'];
    $_SESSION['tipo_de_orden'] = $_POST['tipo'];
    $tipo = $_SESSION['tipo_de_orden'];

    if ($_SESSION['tipo_de_orden'] == 'Bodegas') {
      if ($result = mysqli_query($mysqli, $consulta->sqlDetalleBodegaID($id))) {
        while ($filas = mysqli_fetch_array($result)) {
          echo "
          <tr class='w3-hover-green'>
            <th><input type='checkbox' class='w3-check' name='chk[]' value='".$filas['ID_ITEM']."'></th>
            <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
            <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</th>
            <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
            <th>".$filas['CANTIDAD']."</th>
            <th><input type='number' size='5' name='valor[".$filas['ID_ITEM']."]' value='0'></th>
          </tr>";
        }
      }
    }elseif ($_SESSION['tipo_de_orden'] == 'Proyectos') {
      if ($result = mysqli_query($mysqli, $consulta->sqlDetalleProyectoID($id))) {
        while ($filas = mysqli_fetch_array($result)) {
          echo "
          <tr class='w3-hover-green'>
            <th><input type='checkbox' class='w3-check' name='chk[]' value='".$filas['ID_ITEM']."'></th>
            <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
            <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</th>
            <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
            <th>".$filas['SUM(d.CANTIDAD_DESPACHO)']."</th>
            <th><input type='number' size='5' name='valor[".$filas['ID_ITEM']."]' value='0'></th>
          </tr>";
        }
      }
    }

    ?>

  </table>
    <input type="submit" name="aceptar" value="Aceptar" class="w3-button w3-signal-black w3-bottom">
</div>
