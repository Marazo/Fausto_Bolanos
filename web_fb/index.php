<!DOCTYPE html>
<html lang="es-EC">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-signal.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


  <head>
    <meta charset="utf-8">
    <title>Inicio</title>
  </head>
  <body>
    <div class="w3-container w3-wide w3-center">
      <h2>INICIO SESION</h2>
      <div class="w3-container w3-border w3-large">
        <form method="post">
          USUARIO <br>
          <input type="text" name="usuario" id="usuario"><br>
          CONTRASEÑA <br>
          <input type="password" name="clave" id="clave"><br><br>
          <button type="button" name="aceptar" id="aceptar" class="w3-button w3-signal-red w3-round-xxlarge"
          onclick="aceptar()">Aceptar</button>
          <p class="w3-text-red" id="txt"></p>
        </form>
      </div>
    </div>

    <script type="text/javascript">
      $( document ).ready(function() {

        $( "#aceptar" ).click(function() {

        var contrasena = $("#clave").val();
        var nombre_usuario = $("#usuario").val();

        if (contrasena != '' && nombre_usuario != '') {

          $.ajax({
            url: 'controladores/login.php',
            type: 'POST', // performing a POST request
            data : {
              us : $("#usuario").val(),
              clave : $("#clave").val()
            },
            success: function(respuesta)
            {
              if (respuesta == "1") {
                $("#txt").text("USUARIO O CONTRASENA INCORRECTOS");
              }else {
                window.location = respuesta;
              }
            }
          });

        }else {
          $("#txt").text("INGRESO LOS DATOS PORFABOR");
        }

    });

  });
    </script>

  </body>
</html>
