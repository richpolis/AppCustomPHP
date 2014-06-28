<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Inicio</title>

<?php 

@ require_once ('header.php'); 
echo "<h1>Inicio</h1>";
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

<h1>Bienvenido al Portal de Personal</h1>

<div id="texto">
<p>
INCA te da la más cordial bienvenida a nuestra nueva base de datos de la Coordinación de Personal en la Web. A partir del año 2011, contamos con un nuevo portal enfocado en el resguardo de la información confidencial de todo el personal de nuestra empresa INCA.

<p>
Nuestros visitantes podrán tener acceso a la información general que integra esta base de datos desde cualquier computadora con acceso a Internet, facilitando la obtención de los formatos utilizados y estar actualizado con respecto a los mismos.
</p>
<p>
A través de este portal, la Coordinación de Personal logra anexar, modificar y eliminar archivos relevantes de cada uno de sus empleados. Su principal función será el consultar de forma más rápida y a detalle cualquier tipo de dato que se requiera para el control del personal de la empresa.
</p>
<p>
En caso de tener alguna sugerencia o recomendación para la presente base de datos, favor de enviar un correo a <a href="mailto:carloscarrillomujaes@hotmail.com">carloscarrillomujaes@hotmail.com</a> para su modificación e intervención oportuna de nuestro programador designado. 
</p>
</div>

<p style="text-align: center;"><br /><br />
Atentamente:
</p>
<p style="text-align: center;">
Grupo INCA S.A de C.V.
</p>
<p style="text-align: center;"><br /><br />
<img src="./images/casco.png" style="padding-right: 20px;" />
</p>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     