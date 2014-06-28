<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Sueldos del Personal</title>

<?php

@ require_once ('header.php'); 
echo "<h1>Sueldos del Personal</h1>";
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

<h1>Registro de Sueldos del Personal</h1>

<div id="texto">

<p>
El presente apartado facilitará a la administración de la empresa en general (Dirección General, Contabilidad, Tesorería y Personal) todos los movimientos y aclaraciones que se deban hacer sobre cualquier sueldo relacionado con los empleados de la empresa.
</p>
<p>
Por otro lado, dará pié y rapidez a los ajustes que se tengan que hacer sobre estos en caso de que existiera alguna variación por una errónea captura o una modificación sobre el mismo.
</p><img src="./images/sueldos.png"  align="left" style="padding-right: 20px; padding-bottom: 10px;" />
<p>
Puntos a considerar:
</p>
<ul>
 <li>El registro de las modificaciones de sueldo (Aumento Autorizado y/o Aumento de Porcentaje de Sueldo en IMSS) deberá estar registrado en su formato correspondiente y deberá ser firmado por el Director General de INCA para tener validez y pueda ser considerado.</li>
 <li>El <b>Sueldo Bruto</b> expresado en el presente apartado no reflejará ningún tipo de impuestos sobre él al realizar el pago del mismo y tampoco incluirá la Foraneidad del empleado en caso de haber sido otorgada a éste.</li>
 <li>En caso de que el sueldo esté dividido en Nómina y Honorarios, de igual forma se presentará la cifra bruta de cada una de las cantidades y en caso de que sea por Factura de Honorarios no se le aumentará el IVA a la cantidad presentada.</li>
 <li>En caso de que se presente el finiquito del empleado deberá haber una copia firmada por el Representante de la Empresa y por el empleado involucrado donde se llegue al acuerdo de una renuncia voluntaria por parte del empleado (Formato Finiquito).</li>
</ul>
</div>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     