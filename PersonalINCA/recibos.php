<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Recibos de Honorarios</title>

<?php 

@ require_once ('header.php');
echo "<script type='text/javascript' src='js/recibos.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Recibos de Honorarios</h1>\n";

@ require_once ('header2.php');


if(!isset($_SESSION["uloged"])){
  echo "<SCRIPT LANGUAGE=\"JavaScript\">
	   <!--
	   window.location=\"login.php?pag=".
	   substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1)."\";
	   // -->
	   </script>";
} else {

include ("../Acceso.php");
?>

<!-- BUSQUEDA DE EMPLEADOS -->
<article class="clearfix" id="buscar">

<div id="left">

<div id="search">
<form action="buscarRecibos.php" method="post" id="buscar_empleado">
 
 		<input type="hidden" id="page" name="page" value="" />
        <input type="hidden" id="nombre2" name="nombre2" value="" />
        <input type="hidden" id="gerencia2" name="gerencia2" value="" />
        <input type="hidden" id="ubicacion2" name="ubicacion2" value="" />
        <input type="hidden" id="obra2" name="obra2" value="" />
        <input type="hidden" id="empresa2" name="empresa2" value="" />
        <input type="hidden" id="tipo2" name="tipo2" value="" />
        <input type="hidden" id="finiquitado2" name="finiquitado2" value="" />
 
    	<div class="etiqueta2">Nombre:</div>
        <input type="text" id="nombre" name="nombre" minlength="2" value="" style="width: 245px;"/>
        
        <div class="etiqueta2">Coordinaci&oacute;n/Gerencia:</div>
        <select name="gerencia" id="gerencia">
        	<option value="-1" selected='selected'>Cualquiera</option>
        <?php
			$result = $miconexion->consulta("SELECT * FROM gerencias;");
			if (mysql_num_rows($result)!=0) {
				while ($row = mysql_fetch_array($result)) {
					echo "<option value='".$row["id_gerencia"].
					"'>".htmlentities($row["nombre"])."</option>\n";
				}
			}
		
		?>
        </select>
        
        <div class="etiqueta2">Ubicaci&oacute;n:</div>
        <select name="ubicacion" id="ubicacion">
        	<option value="-1" selected='selected'>Cualquiera</option>
            <option value="0">Oficina Central WTC</option>
            <option value="1">Oficina Monterrey</option>
            <option value="2">Activo en Obra</option>
        </select>
        
        <div class="etiqueta2">Obra:</div>
        <select name="obra" id="obra">
        	<option value="-1" selected='selected'>Cualquiera</option>
            <?php
			$result = $miconexion->consulta("SELECT * FROM obras;");
			if (mysql_num_rows($result)!=0) {
				while ($row = mysql_fetch_array($result)) {
					echo "<option value='".$row["id_obra"].
					"'>".htmlentities($row["nombre"])."</option>\n";
				}
			}		
			?>
        </select>
        
        <div class="etiqueta2">Empresa Contratante:</div>
        <select name="empresa" id="empresa">
        	<option value="-1" selected='selected'>Cualquiera</option>
            <option value="0">INCA</option>
            <option value="1">SAM</option>
            <option value="2">SUCA</option>
            <option value="3">SAM/SUCA</option>
        </select>
        
        <div class="etiqueta2">Tipo de Contrataci&oacute;n:</div>
        <select name="tipo" id="tipo">
        	<option value="-1" selected='selected'>Cualquiera</option>
            <option value="0">IMSS</option>
            <option value="1">IMSS/Recibo de Honorarios</option>
            <option value="2">Factura de Honorarios</option>
        </select>
        
        <div class="etiqueta2">Finiquitado:</div>
        <select name="finiquitado" id="finiquitado">
            <option value="0" selected='selected'>No</option>
            <option value="1">Sí</option>
            <option value="2">Ambos</option>
        </select>
        
        <br />
        <div class="etiqueta2">
		<input type="submit" value="Buscar" id="doBuscar"/></div>

</form>
</div>
</div>

<div id="right">

</div>

</article>

<!-- DATOS -->
<article class="clearfix" id="datos">

<h1 id="label_im">Modificar Recibos de Honorarios</h1>

<form action="modificarRecibos.php" method="post" id="change-form" enctype='multipart/form-data'>
   <div class="linea">
        <div class="etiqueta" for="faltantes">Recibos Faltantes:</div>
        <input type="text" id="faltantes" name="faltantes" class="required" minlength="1" maxlength="3" value="" />
   </div>
    
   <div class="linea">
        <div class="etiqueta" for="ultimo_recibo">&Uacute;ltimo Recibo:</div>
        <div id="ultimo_recibo_div">
        <input type="file" id="ultimo_recibo" name="ultimo_recibo" value="" />
        </div>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="ultimo_recibo">&nbsp;</div>
        <div id="ultimo_recibo_eliminar" style="display: inline;">
        	<div id="ultimo_recibo_actual" style="display: inline; float: left; padding-right: 25px;">
            	<a href="#"> Ver archivo</a>
            </div>
        	<div style="display: inline;">
            	<input type="checkbox" id="eliminar_ultimo_recibo" name="eliminar_ultimo_recibo" />
                Eliminar archivo
            </div>
        	
        </div>
    </div> 
    
    <div class="linea">
        <div class="etiqueta" for="penultimo_recibo">Pen&uacute;ltimo Recibo:</div>
        <div id="penultimo_recibo_div">
        <input type="file" id="penultimo_recibo" name="penultimo_recibo" value="" />
        </div>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="penultimo_recibo">&nbsp;</div>
        <div id="penultimo_recibo_eliminar" style="display: inline;">
        	<div id="penultimo_recibo_actual" style="display: inline; float: left; padding-right: 25px;">
            	<a href="#"> Ver archivo</a>
            </div>
        	<div style="display: inline;">
            	<input type="checkbox" id="eliminar_penultimo_recibo" name="eliminar_penultimo_recibo" />
                Eliminar archivo
            </div>
        	
        </div>
    </div>   
    
    <div class="linea">
        <input type="hidden" value="" name="id_empleado" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>    
        				
</form>

</article>

  
<?php 
@ require_once ('footer.php');
  }
?>     