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

    $(".aceptar").click(function(){
      $.ajax({
        url: "../funciones/agregar/agregarUsuario.php",
        type: "POST",
        data: {
          ci: $(".cedula").val(),
          nombre: $(".nombre").val(),
          apellido: $(".apellido").val(),
          telefono: $(".telefono").val(),
          usuario: $(".alias").val(),
          clave: $(".clave").val(),
          tipo: $(".rol").val()
        },
        success: function(respuesta){
          window.location = "usuario.php";
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

      <h6>DARTOS PERSONALES:</h6>
      <input type="text" class="cedula"  placeholder="CI">
      <input type="text" class="nombre"  placeholder="Nombre" onKeyUp="this.value=this.value.toUpperCase();">
      <input type="text" class="apellido"  placeholder="Apellido" onKeyUp="this.value=this.value.toUpperCase();">
      <input type="number" class="telefono" placeholder="Telefono">

      <h6>NOMBRE DE USUARIO:</h6>
      <input type="text" class="alias" placeholder="Nombre de usuario">
      <input type="password" class="clave" placeholder="Clave">

      <h6>TIPO DE USUARIO:</h6>
      <select class="w3-button w3-white w3-border rol" name="rol">
        <?php
            if ($result = mysqli_query($mysqli, $consulta->sqlRol())) {
              while ($filas = mysqli_fetch_array($result)) {
                echo "
                <option value='".$filas['ID_ROL']."'>".utf8_encode($filas['NOMBRE_ROL'])."</option>";
              }
            }
        ?>
      </select><br><br>
      <button class="w3-button w3-round-xxlarge w3-signal-black aceptar">Aceptar</button><br><br>

      <div class="w3-responsive">
        <table class="w3-table w3-bordered w3-animate-top">
          <tr class="w3-signal-black">
            <th>CI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Telefono</th>
            <th>Tipo</th>
          </tr>
          <?php
              if ($result = mysqli_query($mysqli, $consulta->sqlUsuario())) {
                while ($filas = mysqli_fetch_array($result)) {
                  echo "
                  <tr>
                    <th>".$filas['CI_USUARIO']."</th>
                    <th>".$filas['NOMBRE_USUARIO']."</th>
                    <th>".$filas['APELLIDO_USUARIO']."</th>
                    <th>".$filas['ALIAS_USUARIO']."</th>
                    <th>".$filas['TELEFONO_USUARIO']."</th>
                    <th>".utf8_encode($filas['NOMBRE_ROL'])."</th>
                  </tr>";
                }
              }
          ?>
        </table>
      </div>

    </div>
  </body>
  </html>