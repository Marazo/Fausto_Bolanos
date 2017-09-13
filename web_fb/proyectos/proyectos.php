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
    window.location = "proyectos.php";
  });
  $("#ordenes").click(function(){
    window.location = "../ordenes/ordenes.php";
  });
  $("#ajustes").click(function(){
    window.location = "../ajustes/ajustes.php";
  });
  $("#agregarProyecto").click(function(){
    document.getElementById("tabla").style.display = "none";
    document.getElementById("formularioProyecto").style.display = "block";
  });

  $(".boton").click(function(){
    var valores = $(this).parents("tr").find("td").html();
    $.ajax({
      url: '../controladores/proyecto.php',
      type: 'POST',
      data: { proyecto: valores},
      success: function(){
        window.location = "detalleProyecto.php";
      }
    });
  });

  $(".agregar").click(function(){
    $.ajax({
      url: '../funciones/agregar/agregarProyecto.php',
      type: 'POST',
      data:{
        nombre: $(".nombre").val(),
        calleP: $(".calleP").val(),
        calleC: $(".calleC").val(),
        numero: $(".numero").val(),
        ciudad: $(".ciudad").val(),
        referencias: $(".referencias").val(),
        tipo: "proyecto"
      },
      success: function(respuesta){
        window.location = "proyectos.php";
      }
    });
  });
});
</script>

  <head>
    <meta charset="utf-8">
    <title>Proyectos</title>
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

      <button type="button" id="agregarProyecto" class="w3-button w3-round-xxlarge w3-white">Agregar Proyecto</button><br><br>

      <div style="display:block" id="tabla">
        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th style='display:none'></th>
            <th>Proyectos</th>
            <th>Ciudad</th>
            <th>Direccion</th>
            <th></th>
          </tr>
          <?php

          if ($result = mysqli_query($mysqli, $consulta->sqlProyecto())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <td style='display:none'>".$filas['ID_PROYECTO']."</td>
                <th>".utf8_encode($filas['NOMBRE_PROYECTO'])."</th>
                <th>".utf8_encode($filas['NOMBRE_CIUDAD'])."</th>
                <th>".utf8_encode($filas['CALLE_PRINCIPAL'])." y ".utf8_encode($filas['CALLE_SECUNDARIA'])." ".utf8_encode($filas['NUMERO'])."</th>
                <th class='boton'><u class='w3-bar-item w3-button'>Seleccionar</u></th>
              </tr>";
            }
          }

           ?>
        </table>
      </div>

      <div id="formularioProyecto" style="display:none" class="w3-animate-left">
        <h6>Proyecto</h6>
        <input type="text" class="nombre" placeholder="Nombre" onKeyUp="this.value=this.value.toUpperCase();">
        <h6>Direccion</h6>
        <input type="text" class="calleP" placeholder="Calle principal" onKeyUp="this.value=this.value.toUpperCase();"><br><br>
        <input type="text" class="calleC" placeholder="Calle secundaria" onKeyUp="this.value=this.value.toUpperCase();"><br><br>
        <input type="text" class="numero" placeholder="Numeración"><br><br>
        <textarea class="referencias" rows="5" cols="40" placeholder="Referencias" onKeyUp="this.value=this.value.toUpperCase();"></textarea>
        <h6>Ciudad</h6>
        <select class="w3-button w3-white w3-border ciudad" name="ciudad">
            <option value=""></option>
            <?php
              if ($result = mysqli_query($mysqli, $consulta->sqlCiudad())) {
                while ($filas = mysqli_fetch_array($result)) {
                  echo "
                  <option value='".utf8_encode($filas['ID_CIUDAD'])."'>".utf8_encode($filas['NOMBRE_CIUDAD'])."</option>";
                }
              }
             ?>
        </select><br><br>

        <button type="button" class="w3-button w3-round-xxlarge w3-signal-black agregar">Aceptar</button>

      </div>

    </div>
  </body>
</html>
