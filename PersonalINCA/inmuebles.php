<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Inmuebles INCA</title>

<?php 

@ require_once ('header.php');
@ require_once ('scriptsEmpleados.php');
echo "<script type='text/javascript' src='js/inmuebles.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Inmuebles INCA</h1>\n";

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

<!-- BUSQUEDA DE INMUEBLES -->
<article class="clearfix" id="consulta">
<?php 
if ($_SESSION['nivel'] == 0) {
?>
<div class="buttons" style="width: 256px; margin: 0 auto;">
	<p style="text-align:center;">
	<a style="width: 256px; margin: 0 auto;" id="insertar">
        <img src="./images/Button-Add-icon.png" alt=""/> 
        Insertar Inmueble
    </a>
    </p>
</div>

<p><hr /></p>
<?php 
}
?>
<div id="tabla">

</div>

</article>

<!-- DATOS DEL INMUEBLE -->
<article class="clearfix" id="datos">

<h1 id="label_im">Insertar un Inmueble</h1>

<form action="insertarInmuebles.php" method="post" id="modinsertar" enctype='multipart/form-data'>

	<div class="linea">
        <div class="etiqueta" for="localidad">Localidad:</div>
        <select id="localidad" name="localidad">
            <option value="-1" selected='selected'>Ninguna</option>
            <?php
                $result = $miconexion->consulta("SELECT * FROM localidades_inmuebles ORDER BY nombre ASC;");
                if (mysql_num_rows($result)!=0) {
                    while ($row = mysql_fetch_array($result)) {
						echo "<option value='".$row["id_localidad"].
						"'>".htmlentities($row["nombre"])."</option>\n";
                    }
                }
            
            ?>
        </select>
    </div>

	<div class="linea">
        <div class="etiqueta" for="ubicacion">Ubicaci&oacute;n:</div>
        <textarea cols="40" rows="4" name="ubicacion" class="required"></textarea>
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="tipo">Tipo:</div>
        <select id="tipo" name="tipo">
            <option value="0" selected='selected'>Oficina</option>
            <option value="1">Campamento</option>
            <option value="2">Campamento/Oficina</option>
        </select>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="renta">Renta:</div>
        $<input type="text" id="renta" name="renta" class="required" minlength="2" value="" />
    </div> 
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion" />
        <input type="hidden" value="" name="id_inmueble" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>
    
        				
</form>

<!--- <iframe name='submit-iframe' style='display: none;'></iframe> --->

</article>

<!-- ASIGNACION DE EMPLEADOS -->
<article id="asignacion" class="clearfix" >

<h1 id="label_ima">Asignaci&oacute;n de Empleados</h1>

<form action="consultarAsignacionEmpleados.php" method="post" id="emp" enctype='multipart/form-data'>

	<div class="linea">
        <div class="etiqueta" for="empleado">Empleado:</div>
        <select id="empleado" name="empleado">
        	<option value="-1" selected="selected">Selecciona Empleado</option>
            <?php
                $result = $miconexion->consulta("SELECT * FROM empleados WHERE estado_foraneidad = 1 ORDER BY nombre ASC, apellido_paterno ASC;");
                if (mysql_num_rows($result)!=0) {
                    while ($row = mysql_fetch_array($result)) {
						echo "<option value='".$row["id_empleado"].
						"'>".htmlentities($row["nombre"])." ".htmlentities($row["apellido_paterno"]).
						" ".htmlentities($row["apellido_materno"])."</option>\n";
                    }
                }
            
            ?>
        </select>
        <?php
			echo "<a href='#' onclick='return addEmpleado(".
					")' title='Asignar empleado a inmueble'><img src='images/Button-Add-icon.png' /></a>"
		?>
        
    </div>
    
    <div class="linea" id="lista">
    	
    </div>
        
    <div class="linea">
        <input type="hidden" value="" name="id_inmueblea" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <button id="regresar" > Regresar </button>
    </div>
    
        				
</form>

<!--- <iframe name='submit-iframe' style='display: none;'></iframe> --->

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     