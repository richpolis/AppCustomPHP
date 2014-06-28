<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Tipo de Contrataci&oacute;n INCA</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Tipo de Contrataci&oacute;n INCA</h1>";
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
<div id="texto">
<h1> Contratación de Empleados </h1>
<img src="./images/sam_suca.png" align="left" style="padding-right: 20px;" />
<p>
Nuestro principal objetivo es establecer los acuerdos legales que satisfagan de la mejor manera posible los intereses de los trabajadores y la empresa para realizar servicios de supervisión. Se intenta llegar a través de la firma del contrato a la formalización de la prestación de servicios del subordinado ante el patrón. Por otro lado, el contrato constituirá una necesidad de carácter administrativo, tanto para nuestros empleados como para la empresa.  <br /><br />
</p>
<p>

Para el trabajador: 
<ul>
 <li>Se mencionan sus obligaciones como lugar, tiempo y modo de la prestación de servicios. </li>
 <li>Se mencionan las contraprestaciones por su trabajo (salario, descansos, vacaciones, etc.) </li>
 <li>Y se menciona su estabilidad relativa en el empleo.</li>
</ul><br />
</p>
<p>
Para la empresa: 
<ul>
 <li>Cumplimiento de sus obligaciones del empleado dentro de la empresa y su horario de trabajo. </li>
 <li>Permite resolver cualquier disputa sobre la manera de desarrollar las actividades de trabajo y la delegación de autoridad.</li>
 <li>Constituye un elemento prueba ante los conflictos personales con compañeros que pudieran surgir a lo largo de su trabajo.</li>
</ul><br />
</p>
<p>
Requerimientos de contratación:
<ul>
 <li>Se contratará al personal que cumpla con los requerimientos del jefe inmediato del solicitante y los solicitados por el puesto.</li>
 <li>Los tipos de contratos en los cuales se dividirá la nómina son los siguientes: 
  <ol>
   <li>Por Obra Determinada</li>
   <li>Por Servicios Profesionales</li>
   <li>Por Tiempo Indeterminado</li>
  </ol>
 </li>
 <li>Se reunirán en un solo contrato los requisitos, las condiciones de validez, de nulidad y de forma incluidas dentro de los contratos de trabajo de la empresa. </li>
 <li>Se deberá firmar una "Carta de Confidencialidad" (responsiva) sobre el comportamiento, la información y equipo de trabajo utilizado durante el cumplimiento de sus servicios.</li>
 <li>Establecer periodos de prueba a los nuevos empleos y cerciorarse de que se cumpla con las obligaciones y actividades establecidas desde un principio. </li>
 <li>Suspender o finalizar el contrato de trabajo con empleados que deban salir de la empresa por cuestiones ajenas a ésta. </li>
 <li>Se realizarán contrataciones temporales en caso de ser necesarias sin necesidad de contrato. </li>
 <li>El nuevo personal contratado deberá dejar una copia de ciertos documentos en custodia de la Coordinación de Personal como garantía de su compromiso con la empresa. 
Dichos documentos se presentan a continuación:

  <ol>
   <li>Comprobante de Domicilio</li>
   <li>Copia de credencial del IFE </li>
   <li>Copia de CURP</li>
   </ol>
 </li>
 <li>De igual forma deberá llenar el formato de "Información del Empleado Administrativo o Técnico" dependiendo su caso para la corroboración de sus datos.</li>
 <li>No calificarán para el puesto los candidatos que no cubran con los requisitos respecto a la documentación mencionada con anterioridad.</li>
 <li>El empleado que requiera algún porcentaje de su sueldo siguiendo la prestación de Seguro Social (IMSS), deberá negociarlo directamente con el Director General de la empresa.</li>
 </ul>
</p>
<p style="text-align: center;">
<img src="./images/contratacion.png" align="absmiddle" style="padding-right: 20px;" />
</p>
</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     