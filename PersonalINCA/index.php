<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Inicio</title>
<script type="text/javascript" src="../js/jquery-1.7.1.min.js"></script>
<?php 

@ require_once ('header.php');
@ require_once ('header1.php');
echo "<h1>Inicio</h1>\n";
@ require_once ('header2.php');

if(!isset($_SESSION["uloged"])){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

?>

<article class="clearfix">

<h1>Bienvenido a la p&aacute;gina administrativa de Personal</h1>

<div id="texto">
<p>
INCA te da la más cordial bienvenida a nuestra nueva base de datos de la Coordinación de Personal en la Web.
</p>
<p>
Nuestros visitantes podrán tener acceso a la información general que integra esta base de datos desde cualquier computadora con acceso a Internet, facilitando la obtención de los formatos utilizados y estar actualizado con respecto a los mismos.
</p>
<p>
A través de este portal, la Coordinación de Personal logra anexar, modificar y eliminar archivos relevantes de cada uno de sus empleados. Su principal función será el consultar de forma más rápida y a detalle cualquier tipo de dato que se requiera para el control del personal de la empresa.
</p>

<p>
Por favor elige una de las opciones del men&uacute; para acceder a la base de datos.
</p>

</div>

<p style="text-align: center;"><br /><br />
<img src="../images/casco.png" style="padding-right: 20px;" />
</p>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     