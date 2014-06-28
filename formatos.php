<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Formatos Personal</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Formatos Personal</h1>";
@ require_once ('header2.php');

if(!isset($_SESSION["uloged"])){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

include ("Acceso.php");
?>

<article class="clearfix">

<div id="texto">
<p>
En este apartado se podrán encontrar los diferentes formatos de la Coordinación de Personal que han sido avalados por la Dirección General de INCA para su uso general a partir del año 2011. Esto con el principal objetivo de estandarizar y regular los movimientos que se realizan día con día relacionados con dicha área de la empresa.
</p>
<p>
A continuación se presenta un listado con los distintos formatos actualizados sobre la Coordinación de Personal:
</p>

<?php
	if ($_SESSION['nivel'] < 2) {
		$result = $miconexion->consulta("SELECT * FROM formatos;");
	}
	else{
		$result = $miconexion->consulta("SELECT * FROM formatos WHERE privado = 0;");
	}
	if (mysql_num_rows($result)!=0) {
		echo "<ol>";
		while ($row = mysql_fetch_array($result)) {
			echo "<li><a href='./formatos/".htmlentities($row["id_formato"])."' title='' target='_blank'>".htmlentities($row["descripcion"])."</a></li>";
		}
		echo "</ol>";
	}	
	else {
		echo "<p>No hay ning&uacute;n formato dado de alta por el momento en la base de datos.</p>";
	}
	
?>

</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>