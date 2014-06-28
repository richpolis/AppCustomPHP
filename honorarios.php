<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Recibos de Honorarios</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Recibos de Honorarios</h1>";
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

<h1>Entrega y Reporte de Recibos de Honorarios</h1>

<div id="texto">
<img src="./images/recibo_honorarios.png"  align="left" style="padding-right: 20px; padding-bottom: 10px;" />
<p>
La razón principal de este apartado es el control constante de la entrega de los recibos y facturas de honorarios de los empleados y el compromiso mutuo que debe existir entre la empresa y el empresa sobre la entrega oportuna y el recibimiento oportun de los mismos.
</p>
<p>
Dicho control es indispensable para que exista una correlación entre el pago de honorarios por parte de la empresa y el registro contable actualizado de los mismos durante todo el año.
</p>
<p>
En presente apartado contamos con un archivo actualizado y personalizado en formato Acrobat PDF sobre los últimos dos Recibos de Honorarios entregados por el empleado a la Coordinación de Tesorería y registrados en conjunto con la Coordinación de Personal.  
</p>
<p>
Por nuevas políticas establecidas durante el año 2011, en caso de incurrir en atrasos de entrega de los recibos de honorarios del empleado, surgirá la necesidad de retrasar de igual forma el pago de los servicios profesionales del interesado.
</p>
<p>
Es sumamente importante la constante actualización quincena tras quincena del presente apartado para no caer en malos entendidos y situaciones que se puedan malinterpretar entre las coordinaciones, gerencias y los responsables de los depósitos correspondientes por la prestación de servicios del empleado de INCA.
</p>
<p style="text-align: center;"><br /><br />
Empresa Contratante<br />
Supervisores de Construcción y Asociados <br />
S.A. de C.V.
</p>
</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>    