<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Localidades de Inmuebles</title>

<?php 

@ require_once ('header.php');
@ require_once ('scriptsEmpleados.php');
echo "<script type='text/javascript' src='js/localidades.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Localidades de Inmuebles</h1>\n";

@ require_once ('header2.php');


if(!isset($_SESSION["uloged"])){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

include ("../Acceso.php");
?>

<!-- BUSQUEDA DE LOCALIDADES -->
<article class="clearfix" id="consulta">
<?php 
if ($_SESSION['nivel'] == 0) {
?>
<div class="buttons" style="width: 256px; margin: 0 auto;">
	<p style="text-align:center;">
	<a style="width: 256px; margin: 0 auto;" id="insertar">
        <img src="./images/Button-Add-icon.png" alt=""/> 
        Insertar Localidad
    </a>
    </p>
</div>

<p><hr /></p>
<?php 
}
?>
<div id="tabla">

</div>

</article>

<!-- DATOS DE LA LOCALIDAD -->
<article class="clearfix" id="datos">

<h1 id="label_im">Insertar una Localidad</h1>

<form action="insertarLocalidades.php" method="post" id="modinsertar" enctype='multipart/form-data'>

	<div class="linea">
        <div class="etiqueta" for="nombre">Nombre:</div>
        <input type="text" id="nombre" name="nombre" class="required" minlength="2" maxlength="150" value="" style="width: 350px;" />
    </div>   
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion" />
        <input type="hidden" value="" name="id_localidad" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>
    
        				
</form>

<!--- <iframe name='submit-iframe' style='display: none;'></iframe> --->

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     