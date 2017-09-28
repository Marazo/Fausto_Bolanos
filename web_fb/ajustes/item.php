<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

 ?>
<!DOCTYPE html>

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

     $(".itemIncertar").click(function(){
       $.ajax({
         url: "../funciones/agregar/agregarItem.php",
         type: "POST",
         data: {
           nombre: $(".itemNombre").val(),
           unidad: $(".itemUnidad").val(),
           categoria: $(".itemCategoria").val()
         },
         success: function(respuesta){
           window.location = "item.php";
         }
       });
     });

     $(".editar").click(function(){
       var editarItem = $(this).parents("tr").find("td").html();
       $.ajax({
         url: '../controladores/item.php',
         type: 'POST',
         data: { item: editarItem},
         success: function(){
           window.location = "editarItem.php";
         }
       });
     });

   });
 </script>

<html>
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

      <input class="itemNombre" placeholder="Material o Herramienta" onKeyUp="this.value=this.value.toUpperCase();">&nbsp;&nbsp;&nbsp;&nbsp;
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

      <select class="w3-button w3-white w3-border itemCategoria">
        <?php
            if ($result = mysqli_query($mysqli, $consulta->sqlCategoria())) {
              while ($filas = mysqli_fetch_array($result)) {
                echo "
                <option value='".utf8_encode($filas['ID_CATEGORIA'])."'>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</option>";
              }
            }
        ?>
      </select>
      <button class="w3-button w3-round-xxlarge w3-signal-black itemIncertar">Aceptar</button><br><br>

      <table class="w3-table w3-bordered w3-animate-top">
        <tr class="w3-signal-black">
          <th>ITEM</th>
          <th>UNIDAD</th>
          <th>CATEGORIA</th>
          <th></th>
        </tr>
        <?php
        if ($result = mysqli_query($mysqli, $consulta->sqlItem())) {
          while ($filas = mysqli_fetch_array($result)) {
            echo "
            <tr>
              <td style='display:none'>".utf8_encode($filas['ID_ITEM'])."</td>
              <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
              <th>".utf8_encode($filas['NOMBRE_UNIDAD'])."</th>
              <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
              <th class='editar'><u class='w3-bar-item w3-button'><i class='material-icons'>create</i></u></th>
            </tr>
            ";
          }
        }
        ?>
      </table>

    </div>
  </body>
</html>
