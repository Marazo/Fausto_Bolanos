<?php

include("controladores/ingreso.php");
include("controladores/consultas.php");

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
      window.location = "controladores/logout.php";
    });
    $("#principal").click(function(){
      window.location = "principal.php";
    });
    $("#bodega").click(function(){
      window.location = "bodega/bodega.php";
    });
    $("#proyectos").click(function(){
      window.location = "proyectos/proyectos.php";
    });
    $("#ordenes").click(function(){
      window.location = "ordenes/ordenes.php";
    });
    $("#ajustes").click(function(){
      window.location = "ajustes/ajustes.php";
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
      <h1><?php echo 'BIENVENIDO '.utf8_encode($filas['NOMBRE_USUARIO']).' '.utf8_encode($filas['APELLIDO_USUARIO']);?></h1>

      <button type="button" id="datos" class="w3-button w3-round-xxlarge w3-white">Cambiar datos personales</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" id="Cclave" class="w3-button w3-round-xxlarge w3-white">Cambiar clave</button>

      <form action="cambioDatosPersonales.php" method="post">
        <div style="display:none" id="datosPersonales" class="w3-animate-left">
          <h6>NOMBRE</h6>
          <input type="text" class="nombre" value="<?php echo utf8_encode($filas['NOMBRE_USUARIO']); ?>" onKeyUp="this.value=this.value.toUpperCase();">
          <h6>APELLIDO</h6>
          <input type="text" class="apellido" value="<?php echo utf8_encode($filas['APELLIDO_USUARIO']); ?>" onKeyUp="this.value=this.value.toUpperCase();">
          <h6>NOMBRE DE USUARIO</h6>
          <input type="text" class="alias" value="<?php echo utf8_encode($filas['ALIAS_USUARIO']); ?>">
          <h6>TELEFONO</h6>
          <input type="number" class="telefono" value="<?php echo utf8_encode($filas['TELEFONO_USUARIO']); ?>"><br><br>
          <button type="button" id="datosUsuario" class="w3-button w3-round-xxlarge w3-signal-black">Aceptar</button>
        </div>
      </form>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div style="display:none" id="cambioClave" class="w3-animate-left">
          <h6>ANTIGUA CLAVE</h6>
          <input type="password" class="antigua">
          <h6>NUEVA CLAVE</h6>
          <input type="password" class="clave"><br><br>
          <button type="button" id="datosClave" class="w3-button w3-round-xxlarge w3-signal-black">Aceptar</button>
          <p class="w3-text-red" id="txt"></p>
        </div>
      </form>

      <script type="text/javascript">

      $(document).ready(function(){
        $("#datosUsuario").click(function(){
          $.ajax({
            url:'funciones/cambioDatosPersonales.php',
            type: 'POST',
            data: {
              nombre: $(".nombre").val(),
              apellido: $(".apellido").val(),
              alias: $(".alias").val(),
              telefono: $(".telefono").val()
            },
            success: function(respuesta){
              window.location = respuesta;
            }
          });
        });

        $("#datosClave").click(function(){

          if ($(".clave").val() != '' && $(".antigua").val() != '') {
            $.ajax({
              url:'funciones/cambioClave.php',
              type: 'POST',
              data:{
                clave: $(".clave").val(),
                antigua: $(".antigua").val()
              },
              success: function(respuesta){
                if(respuesta == "no"){
                  $("#txt").text("CLAVE INCORRECTA");
                }if (respuesta == "si") {
                  $("#txt").text("LA CLAVE HA SIDO CAMBIADA CORRECTAMENTE");
                }
              }
            });
          } else {
            $("#txt").text("INGRESE LOS DATOS PORFABOR");
          }
        });
      });

      </script>

    </div>
  </body>
</html>