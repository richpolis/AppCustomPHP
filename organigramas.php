<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Organigramas</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Organigramas</h1>";
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

<h1>Formulación del Organigrama INCA</h1>

<div id="texto">
<img src="./images/organigrama.png"  align="left" style="padding-right: 20px;" />
<p>
Gracias a la colaboración de cada uno de nuestros coordinadores en INCA, logramos realizar mejoras dentro de cada uno de nuestras gerencias y proyectos activos, así  como organizar mejor nuestra plantilla de personal. Pensamos que es importante que exista un mayor conocimiento sobre la estructura del equipo de trabajo y las cabezas de mando a las cuales pertenece cada uno de nuestros empleados.
</p>
<p>
Es el deber de la Coordinación de Personal contribuir a un mayor y mejor desempeño de los empleados de INCA satisfaciendo sus necesidades y haciéndolos sentirse parte fundamental del equipo de trabajo enfocado al cumplimiento de nuestro servicio.  
</p>
<p>
Es por esto que al iniciar este 2011 con nuevas metas y objetivos para una mayor organización en la estructura de nuestras coordinaciones y gerencias, se originó el proyecto de la "Estructura del Organigrama General".
</p>

<h2>Objetivo de la Reformulación del Organigrama </h2>
<ul>
 <li>Establecer puestos específicos los cuales está integran INCA. </li> 
 <li>Establecer los niveles jerárquicos y/o de responsabilidad. </li> 
 <li>Detección de fallas estructurales debido a confusión de jerarquías.</li>
 <li>Detección de puestos fantasmas o duplicados dentro de la empresa.</li>
 <li>Interrelaciones jerárquicas entre un puesto y otro.</li>
 <li>Reformulación del nombre de cada uno de puestos y ocupante del mismo. </li>
 <li>Conocimiento personal sobre la conformación de la estructura general. </li>
 <li>Formulación posterior de descripciones y perfiles de puestos.</li>
 <li>Presentación de la descripción documentada al ocupante del puesto.</li>
 <li>Facilidad de obtener candidatos idóneos al puesto.</li>
 <li>División de las dos áreas generales de la empresa: Administración y Gerencias Técnicas; y su delegación de responsabilidades.</li>
</ul>
<br />
<h2>División del Organigrama INCA</h2>

<h3>General</h3>
<ol>
 <li><a href="./organigramas/EstructuraOrganizacional.jpg" title="Organigrama General INCA" class="cboxElement">Organigrama General INCA</a> </li>
 <li><a href="./organigramas/Gerencias Tecnicas.jpg" title="Gerencias Técnicas" class="cboxElement">Organigrama "Gerencias Técnicas"</a> </li>
 <li><a href="./organigramas/CoordinacionesAdmon.jpg" title="Organigrama &Prime;Coordinaciones de Apoyo Administrativo&Prime;" class="cboxElement">Organigrama "Coordinaciones de Apoyo Administrativo"</a></li>
 <h3><br />Gerencias</h3>
 <li><a href="./organigramas/ConsultoríaEmpresarial.jpg" title="Organigrama &Prime;Gerencia Consultoría Empresarial&Prime;" class="cboxElement">Organigrama "Gerencia Consultoría Empresarial"</a></li>
 <li><a href="./organigramas/Supervision de Proyectos.jpg" title="Organigrama &Prime;Gerencia Supervisión de Proyectos&Prime;" class="cboxElement">Organigrama "Gerencia Supervisión de Proyectos"</a></li>
 
 <!---
 <li><a href="./organigramas/Carreteras.jpg" title="Organigramas &Prime;Gerencia Supervisión de Infraestructura Carretera&Prime;" class="supervision">Organigramas "Gerencia Supervisión de Infraestructura Carretera"</a>
 		<a href="./organigramas/Carreteras - Constituyentes Reforma.jpg" title="Organigramas &Prime;Gerencia Supervisión de Infraestructura Carretera&Prime;" class="supervision"></a>
        <a href="./organigramas/Carreteras - Oficina WTC.jpg" title="Organigramas &Prime;Gerencia Supervisión de Infraestructura Carretera&Prime;" class="supervision"></a>
        <a href="./organigramas/Carreteras4.jpg" title="Organigramas &Prime;Gerencia Supervisión de Infraestructura Carretera&Prime;" class="supervision"></a>
 </li>
 <li><a href="./organigramas/PyC - Biblioteca Mexico.jpg" title="Gerencia Planeación y Control &Prime;Biblioteca Mexico&Prime;" class="planeacion">Organigramas "Gerencia Planeación y Control"</a>
 		<a href="./organigramas/PyC - CIS Puebla.jpg" title="Gerencia Planeación y Control &Prime;Centro Administrativo Puebla&Prime;" class="planeacion">"</a>
        <a href="./organigramas/PyC - Metrobus Puebla.jpg" title="Gerencia Planeación y Control &Prime;Metrobus de Puebla&Prime;" class="planeacion"></a>
        <a href="./organigramas/PyC - Monterrey.jpg" title="Gerencia Planeación y Control &Prime;Monterrey&Prime;" class="planeacion"></a>
        <a href="./organigramas/PyC - Palacio Nacional.jpg" title="Gerencia Planeación y Control &Prime;Palacio Nacional&Prime;" class="planeacion"></a></li>
 ---->
</ol>
<br />
<h2>Organigramas de Obras</h2>
<?php

	$result = $miconexion->consulta("SELECT * FROM obras WHERE organigrama IS NOT NULL;");

	if (mysql_num_rows($result)!=0) {
		echo "<ol>";
		while ($row = mysql_fetch_array($result)) {
			echo "<li><a href='./PersonalINCA/archivos/".htmlentities($row["organigrama"])."' title='Organigrama Obra &Prime;".htmlentities($row["nombre"]).
			"&Prime;' target='_blank' class='cboxElement'>Organigrama Obra &Prime;".htmlentities($row["nombre"])."&Prime;</a></li>";
		}
		echo "</ol>";
	}	
	else {
		echo "<p>No hay ning&uacute;n organigrama de obra dado de alta por el momento en la base de datos.</p>";
	}
	
?>

<script>
	$("a.cboxElement").colorbox();
	$("a.supervision").colorbox({rel:'group1'});
	$("a.planeacion").colorbox({rel:'group2'});
</script>

</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>   