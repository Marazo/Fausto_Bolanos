<!DOCTYPE html>
<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();
$hoja = $_SESSION['hoja_de_control'];

 ?>

<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-signal.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#print").click(function(){
      window.print();
    });
  });
</script>


  <head>
    <meta charset="utf-8">
    <title>Principal</title>
  </head>
  <body>
    <div class="w3-container w3-wide">

      <button class="w3-button w3-white w3-bottom" id="print"><i class="material-icons w3-xxlarge">print</i></button>


      <h3>NUMERO DE ORDEN: <?php echo $hoja; ?></h3>

      <div class="w3-display-container" style="height:110px; width:750px;">
        <div class="w3-display-topleft">
          De: <?php if ($result = mysqli_query($mysqli, $consulta->sqlDespachoInfo($hoja))) {
            $filas = mysqli_fetch_array($result);
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($filas['NOMBRE_BODEGA'])."
            <br> Encargado: ".utf8_encode($filas['APELLIDO_USUARIO'])." ".utf8_encode($filas['NOMBRE_USUARIO']);
          } ?>
        </div>
        <div class="w3-display-topright">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlRecepcionInfo($hoja))) {
            $filas = mysqli_fetch_array($result);
            echo " A:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".utf8_encode($filas['NOMBRE_PROYECTO'])."
            <br> Encargado: ".utf8_encode($filas['APELLIDO_USUARIO'])." ".utf8_encode($filas['NOMBRE_USUARIO']);
          } ?>
        </div>
        <div class="w3-display-bottomleft">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlRecepcionInfo($hoja))) {
            $filas = mysqli_fetch_array($result);
            echo " Placas: ".utf8_encode($filas['PLACAS'])."
            <br> Chofer: ".utf8_encode($filas['APELLIDI_DUENO'])." ".utf8_encode($filas['NOMBRE_DUENO']);
          } ?>
        </div>
      </div><br><br>

      <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-animate-top w3-striped w3-centered">
          <tr class="w3-signal-black">
            <th>ITEM</th>
            <th>UNIDAD</th>
            <th>CANTIDAD</th>
          </tr>
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlDespachoID($hoja))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [".utf8_encode($filas['ABREBIATURA_UNIDAD'])."]</th>
                <th>".$filas['CANTIDAD_DESPACHO']."</th>
              </tr>";
            }
          }
          ?>
        </table>
      </div>
    </div>
  </body>
</html>
