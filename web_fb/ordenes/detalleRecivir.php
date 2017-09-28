<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

$hoja = $_SESSION['hoja_de_control'];

 ?>

<!DOCTYPE html>

<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-signal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#cerrar").click(function(){
      window.location = "../controladores/logout.php";
    });
    $("#principal").click(function(){
      window.location = "../principal.php";
    });
    $("#bodega").click(function(){
      window.location = "../bodega/bodega.php";
    });
    $("#proyectos").click(function(){
      window.location = "../proyectos/proyectos.php";
    });
    $("#ordenes").click(function(){
      window.location = "ordenes.php";
    });
    $("#ajustes").click(function(){
      window.location = "../ajustes/ajustes.php";
    });
    $("#realizar").click(function(){
      window.location = "realizar.php";
    });
    $("#salir").click(function(){
      window.location = "salir.php";
    });
    $("#recivir").click(function(){
      window.location = "recivir.php";
    });
    $("#hojaControl").click(function(){
      window.location = "hojaControl.php";
    });
    $(".aceptar").click(function(){
      if (confirm("Decea aceptar la salidad de los materiales") == true) {
        var hojaControl = $( "b:first" ).text();
        var observacion = $("#observaciones").val();
        $.ajax({
          url: '../funciones/aceptarEntrega.php',
          type: 'POST',
          data: { hoja: hojaControl, ob: observacion},
          success: function(respuesta){
            window.location = "recivir.php";
          }
        });
    } else {
        window.location = "recivir.php";
    }
    });
  });
</script>


  <head>
    <meta charset="utf-8">
    <title>Ordenes</title>
  </head>
  <body>
    <div class="w3-bar w3-signal-red">
      <button class="w3-bar-item w3-button" id="principal">Inicio</button>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
      <button class="w3-bar-item w3-button" id="bodega">Bodega</button>
      <?php } ?>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
      <button class="w3-bar-item w3-button" id="proyectos">Proyectos</button>
      <?php } ?>
      <button class="w3-bar-item w3-button" id="ordenes">Ordenes</button>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO') {?>
      <button class="w3-bar-item w3-button" id="ajustes">Ajustes</button>
      <?php } ?>
      <button class="w3-bar-item w3-button" id="cerrar">Cerrar seci&oacute;n</button>
    </div><br><br>

    <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
    <button type="button" id="realizar" class="w3-button w3-round-xxlarge w3-white">Reaalizar Orden</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php } ?>
    <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE' || $_SESSION['rol'] == 'BODEGA/OBRA' || $_SESSION['rol'] == 'BODEGA') {?>
    <button type="button" id="salir" class="w3-button w3-round-xxlarge w3-white">Ordenes en Bodega</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php } ?>
    <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE' || $_SESSION['rol'] == 'BODEGA/OBRA' || $_SESSION['rol'] == 'OBRA') {?>
    <button type="button" id="recivir" class="w3-button w3-round-xxlarge w3-white">Ordenes en Obra</button>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php } ?>
    <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
    <button type="button" id="hojaControl" class="w3-button w3-round-xxlarge w3-white">Hoja de Control</button>
    <?php } ?>

      <h6>Numero de orden : <b><?php echo $hoja; ?></b></h6>

      <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th>ITEM</th>
            <th>UNIDAD</th>
            <th>CATEGORIA</th>
            <th>CANTIDAD</th>
          </tr>
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlDespachoID($hoja))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</th>
                <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
                <th>".$filas['CANTIDAD_DESPACHO']."</th>
              </tr>";
            }
          }
          ?>
        </table><br><br>
        <textarea id="observaciones" placeholder="Obserbaciones" rows="5" cols="50"></textarea>
      </div>

      <button type="button" name="button" class="w3-button w3-signal-black w3-bottom aceptar" >Aceptar Entrega</button>

    </div>
  </body>
</html>
