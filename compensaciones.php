<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Compensaciones INCA</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Compensaciones INCA</h1>";
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
<h1> Compensaciones a Empleados </h1>
<div id="texto">
<img src="./images/compensaciones.png"  align="left" style="padding-right: 20px;" />
<p>
Nuestra empresa siempre se ha caracterizado por compensar a cada uno de nuestros empleados como se merece calificando su trabajo y las ganas puestas en cada uno de los proyectos. Es por esto que contamos con distintos tipos de compensación que deben ser controlados y vigilados tanto por la Coordinación de Tesorería como por la Coordinación de Personal.
</p>
<p>
Actualmente la empresa cuenta con una caja de ahorro empresarial con la cual se cuenta para casos en los que los empleados soliciten ayuda económica para solventar gastos personales.
</p>
<p>
En el presente apartado se lleva un registro sobre los Viáticos registrados durante el año, el Alta / Baja de Foraneidad de los Empleados y los Préstamos otorgados a los empleados de INCA. Cada uno de los formatos mencionados deberá ser revisado y autorizado directamente por el Director General de la empresa.
</p>
<p>
Cada uno de los archivos deberá llevar su firma y el de la Coordinación de Personal dando fe y legalidad al documento presentado. Será importante mantener el seguimiento de los mismos para llevar una regulación sobre el tabulador y la proporción otorgada para cada uno de los empleados que lo solicite.
</p>
<p>
<br />Tablas:
</p>
<ol>
 <li>Tabla de Foraneidades</li>
 <li>Tabla de Viáticos</li>
 <li>Tabla de Préstamos</li>
</ol>
<p>
<br />Archivos PDF:
</p>
<ol>
 <li>Alta de Foraneidades</li>
 <li>Baja de Foraneidades</li>
 <li>Viáticos Empleados INCA</li>
 <li>Préstamos INCA</li>
</ol>

</div>
</article>
  
<?php 
@ require_once ('footer.php');
  }
?>      