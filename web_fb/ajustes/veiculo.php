<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

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
      window.location = "../ordenes/ordenes.php";
    });
    $("#agustes").click(function(){
      window.location = "ajustes.php";
    });

    $(".unidad").click(function(){
      window.location = "unidad.php";
    });
    $(".categoria").click(function(){
      window.location = "categorias.php";
    });
    $(".item").click(function(){
      window.location = "item.php";
    });
    $(".ciudad").click(function(){
      window.location = "ciudad.php";
    });
    $(".usuario").click(function(){
      window.location = "usuario.php";
    });
    $(".veiculo").click(function(){
      window.location = "veiculo.php"
    });

    $(".tablaDueno").click(function(){
      document.getElementById("tablaDueno").style.display = "block";
      document.getElementById("tablaVeiculos").style.display = "none";
    });
    $(".tablaVeiculos").click(function(){
      document.getElementById("tablaDueno").style.display = "none";
      document.getElementById("tablaVeiculos").style.display = "block";
    });

    $(".dueno").click(function(){
      $.ajax({
        url: "../funciones/agregar/agregarDueno.php",
        type: "POST",
        data: {
          ci: $(".cedula").val(),
          nombre: $(".nombre").val(),
          apellido: $(".apellido").val(),
          telefono: $(".telefono").val()
        },
        success: function(respuesta){
          window.location = "veiculo.php";
        }
      });
    });
    $(".veiculo").click(function(){
      $.ajax({
        url: "../funciones/agregar/agregarVeiculo.php",
        type: "POST",
        data: {
          placas: $(".placas").val(),
          descripcion: $(".descripcion").val(),
          dueno: $(".ci").val()
        },
        success: function(respuesta){
          if (respuesta = 'no') {
            alert("FALTAN DATOS");
          }else if (espuesta = 'si') {
            window.location = "veiculo.php";
          }
        }
      });
    });
  });
</script>

  <head>
    <meta charset="utf-8">
    <title>Ajustes</title>
  </head>
  <body>
    <div class="w3-container w3-wide">
      <div class="w3-bar w3-top w3-signal-red">
        <button class="w3-bar-item w3-button" id="principal">Inicio</button>
        <button class="w3-bar-item w3-button" id="bodega">Bodega</button>
        <button class="w3-bar-item w3-button" id="proyectos">Proyectos</button>
        <button class="w3-bar-item w3-button" id="ordenes">Ordenes</button>
        <button class="w3-bar-item w3-button" id="agustes">Ajustes</button>
        <button class="w3-bar-item w3-button" id="cerrar">Cerrar seci&oacute;n</button>
      </div><br><br>

      <button class="w3-button w3-round-xxlarge w3-white unidad">Unidades</button>
      <button class="w3-button w3-round-xxlarge w3-white categoria">Categorias</button>
      <button class="w3-button w3-round-xxlarge w3-white item">Maquinaria Materiales</button>
      <button class="w3-button w3-round-xxlarge w3-white ciudad">Ciudades</button>
      <button class="w3-button w3-round-xxlarge w3-white usuario">Usuarios</button>
      <button class="w3-button w3-round-xxlarge w3-white veiculo">Veiculo</button><br><br>

      <h6>CHOFER O DUE&Ntilde;O:</h6>
      <input type="text" class="cedula"  placeholder="CI">
      <input type="text" class="nombre"  placeholder="Nombre" onKeyUp="this.value=this.value.toUpperCase();">
      <input type="text" class="apellido"  placeholder="Apellido" onKeyUp="this.value=this.value.toUpperCase();">
      <input type="number" class="telefono" placeholder="Telefono"><br><br>
      <button class="w3-button w3-round-xxlarge w3-signal-black dueno">Aceptar</button>

      <h6>VEICULO:</h6>
      <input type="text" class="placas"  placeholder="Placas">
      <select class="w3-button w3-white w3-border w3-round-large ci" name="ci">
        <option value="">Due&ntilde;o</option>
        <?php  if ($result = mysqli_query($mysqli, $consulta->sqlDueno())) {
          while ($filas = mysqli_fetch_array($result)) {
            echo "
            <option value='".$filas['CI_DUENO']."'>".utf8_encode($filas['APELLIDI_DUENO'])." ".utf8_encode($filas['NOMBRE_DUENO'])."</option>";
          }
        }?>
      </select><br><br>
      <textarea class="descripcion" placeholder="Descripción" rows="5" cols="50"></textarea><br><br>
      <button class="w3-button w3-round-xxlarge w3-signal-black veiculo">Aceptar</button><br><br>

      <div class="w3-display-container" style="height:75px;">
        <div class="w3-display-middle">
          <button class="w3-button w3-round-xxlarge w3-white tablaDueno">Choferes y Due&ntilde;os</button>
          <button class="w3-button w3-round-xxlarge w3-white tablaVeiculos">Veiculos</button>
        </div>
      </div>

      <div class="w3-responsive" id="tablaDueno" style="display:none">
        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Telefono</th>
          </tr>
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlDueno())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['NOMBRE_DUENO'])."</th>
                <th>".utf8_encode($filas['APELLIDI_DUENO'])."</th>
                <th>".utf8_encode($filas['TELEFONO'])."</th>
              </tr>
              ";
            }
          }
          ?>
        </table>
      </div>

      <div class="w3-responsive" id="tablaVeiculos" style="display:none">
        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th>veiculo</th>
            <th>Due&ntilde;o</th>
            <th>Telefono</th>
          </tr>
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlTransporte())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['PLACAS'])."</th>
                <th>".utf8_encode($filas['APELLIDI_DUENO'])." ".utf8_encode($filas['NOMBRE_DUENO'])."</th>
                <th>".utf8_encode($filas['TELEFONO'])."</th>
              </tr>
              ";
            }
          }
          ?>
        </table>
      </div>

    </div>
  </body>
  </html>