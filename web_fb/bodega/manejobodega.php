<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");
?>

<!DOCTYPE html>

<?php

$consulta = new consultas();

$id_bodega = $_SESSION['id_bodega'];

if (isset($_POST['aceptar'])) {
  $arregloID = $_POST['id'];
  $arregloVALOR = $_POST['valor'];
  $num = count($arregloID);

  for ($i=0; $i < $num; $i++) {
    mysqli_query($mysqli, $consulta->sqlActualizarCantidad($id_bodega, $arregloID[$i], $arregloVALOR[$i], '+'));
  }
}

?>

<html>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-signal.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
      window.location = "../ajustes/ajustes.php"
    });

    $("#editarBodega").click(function(){
      document.getElementById("datosBodega").style.display = "block";
      document.getElementById("stockEditar").style.display = "none";
    });
    $("#stockBodega").click(function(){
      document.getElementById("datosBodega").style.display = "none";
      document.getElementById("stockEditar").style.display = "block";
    });
    $("#agregar").click(function(){
      window.location = "agregar.php";
    });
    $(".aceptar").click(function(){
      $.ajax({
        url:'../funciones/cambioBodega.php',
        type: 'post',
        data:{
          nombre: $(".nombre").val(),
          calleP: $(".calleP").val(),
          calleC: $(".calleC").val(),
          numero: $(".numero").val(),
          referencias: $(".referencias").val()
        },
        success: function(respuesta){
          window.location = "manejoBodega.php";
        }
      });
    });
  });
</script>

  <head>
    <meta charset="utf-8">
    <title></title>
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
      <?php
        if ($result = mysqli_query($mysqli, $consulta->sqlBodega($id_bodega))) {
          $filas = mysqli_fetch_array($result);

          $nombre = utf8_encode($filas['NOMBRE_BODEGA']);
          $calleP = utf8_encode($filas['CALLE_PRINCIPAL']);
          $calleC = utf8_encode($filas['CALLE_SECUNDARIA']);
          $referencias =utf8_encode($filas['REFERENCIAS']);
          $numero = utf8_encode($filas['NUMERO']);
        }
      ?><br><br>

      <h1>BODEGA: <?php echo $nombre; ?></h1>

      <button id="editarBodega" class="w3-button w3-round-xxlarge w3-white">Cambiar datos</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button id="stockBodega" class="w3-button w3-round-xxlarge w3-white">Editar Stock</button>

      <div class="w3-animate-left" style="display:none" id="datosBodega">
        <h6>NOMBRE</h6>
        <input type="text" class="nombre" onKeyUp="this.value=this.value.toUpperCase();" value="<?php echo $nombre ?>">
        <h6>DIRECCI&Oacute;N</h6>
        <input type="text" class="calleP" value="<?php echo $calleP ?>" onKeyUp="this.value=this.value.toUpperCase();"><br><br>
        <input type="text" class="calleC" value="<?php echo $calleC ?>" onKeyUp="this.value=this.value.toUpperCase();"><br><br>
        <input type="text" class="numero" value="<?php echo $numero ?>" onKeyUp="this.value=this.value.toUpperCase();"><br><br>
        <textarea class="referencias" rows="5" cols="40" value="<?php echo $referencias ?>" onKeyUp="this.value=this.value.toUpperCase();"></textarea><br><br>
        <button class="w3-button w3-signal-black w3-round-xxlarge aceptar">Aceptar</button>
      </div>

      <div class="w3-animate-left w3-responsive" style="display:block" id="stockEditar">
        <form action="manejobodega.php" method="post">
          <table class="w3-table w3-bordered w3-animate-top w3-striped w3-centered">
            <tr class="w3-signal-black">
              <th></th>
              <th>ITEM</th>
              <th>CATEGORIA</th>
              <th>UNIDAD</th>
              <th>CANTIDAD</th>
              <th></th>
            </tr>
            <?php
            if ($result = mysqli_query($mysqli, "select b.NOMBRE_BODEGA, m.NOMBRE_ITEM, d.CANTIDAD, c.NOMBRE_CATEGORIA,
            u.NOMBRE_UNIDAD, u.ABREBIATURA_UNIDAD, m.ID_ITEM from BODEGA b, MAQUINARIA_MATERIALES m, DETALLE_BODEGA d,
            CATEGORIA c, UNIDAD u WHERE b.ID_BODEGA = d.ID_BODEGA and m.ID_ITEM = d.ID_ITEM
            and m.ID_CATEGORIA = c.ID_CATEGORIA and m.ID_UNIDAD = u.ID_UNIDAD and b.NOMBRE_BODEGA ='".$nombre."' order by m.NOMBRE_ITEM")) {
              while ($filas = mysqli_fetch_array($result)) {
                echo "
                <tr>
                  <th><input style='display:none' type='text' name='id[]' value='".utf8_encode($filas['ID_ITEM'])."' size='1' readonly></th>
                  <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                  <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
                  <th>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</th>
                  <th>".$filas['CANTIDAD']."</th>
                  <th><input type='number' size='5' name='valor[]' value='0'></th>
                </tr>
                ";
              }
            }
            ?>
          </table><br><br>
          <input class="w3-button w3-signal-black w3-display-bottomleft" type="submit" name="aceptar" value="Aceptar">
        </form>
        <button id="agregar" class="w3-button w3-signal-black w3-display-bottommiddle">Agregar <i class="w3-small material-icons">add</i></button>
      </div>

    </div>
  </body>
</html>
