<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");
?>

<!DOCTYPE html>

<?php

$consulta = new consultas();

$id_bodega = $_SESSION['id_bodega'];

if (isset($_POST['aceptar'])) {
  $arregloCHK = $_POST['chk'];
  $num = count($arregloCHK);

  for ($i=0; $i < $num; $i++) {
    mysqli_query($mysqli, $consulta->sqlAgregarDetalleBodega($id_bodega, $arregloCHK[$i]));
  }

  header('Location: manejobodega.php');
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
    $("#checkAll").click(function(){
      $(":checkbox").prop('checked',true);
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


        <table class="w3-table w3-bordered w3-animate-top w3-striped">
          <tr class="w3-signal-black">
            <th><button class="w3-button w3-signal-black" id="checkAll"><i class="material-icons">select_all</i></button></th>
            <th>ITEM</th>
            <th>UMIDAD</th>
            <th>CATEGORIA</th>
          </tr>
          <form class="w3-container w3-card-4" action="agregar.php" method="post">
          <?php
          if ($result = mysqli_query($mysqli, $consulta->sqlItemBodega($id_bodega))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <tr>
                <th> <input type='checkbox' class='w3-check' name='chk[]' value='".$filas['ID_ITEM']."'></th>
                <th>".utf8_encode($filas['NOMBRE_ITEM'])."</th>
                <th>".utf8_encode($filas['NOMBRE_UNIDAD'])."</th>
                <th>".utf8_encode($filas['NOMBRE_CATEGORIA'])."</th>
              </tr>
              ";
            }
          }
          ?>
          <input class="w3-button w3-signal-black w3-bottom" type="submit" name="aceptar" value="Acpetar">
        </form>

        </table>
    </div>
  </body>
</html>