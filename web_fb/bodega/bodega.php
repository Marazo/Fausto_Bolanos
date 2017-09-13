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
      window.location = "../ordenes/ordenes.php";
    });
    $("#ajustes").click(function(){
      window.location = "../ajustes/ajustes.php";
    });

    $(".tabla").click(function(){
      document.getElementById("tabla").style.display = "block";
      document.getElementById("agregar").style.display = "none";
      document.getElementById("manejo").style.display = "none";
    });
    $(".agregar").click(function(){
      document.getElementById("tabla").style.display = "none";
      document.getElementById("agregar").style.display = "block";
      document.getElementById("manejo").style.display = "none";
    });
    $(".manejo").click(function(){
      document.getElementById("tabla").style.display = "none";
      document.getElementById("agregar").style.display = "none";
      document.getElementById("manejo").style.display = "block";
    });

    $(".agregarBodega").click(function(){
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
          tipo: "bodega"
        },
        success: function(respuesta){
          window.location = "bodega.php";
        }
      });
    });

    $(".boton").click(function(){

      var valores= $(this).parents("tr").find("td").html();

      $.ajax({
        url: '../controladores/bodega.php',
        type: 'POST',
        data: { bodega: valores },
        success: function(respuesta){
          window.location = 'manejobodega.php';
        }
      });
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

      <button class="w3-button w3-round-xxlarge w3-white tabla">Stock</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="w3-button w3-round-xxlarge w3-white agregar">Agregar Bodega</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button class="w3-button w3-round-xxlarge w3-white manejo">Manejo de Bodega</button><br><br>

      <div style="display:block" id="tabla">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <select class="w3-button w3-white w3-border w3-round-large" name="categorias">
                <option value="1">TODAS LAS CATEGORIAS</option>
                <?php if ($result = mysqli_query($mysqli, $consulta->sqlCategoria())) {
                  while ($filas = mysqli_fetch_array($result)) {
                    echo "
                      <option value='".utf8_encode($filas['NOMBRE_CATEGORIA'])."'>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</option>";
                  }
                } ?>
          </select>

          <select class="w3-button w3-white w3-border w3-round-large" name="bodegas">
                <option value="1">TODAS LAS BODEGAS</option>
                <?php if ($result = mysqli_query($mysqli, $consulta->sqlBodega(''))) {
                  while ($filas = mysqli_fetch_array($result)) {
                    echo "
                      <option value='".utf8_encode($filas['NOMBRE_BODEGA'])."'>".utf8_encode($filas['NOMBRE_BODEGA'])."</option>";
                  }
                } ?>
          </select>

          <input type="submit" name="submit" value="Aceptar" class="w3-button w3-round-xxlarge w3-signal-black">

        </form><br>

        <table class="w3-table w3-bordered w3-animate-top w3-striped w3-centered">
          <tr class="w3-signal-black">
            <th>BODEGA</th>
            <th>MATERIAL/MAQUINARIA</th>
            <th>CANTIDAD</th>
          </tr>
          <?php

          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }

          $bodega = '';
          $categoria = '';

          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $bodega = test_input($_POST['bodegas']);
            $categoria = test_input($_POST['categorias']);
          }

          if ($result = mysqli_query($mysqli, $consulta->sqlDetalleBodega($bodega, $categoria))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th>".utf8_encode($filas['NOMBRE_BODEGA'])."</th>
                <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                <th>".utf8_encode($filas['CANTIDAD'])."</th>
              </tr>
              ";
            }
          }
           ?>
        </table>
      </div>

      <div style="display:none" id="agregar" class="w3-animate-left">
        <h6>Bodega</h6>
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

        <button type="button" class="w3-button w3-round-xxlarge w3-signal-black agregarBodega">Aceptar</button>

      </div>

      <div style="display:none" id="manejo">
        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th>ID</th>
            <th>Bodega</th>
            <th>Ciudad</th>
            <th>Direccion</th>
            <th></th>
          </tr>
          <?php

          if ($result = mysqli_query($mysqli, $consulta->sqlBodega(''))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <td>".$filas['ID_BODEGA']."</td>
                <th>".utf8_encode($filas['NOMBRE_BODEGA'])."</th>
                <th>".utf8_encode($filas['NOMBRE_CIUDAD'])."</th>
                <th>".utf8_encode($filas['CALLE_PRINCIPAL'])." y ".utf8_encode($filas['CALLE_SECUNDARIA'])." ".utf8_encode($filas['NUMERO'])."</th>
                <th class='boton'><u class='w3-bar-item w3-button'>Seleccionar</u></th>
              </tr>";
            }
          }

           ?>
        </table>
      </div>

    </div>
  </body>
</html>
