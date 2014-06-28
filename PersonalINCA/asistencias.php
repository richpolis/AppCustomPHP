<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Control de Asistencias</title>

<?php 

@ require_once ('header.php');
echo "<script type='text/javascript' src='js/asistencias.js'></script>";
echo "<script type='text/javascript' src='js/jquery.validate.js'></script>";
echo "<script type='text/javascript' src='js/jExpand.js'></script>";
@ require_once ('header1.php');
echo "<h1>Control de Asistencias</h1>\n";

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

<div style="display: inline; float: left; padding: 0 30px 0 30px;">
<input type="radio" name="grupo" id="rbfaltas" class="faltaarchivo" value="Milk" checked> Faltas 
</div>
<div style="display: inline; float: left;">
<input type="radio" name="grupo" id="rbarchivos" class="faltaarchivo"  value="Butter"> Archivos 
</div>

<div id="search">
<form action="buscarEmpleados.php" method="post" id="buscar_empleado">
 
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

<!-- DATOS DE FALTAS -->
<article class="clearfix" id="datos">

<h1 id="label_im">Agregar una Falta</h1>

<form action="insertarFaltas.php" method="post" id="change-form" enctype='multipart/form-data'>
    
     <div class="linea">
    	<div class="etiqueta" for="fecha">Fecha:</div>
        <input type="text" id="fecha" name="fecha" class="required">
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="motivo">Motivo:</div>
        <textarea cols="40" rows="4" name="motivo"></textarea>
    </div> 
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion" />
        <input type="hidden" value="" name="id_empleado" />
        <input type="hidden" value="" name="id_falta" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>
    
        				
</form>

</article>

<!-- DATOS DE ARCHIVOS DE FALTAS -->
<article class="clearfix" id="datosa">

<h1 id="label_ima">Agregar un Archivo Mensual de Faltas</h1>

<form action="insertarFaltas.php" method="post" id="change-forma" enctype='multipart/form-data'>
    
     <div class="linea">
     	<div class="etiqueta" for="mes">Mes:</div>
     	<select name="mes" id="mes">';
		<?php
    
        $array_meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $cantidad_meses = count($array_meses);
        $nombre_del_select = date('m');
        $c = 1;
        for($i = 0; $i<$cantidad_meses; $i++){
            $array_meses_i = $array_meses[$i];
            echo '<option value="'.$c.'"'; 
                if($nombre_del_select==$c){
                        echo " selected='selected'";
                }
            echo '>'.$array_meses_i.'</option>';
            $c++;
        }
        ?> 
        </select>
    </div>
    
    <div class="linea">
     	<div class="etiqueta" for="ano">A&ntilde;o:</div>
     	<select name="ano" id="ano">';
		<?php
        $cantidad_anos = 100;
        $nombre_del_select = date('Y');
        $c = 1990;
        for($i = $c; $i<$c + $cantidad_anos; $i++){
            echo '<option value="'.$i.'"'; 
                if($nombre_del_select==$i){
                        echo " selected='selected'";
                }
            echo '>'.$i.'</option>';
        }
        ?> 
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
    	<input type="hidden" value="insertar" name="acciona" />
        <input type="hidden" value="" name="id_empleadoa" />
        <input type="hidden" value="" name="id_archivo_faltas" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelara" > Cancelar </button>
    </div>
    
        				
</form>

<iframe name='submit-iframe' style='display: none;'></iframe>

</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     