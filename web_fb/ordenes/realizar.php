<?php

include("../controladores/ingreso.php");
include("../controladores/consultas.php");

$consulta = new consultas();

 ?>
<!DOCTYPE html>
<?php
if (isset($_POST['aceptar'])) {

  $de = $_POST['de'];
  $a = $_POST['a'];
  $placas = $_POST['veiculo'];
  $dueno = $_POST['chofer'];

  $arregloCHK = $_POST['chk'];
  $arregloVALOR = $_POST['valor'];
  $num = count($arregloCHK);

  if ($_SESSION['tipo_de_orden'] == "Bodegas") {
    if ($de == '' || $a == '' || $placas == '' || $dueno == '' ||$arregloCHK == '' ||
        $arregloVALOR == '' || $num == '') {
      echo "<script type='text/javascript'> alert('ALERTA FALTAN DATOS\N PORFABOR INTENTLO NUEVAMENTE') </script>";
    }else {
      mysqli_query($mysqli, $consulta->sqlAgregarHoja($ci, $dueno, $placas));

      if ($result = mysqli_query($mysqli, "select MAX(h.ID_HOJA) FROM HOJA_DE_CONTROL h")) {
        while ($filas = mysqli_fetch_array($result)) {
          $hoja = $filas['MAX(h.ID_HOJA)'];
        }
      }

      mysqli_query($mysqli, $consulta->sqlAgregarRecepcion($a, $hoja));

      for ($i=0; $i < $num; $i++) {
        mysqli_query($mysqli, $consulta->sqlAgregarDespacho($de, $arregloCHK[$i], $hoja, $arregloVALOR[$arregloCHK[$i]]));
        mysqli_query($mysqli, $consulta->sqlActualizarCantidad($de, $arregloCHK[$i], $arregloVALOR[$arregloCHK[$i]], '-'));
      }
      mysqli_query($mysqli, $consulta->sqlAgregarRecepcion($a, $hoja));
      echo "<script type='text/javascript'> alert('TRANSACCIÓN EXITOSA') </script>";
    }
  }elseif ($_SESSION['tipo_de_orden'] == "Proyectos") {
    if ($de == '' || $a == '' || $placas == '' || $dueno == '' ||$arregloCHK == '' ||
        $arregloVALOR == '' || $num == '') {
      echo "<script type='text/javascript'> alert('ALERTA FALTAN DATOS\N PORFABOR INTENTLO NUEVAMENTE') </script>";
    }else {
      mysqli_query($mysqli, $consulta->sqlAgregarHoja($ci, $dueno, $placas));

      if ($result = mysqli_query($mysqli, "select MAX(h.ID_HOJA) FROM HOJA_DE_CONTROL h")) {
        while ($filas = mysqli_fetch_array($result)) {
          $hoja = $filas['MAX(h.ID_HOJA)'];
        }
      }

      mysqli_query($mysqli, $consulta->sqlAgregarRecepcion($de, $hoja));

      for ($i=0; $i < $num; $i++) {
        mysqli_query($mysqli, $consulta->sqlAgregarDespacho($a, $arregloCHK[$i], $hoja, $arregloVALOR[$arregloCHK[$i]]));
        mysqli_query($mysqli, $consulta->sqlActualizarCantidad($a, $arregloCHK[$i], $arregloVALOR[$arregloCHK[$i]], '+'));
      }
      mysqli_query($mysqli, $consulta->sqlAgregarRecepcion($de, $hoja));
      echo "<script type='text/javascript'> alert('TRANSACCIÓN EXITOSA') </script>";
    }
  }
}

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
      window.location = "ordenes.php";
    });
    $("#ajustes").click(function(){
      window.location = "../ajustes/ajustes.php";
    });
    $("#realizar").click(function(){
      window.location = "realizar.php";
    });
    $("#salir").click(function(){
      window.location = "salir.php";
    });
    $("#recivir").click(function(){
      window.location = "recivir.php";
    });
    $("#hojaControl").click(function(){
      window.location = "hojaControl.php";
    });
    $(".de").change(function(){
      var valor = $(".de").val();
      var miLabel = $(this.options[this.selectedIndex]).closest('optgroup').prop('label');
      $(".tabla").load("agregarOrden.php", {id: valor, tipo: miLabel});
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

      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
      <button type="button" id="realizar" class="w3-button w3-round-xxlarge w3-white">Reaalizar Orden</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php } ?>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE' || $_SESSION['rol'] == 'BODEGA/OBRA' || $_SESSION['rol'] == 'BODEGA') {?>
      <button type="button" id="salir" class="w3-button w3-round-xxlarge w3-white">Ordenes en Bodega</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php } ?>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE' || $_SESSION['rol'] == 'BODEGA/OBRA' || $_SESSION['rol'] == 'OBRA') {?>
      <button type="button" id="recivir" class="w3-button w3-round-xxlarge w3-white">Ordenes en Obra</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <?php } ?>
      <?php if ($_SESSION['rol'] == 'USUARIO MAESTRO' || $_SESSION['rol'] == 'JEFE') {?>
      <button type="button" id="hojaControl" class="w3-button w3-round-xxlarge w3-white">Hoja de Control</button>
      <?php } ?>

      <form class="w3-container w3-card-4" action="realizar.php" method="post">
        <br>De:
        <select class="w3-button w3-white w3-border w3-round-large de" name="de">
          <option value=""></option>
          <optgroup label="Bodegas">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlBodega(''))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
                <option value='".utf8_encode($filas['ID_BODEGA'])."'>".utf8_encode($filas['NOMBRE_BODEGA'])."</option>";
            }
          } ?>
          </optgroup>
          <optgroup label="Proyectos">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlProyecto())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
                <option value='".utf8_encode($filas['ID_PROYECTO'])."'>".utf8_encode($filas['NOMBRE_PROYECTO'])."</option>";
            }
          } ?>
        </optgroup>
        </select>&nbsp;&nbsp;
        A:
        <select class="w3-button w3-white w3-border w3-round-large" name="a">
          <option value=""></option>
          <optgroup label="Bodegas">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlBodega(''))) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
                <option value='".utf8_encode($filas['ID_BODEGA'])."'>".utf8_encode($filas['NOMBRE_BODEGA'])."</option>";
            }
          } ?>
          <optgroup label="Proyectos">
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlProyecto())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
                <option value='".utf8_encode($filas['ID_PROYECTO'])."'>".utf8_encode($filas['NOMBRE_PROYECTO'])."</option>";
            }
          } ?>
        </select><br><br>

        Chofer:
        <select class="w3-button w3-white w3-border w3-round-large" name="chofer">
          <option value=""></option>
          <?php  if ($result = mysqli_query($mysqli, $consulta->sqlDueno())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
              <option value='".$filas['CI_DUENO']."'>".utf8_encode($filas['APELLIDI_DUENO'])." ".utf8_encode($filas['NOMBRE_DUENO'])."</option>";
            }
          }?>
        </select>&nbsp;&nbsp;

        Veiculo:
        <select class="w3-button w3-white w3-border w3-round-large" name="veiculo">
          <option value=""></option>
          <?php if ($result = mysqli_query($mysqli, $consulta->sqlVeiculo())) {
            while ($filas = mysqli_fetch_array($result)) {
              echo "
                <option value='".utf8_encode($filas['PLACAS'])."'>".utf8_encode($filas['PLACAS'])."</option>";
            }
          } ?>
        </select><br><br>

        <div class="tabla">

        </div>
      </form>

    </div>
  </body>
</html>