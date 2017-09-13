<!DOCTYPE html>
<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

$id = $_SESSION['Proyecto_id'];
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
      window.location = "proyectos.php";
    });
    $("#ordenes").click(function(){
      window.location = "../ordenes/ordenes.php";
    });
    $("#ajustes").click(function(){
      window.location = "../ajustes/ajustes.php";
    });
    $("#datos").click(function(){
      document.getElementById("datosPersonales").style.display = "block";
      document.getElementById("cambioClave").style.display = "none";
    });
    $("#Cclave").click(function(){
      document.getElementById("datosPersonales").style.display = "none";
      document.getElementById("cambioClave").style.display = "block";
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
      </div>

      <?php if ($result = mysqli_query($mysqli, $consulta->sqlProyectoID($id))) {
        while ($filas = mysqli_fetch_array($result)) {
          echo "<h1>".utf8_encode($filas['NOMBRE_PROYECTO'])."</h1>
                <p>".utf8_encode($filas['NOMBRE_CIUDAD']).", ".utf8_encode($filas['CALLE_PRINCIPAL'])." y
                ".utf8_encode($filas['CALLE_SECUNDARIA']).", ".utf8_encode($filas['NUMERO'])."</p>";
        }
      }  ?>

      <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-animate-top w3-striped w3-centered">
          <tr class="w3-signal-black">
            <th>ITEM</th>
            <th>UNIDAD</th>
            <th>CATEGORIA</th>
            <th>CANTIDAD</th>
          </tr>
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlDetalleProyectoID($id))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</th>
                <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
                <th>".$filas['SUM(d.CANTIDAD_DESPACHO)']."</th>
              </tr>";
            }
          }
          ?>
        </table>
      </div>


    </div>
  </body>
</html>
