<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>INCA Base de Datos Personal - Empleados</title>

<?php 

@ require_once ('header.php');
@ require_once ('scriptsEmpleados.php');
@ require_once ('header1.php');
echo "<h1>Empleados</h1>\n";

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
<?php
if ($_SESSION['nivel'] == 0) {
?>
<div class="buttons">
	<p style="text-align:center;">
	<a  style="width: 256px;" id="insertar">
        <img src="./images/Button-Add-icon.png" alt=""/> 
        Insertar Empleado
    </a>
    </p>
</div>
<?php
}
?>
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

<!-- DATOS DEL EMPLEADO -->
<article class="clearfix" id="datos">

<h1 id="label_im">Insertar un Empleado</h1>

<form action="insertarEmpleados.php" method="post" id="change-form" enctype='multipart/form-data'>

	<div class="linea">
        <div class="etiqueta" for="nombrei">Nombre:</div>
        <input type="text" id="nombrei" name="nombrei" class="required" minlength="2" maxlength="25" value="" style="width: 250px;" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="apellidop">Apellido Paterno:</div>
        <input type="text" id="apellidop" name="apellidop" class="required" minlength="2" maxlength="25" value="" style="width: 250px;" />
    </div>
    
     <div class="linea">
        <div class="etiqueta" for="apellidom">Apellido Materno:</div>
        <input type="text" id="apellidom" name="apellidom" class="required" minlength="2" maxlength="25" value="" style="width: 250px;" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="puestoi">Puesto:</div>
        <input type="text" id="puestoi" name="puestoi" class="required" minlength="2" maxlength="50" value="" style="width: 250px;" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="jefe_inmediato">Jefe Inmediato:</div>
        <select id="jefe_inmediato" name="jefe_inmediato">
        	<option value="-1" selected='selected'>Ninguno</option>
            <?php
			$result = $miconexion->consulta("SELECT * FROM empleados ORDER BY nombre ASC;");
			if (mysql_num_rows($result)!=0) {
				while ($row = mysql_fetch_array($result)) {
					echo "<option value='".$row["id_empleado"].
					"'>".htmlentities($row["nombre"].
						" ".$row["apellido_paterno"]." ".$row["apellido_materno"])."</option>\n";
				}
			}		
			?>
        </select>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="coordinacion_gerencia">Coordinaci&oacute;n/Gerencia:</div>
        <select id="coordinacion_gerencia" name="coordinacion_gerencia">
            <option value="-1" selected='selected'>Ninguna</option>
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
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="ubicacioni">Ubicaci&oacute;n:</div>
        <select id="ubicacioni" name="ubicacioni">
            <option value="0" selected='selected'>Oficina Central WTC</option>
            <option value="1">Oficina Monterrey</option>
            <option value="2">Activo en Obra</option>
        </select>
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="obra_lugar">Obra-Lugar:</div>
    	<select id="obra_lugar" name="obra_lugar">
        	<option value="-1" selected='selected'>Ninguna</option>
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
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="fecha_ingreso">Fecha de Ingreso:</div>
        <input type="text" id="fecha_ingreso" name="fecha_ingreso">
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="empresa_contratante">Empresa Contratante:</div>
        <select id="empresa_contratante" name="empresa_contratante">
            <option value="0" selected='selected'>INCA</option>
            <option value="1">SAM</option>
            <option value="2">SUCA</option>
            <option value="3">INCA/SUCA</option>
            <option value="4">SAM/SUCA</option>
        </select>
    </div>

	<div class="linea">
    	<div class="etiqueta" for="tipo_contratacion">Tipo de Contrataci&oacute;n:</div>
        <select id="tipo_contratacion" name="tipo_contratacion">
             <option value="0" selected="selected">IMSS</option>
             <option value="1">Recibo de Honorarios</option>
             <option value="2">IMSS/Recibo de Honorarios</option>
             <option value="3">Factura de Honorarios</option>
             <option value="4">Pago por Asimilables</option>
        </select>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="sueldo_bruto_mensual">Sueldo Bruto Mensual:</div>
        $<input type="text" id="sueldo_bruto_mensual" name="sueldo_bruto_mensual" class="required" minlength="2" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="porcentaje_imss">Porcentaje IMSS:</div>
        <input type="text" id="porcentaje_imss" name="porcentaje_imss" value="" />
    </div>
    
     <div class="linea">
    	<div class="etiqueta" for="fecha_nacimiento">Fecha de Nacimiento:</div>
        <input type="text" id="fecha_nacimiento" name="fecha_nacimiento">
    </div>
    
    <div class="linea">
    	<div class="etiqueta" for="estado_civil">Estado Civil:</div>
        <select id="estado_civil" name="estado_civil">
             <option value="0" selected="selected">Soltero/a</option>
             <option value="1">Casado/a</option>
             <option value="2">Divorciado/a</option>
             <option value="3">Viudo/a</option>
        </select>
    </div>

	<div class="linea">
        <div class="etiqueta" for="lugar_de_origen">Lugar de Origen:</div>
        <input type="text" id="lugar_de_origen" name="lugar_de_origen" class="required" minlength="2" maxlength="75" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="domicilio_actual">Domicilio Actual:</div>
        <textarea cols="40" rows="4" name="domicilio_actual" class="required"></textarea>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="email">Correo Electr&oacute;nico:</div>
        <input type="text" id="email" name="email" class="required email" minlength="2" maxlength="75" value=""  style="width: 250px;"/>
    </div>
    
     <div class="linea">
     	<div class="etiqueta" for="nacionalidad">Nacionalidad:</div>
     	<select name="nacionalidad" id="nacionalidad">';
    <?php

    $array_paises = array("Mexico","Afganistan","Africa del Sur","Albania","Alemania","Andorra","Angola","Antigua y Barbuda","Antillas Holandesas","Arabia Saudita","Argelia","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarusia","Belgica","Belice","Benin","Bermudas","Bolivia","Bosnia","Botswana","Brasil","Brunei Darussulam","Bulgaria","Burkina Faso","Burundi","Butan","Camboya","Camerun","Canada","Cape Verde","Chad","Chile","China","Chipre","Colombia","Comoros","Congo","Corea del Norte","Corea del Sur","Costa de Marfíl","Costa Rica","Croasia","Cuba","Dinamarca","Djibouti","Dominica","Ecuador","Egipto","El Salvador","Emiratos Arabes Unidos","Eritrea","Eslovenia","España","Estados Unidos","Estonia","Etiopia","Fiji","Filipinas","Finlandia","Francia","Gabon","Gambia","Georgia","Ghana","Granada","Grecia","Groenlandia","Guadalupe","Guam","Guatemala","Guayana Francesa","Guerney","Guinea","Guinea-Bissau","Guinea Equatorial","Guyana","Haiti","Holanda","Honduras","Hong Kong","Hungria","India","Indonesia","Irak","Iran","Irlanda","Islandia","Islas Caiman","Islas Faroe","Islas Malvinas","Islas Marshall","Islas Solomon","Islas Virgenes Britanicas","Islas Virgenes (U.S.)","Israel","Italia","Jamaica","Japon","Jersey","Jordania","Kazakhstan","Kenia","Kiribati","Kuwait","Kyrgyzstan","Laos","Latvia","Lesotho","Libano","Liberia","Libia","Liechtenstein","Lituania","Luxemburgo","Macao","Macedonia","Madagascar","Malasia","Malawi","Maldivas","Mali","Malta","Marruecos","Martinica","Mauricio","Mauritania","Micronesia","Moldova","Monaco","Mongolia","Mozambique","Myanmar (Burma)","Namibia","Nepal","Nicaragua","Niger","Nigeria","Noruega","Nueva Caledonia","Nueva Zealandia","Oman","Pakistan","Palestina","Panama","Papua Nueva Guinea","Paraguay","Peru","Polinesia Francesa","Polonia","Portugal","Puerto Rico","Qatar","Reino Unido","Republica Centroafricana","Republica Checa","Republica Democratica del Congo","Republica Dominicana","Republica Eslovaca","Reunion","Ruanda","Rumania","Rusia","Sahara","Samoa","San Cristobal-Nevis (St. Kitts)","San Marino","San Vincente y las Granadinas","Santa Helena","Santa Lucia","Santa Sede (Vaticano)","Sao Tome & Principe","Senegal","Seychelles","Sierra Leona","Singapur","Siria","Somalia","Sri Lanka (Ceilan)","Sudan","Suecia","Suiza","Sur Africa","Surinam","Swaziland","Tailandia","Taiwan","Tajikistan","Tanzania","Timor Oriental","Togo","Tokelau","Tonga","Trinidad & Tobago","Tunisia","Turkmenistan","Turquia","Ucrania","Uganda","Union Europea","Uruguay","Uzbekistan","Vanuatu","Venezuela","Vietnam","Yemen","Yugoslavia","Zambia","Zimbabwe");
    $cantidad_paises = count($array_paises);
	$nombre_del_select = "Mexico";
    for($i = 0; $i<$cantidad_paises; $i++){
        $array_paises_i = $array_paises[$i];
        echo '<option value="'.$array_paises_i.'"'; 
            if($nombre_del_select=="$array_paises_i"){
                    echo " selected='selected'";
            }
        echo '>'.$array_paises_i.'</option>';
    }
?> 
		</select>
		</div>

    <div class="linea">
    	<div class="etiqueta" for="grado_de_estudios">Grado de estudios:</div>
        <select id="grado_de_estudios" name="grado_de_estudios">
        	<option value="0">Primaria</option>
            <option value="1">Secundaria</option>
            <option value="2">Bachillerato Trunco</option>
            <option value="3">Bachillerato Técnico</option>
            <option value="4">Bachillerato</option>
            <option value="5">Licenciatura Trunca</option>
            <option value="6" selected="selected">Licenciatura</option>
            <option value="7">Maestría Trunca</option>
            <option value="8">Maestría</option>
        </select>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="rfc">RFC:</div>
        <input type="text" id="rfc" name="rfc" class="required" minlength="13" maxlength="13" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="curp">CURP:</div>
        <input type="text" id="curp" name="curp" class="required" minlength="18" maxlength="18" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="tel">Tel&eacute;fono:</div>
        <input type="text" id="tel" name="tel" class="required" minlength="6" maxlength="30" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="extension">Extensi&oacute;n:</div>
        <input type="text" id="extension" name="extension" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="archivo_alta">Archivo de Alta:</div>
        <div id="archivo_alta_div">
        <input type="file" id="archivo_alta" name="archivo_alta" value="" />
        </div>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="archivo_alta">&nbsp;</div>
        <div id="archivo_alta_eliminar" style="display: inline;">
        	<div id="archivo_alta_actual" style="display: inline; float: left; padding-right: 25px;">
            	<a href="#"> Ver archivo</a>
            </div>
        	<div style="display: inline;">
            	<input type="checkbox" id="eliminar_archivo_alta" name="eliminar_archivo_alta" />
                Eliminar archivo
            </div>
        	
        </div>
    </div>   
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion" />
        <input type="hidden" value="" name="id_empleado" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar" > Cancelar </button>
    </div>
    
        				
</form>

<iframe name='submit-iframe' style='display: none;'></iframe>

</article>

<!-- FINIQUITO -->
<article class="clearfix" id="finiquito">
	
<h1 id="label_im_finiquito">Finiquitar Empleado</h1>

<form action="finiquitarEmpleados.php" method="post" id="formfiniquito" enctype='multipart/form-data'>

	<div class="linea" id="eliminar_finiquito_div">
    	<div class="etiqueta" for="eliminar_finiquito">Eliminar Finiquito:</div>
        <input type="checkbox" id="eliminar_finiquito" name="eliminar_finiquito" />
    </div>

	<div id="datos_finiquito">

	 <div class="linea">
    	<div class="etiqueta" for="fecha_finiquito">Fecha de Finiquito:</div>
        <input type="text" id="fecha_finiquito" name="fecha_finiquito">
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="monto_finiquito">Monto:</div>
        $<input type="text" id="monto_finiquito" name="monto_finiquito" class="required" minlength="1" value="" />
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="archivo_finiquito">Archivo de Finiquito:</div>
        <div id="archivo_finiquito_div">
        <input type="file" id="archivo_finiquito" name="archivo_finiquito" value="" />
        </div>
    </div>
    
    <div class="linea">
        <div class="etiqueta" for="archivo_finiquito">&nbsp;</div>
        <div id="archivo_finiquito_eliminar" style="display: inline;">
        	<div id="archivo_finiquito_actual" style="display: inline; float: left; padding-right: 25px;">
            	<a href="#"> Ver archivo</a>
            </div>
        	<div style="display: inline;">
            	<input type="checkbox" id="eliminar_archivo_finiquito" name="eliminar_archivo_finiquito" />
                Eliminar archivo
            </div>
        	
        </div>
    </div>
    
    </div>
    
    <div class="linea">
    	<input type="hidden" value="insertar" name="accion_finiquito" />
        <input type="hidden" value="" name="id_empleado_finiquito" />
    </div>
    
    <div class="linea">
        <div class="etiqueta"> &nbsp; </div>
        <input type="submit" value="Aceptar" />
        <button id="cancelar_finiquito" > Cancelar </button>
    </div>
    
</form>
</article>
  
<?php 
@ require_once ('footer.php');
  }
?>     