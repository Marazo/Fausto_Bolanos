<?php

include("../controladores/consultas.php");
include("../controladores/conexion.php");
session_start();

$consulta = new consultas();
$id = $_SESSION['Item_id'];

$scriptSQL = "select m.ID_ITEM, m.NOMBRE_ITEM, u.NOMBRE_UNIDAD, c.NOMBRE_CATEGORIA
FROM CATEGORIA c, UNIDAD u, MAQUINARIA_MATERIALES m
WHERE m.ID_UNIDAD = u.ID_UNIDAD and m.ID_CATEGORIA = c.ID_CATEGORIA and
m.ID_ITEM = '".$id."'";

if ($result = mysqli_query($mysqli, $scriptSQL)) {
  $filas = mysqli_fetch_array($result);
}

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

    $(".itemCambiar").click(function(){
      $.ajax({
        url: "../funciones/editarItem.php",
        type: "POST",
        data:{
          nombre: $(".itemNombre").val(),
          unidad: $(".itemUnidad").val(),
          categoria: $(".itemCategoria").val()
        },
        success: function(respuesta){
          window.location = "item.php"
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
      <button class="w3-button w3-round-xxlarge w3-white veiculo">Veiculo</button>

        <div id="item" class="w3-animate-left">
          <h6>Nombre Item</h6>
          <input type="text" name="nombre" value="<?php echo utf8_encode($filas['NOMBRE_ITEM']); ?>" onKeyUp="this.value=this.value.toUpperCase();" class="itemNombre">
          <h6>Unidad</h6>
          <select class="w3-button w3-white w3-border itemUnidad" >
            <?php
                if ($result = mysqli_query($mysqli, $consulta->sqlUnidad())) {
                  while ($filas = mysqli_fetch_array($result)) {
                    echo "
                    <option value='".utf8_encode($filas['ID_UNIDAD'])."'>".utf8_encode($filas['NOMBRE_UNIDAD'])." [ ".utf8_encode($filas['ABREBIATURA_UNIDAD'])." ]</option>";
                  }
                }
            ?>
          </select>
          <h6>Categoria</h6>
          <select class="w3-button w3-white w3-border itemCategoria">
            <?php
                if ($result = mysqli_query($mysqli, $consulta->sqlCategoria())) {
                  while ($filas = mysqli_fetch_array($result)) {
                    echo "
                    <option value='".utf8_encode($filas['ID_CATEGORIA'])."'>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</option>";
                  }
                }
            ?>
          </select><br><br>
          <button class="w3-button w3-round-xxlarge w3-signal-black itemCambiar">Aceptar</button>
        </div>
    </div>
  </body>
</html>
