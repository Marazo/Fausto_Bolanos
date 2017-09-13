<!DOCTYPE html>
<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

 ?>

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
  });
</script>


  <head>
    <meta charset="utf-8">
    <title>Principal</title>
  </head>
  <body>
    <div class="w3-container w3-wide">
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


    </div>
  </body>
</html>
