<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Pr&eacute;stamos INCA</title>

<?php 

@ require_once ('header.php');
echo "<script type='text/javascript' src='js/prestamos.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Pr&eacute;stamos INCA</h1>\n";

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
<form action="buscarPrestamos.php" method="post" id="buscar_empleado">
 
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
            <option value="3">INCA/SUCA</option>
            <option value="4">SAM/SUCA</option>
        </select>
        
        <div class="etiqueta2">Tipo de Contrataci&oacute;n:</div>
        <select name="tipo" id="tipo">
        	<option value="-1" selected='selected'>Cualquiera</option>
            <option value="0">IMSS</option>
            <option value="1">Recibo de Honorarios</option>
            <option value="2">IMSS/Recibo de Honorarios</option>
            <option value="3">Factura de Honorarios</option>
            <option value="4">Pago por Asimilables</option>
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

<!-- DATOS DE PRESTAMOS -->
<article class="clearfix" id="datos">

<h1 id="label_im">Agregar Pr&eacute;stamo</h1>

<form action="insertarViaticos.php" method="post" id="change-form" enctype='multipart/form-data'>
    
    <div class="linea">
    	<div class="etiqueta" for="monto">Monto:</div>
        $<input type="text" id="monto" name="monto" class="required">
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="fecha_solicitud">Fecha de solicitud:</div>
        <input type="text" id="fecha_solicitud" name="fecha_solicitud" class="required">
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="fecha_fin">Fecha de fin:</div>
        <input type="text" id="fecha_fin" name="fecha_fin" class="required">
    </div>  
    
    <div class="linea">
    	<div class="etiqueta" for="estado">Estado:</div>
        <select id="estado" name="estado">
        	<option value="0">Activo</option>
            <option value="1">Pagado</option>            
        </select>
    </div> 
    
	<div class="linea">
        <div class="etiqueta" for="archivo">Archivo:</div>
        <div id="archivo_div">
        <input type="file" id="archivo" name="archivo" value="" />
        </div>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="archivo">&nbsp;</div>
        <div id="archivo_eliminar" style="display: inline;">
        	<div id="archivo_actual" style="display: inline; float: left; padding-right: 25px;">
            	<a href="#"> Ver archivo</a>
            </div>
        	<div style="display: inline;">
            	<input type="checkbox" id="eliminar_archivo" name="eliminar_archivo" />
                Eliminar archivo
            </div>
        	
        </div>
    </div>
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion" />
        <input type="hidden" value="" name="id_empleado" />
        <input type="hidden" value="" name="id_prestamo" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>
    
        				
</form>

<iframe name='submit-iframe' style='display: none;'></iframe>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     