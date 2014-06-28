<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Personal INCA</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Personal INCA</h1>";
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
<style>
/* REPORT */

#report { border-collapse:collapse; -moz-box-shadow: 0 0 10px #aaa; -webkit-box-shadow: 0 0 10px #aaa;}
#report th { background:#7CB8E2; color:#fff; padding:5px 10px; text-align:left; vertical-align:middle;}
#report td { background:#C7DDEE none repeat-x scroll center left; color:#000; padding:5px 0px 5px 10px; vertical-align:middle; opacity:0.6;}
#report td.filaimpar { background: #D0EDFB}
#report td.filapar { background: #F3F3F3;}

</style>

<article class="clearfix">

<div id="texto">
<p>
A continuación se presenta un listado de los empleados que trabajan actualmente en INCA:<br /><br />
</p>

<?php
	$result = $miconexion->consulta("SELECT * FROM empleados WHERE finiquitado = 0 ORDER BY nombre ASC;");
	if (mysql_num_rows($result)!=0) {
		echo "<table id='report' width='100%'>\n";
		echo "	<tr style='text-align: left; bgcolor= #666666;'>\n";
		echo "		<th style='width: 290px;'>Nombre</th>\n";
		echo "		<th style='width: 210px'>Coordinaci&oacute;n / Gerencia</th>\n";
		echo "		<th style='width: 320px'>E-Mail</th>\n";
		echo "		<th style='width: 50px'>Tel&eacute;fono</th>\n";
		echo "	</tr>\n";
		$c = 0;
		while ($row = mysql_fetch_array($result)) {
			if ($c % 2 == 0) 
				$class = "class='filaimpar'";
			else
				$class = "class='filapar'";
			$c++;
			echo "<tr>\n";
			//NOMBRE
			echo "	<td $class>\n";
			echo "		".htmlentities($row["nombre"])." ".htmlentities($row["apellido_paterno"])." ".htmlentities($row["apellido_materno"])."\n";
			echo "	</td>\n";
			//COORDINACION/GERENCIA
			echo "	<td $class>\n";
			if ($row["id_gerencia"] != NULL) {
				$result_gerencia = $miconexion->consulta("SELECT gerencias.nombre from gerencias, empleados ".
												"WHERE gerencias.id_gerencia = empleados.id_gerencia ".
												"AND gerencias.id_gerencia = ".$row["id_gerencia"].";");
				$row_gerencia = mysql_fetch_array($result_gerencia);
				echo "		".htmlentities($row_gerencia["nombre"])."\n";
			}
			echo "	</td>\n";
			//E-MAIL
			echo "	<td $class>\n";
			echo "		".htmlentities($row["email"])."\n";
			echo "	</td>\n";			
			//TEL
			echo "	<td $class>\n";
			echo "		".htmlentities($row["tel"])."\n";
			echo "	</td>\n";
			
			echo "</tr>\n";			
		}
		echo "</table>";
	}	
	else {
		echo "<p>No hay ning&uacute;n empleado dado de alta por el momento en la base de datos.</p>";
	}
	
?>

</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>