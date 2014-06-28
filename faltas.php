<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Control de Faltas</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Control de Faltas</h1>";
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

<h1>Control de Faltas Personal Administrativo</h1>

<div id="texto">
<img src="./images/faltas.png"  align="left" style="padding-right: 20px; padding-bottom: 10px;" />
<p>
El presente apartado está enfocado en el control sobre las asistencias, las entradas tardías y salidas prontas del personal administrativo que cuenta con un horario definido de trabajo para la realización de sus funciones.
</p>
<p>
El principal propósito de este control es la justificación confirmada sobre las posibles inasistencias por asuntos tanto de trabajo como personales que se le pudieran presentar a los empleados de la empresa. 
</p>
<p>
Nuestro principal objetivo es fomentar la confianza y formalidad sobre el cumplimiento de las responsabilidades diarias del personal administrativo de INCA. Por otro lado, es importante para el Director General estar informado sobre la causa de las mismas y los días en los que se presenta.
</p>
<p>
Es por esto que se lleva un control mensual sobre las asistencias, horas de entrada y las faltas que se presentan por los empleados y de igual forma elaborar un estudio sobre las principales causas por las que éstas son ocasionadas.
</p>
<p>
Tipos de Control:
</p>
<ol>
 <li>Se lleva un control a través del acceso a la oficina central INCA en la ciudad de México sobre la hora de entrada de los trabajadores.</li>
 <li>Se lleva un formato de control sobre entradas, salidas y faltas justificadas por parte de los empleados.</li>
 <li>Se lleva un control en una tabla sobre la causa de las entradas, salidas y faltas justificadas para posteriormente sacar una estadística anual del concepto de "Asistencia de Personal".</li>
</ol>
</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>        