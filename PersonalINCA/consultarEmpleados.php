<?php
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

if (isset($_REQUEST["class"]))
	$class = $_REQUEST['class'];

$query = "SELECT * FROM empleados WHERE id_empleado = $id";

$result = $miconexion->consulta($query);

$row = mysql_fetch_array($result);

if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
	$arr = explode('-', $row["fecha_ingreso"]);
	$fecha_ingreso = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	$arr = explode('-', $row["fecha_nacimiento"]);
	$fecha_nacimiento = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	if ($row["fecha_finiquito"] != NULL) {
		$arr = explode('-', $row["fecha_finiquito"]);
		$fecha_finiquito = $arr[2].'/'.$arr[1].'/'.$arr[0];
	}
	else {
		$fecha_finiquito = "";
	}
	
	if ($row["archivo_alta"] == NULL)
		$archivo_alta = "";
	else
		$archivo_alta = $row["archivo_alta"];
		
	if ($row["archivo_finiquito"] == NULL)
		$archivo_finiquito = "";
	else
		$archivo_finiquito = $row["archivo_finiquito"];

	//return in JSON format
	$domicilio = str_replace("\n", "\\n", $row["domicilio"]);
	$domicilio = str_replace("\r", "\\r", $domicilio);
	$domicilio = str_replace("\t", "\\t", $domicilio);
	
	$json = "{";
	$json .= "\"nombre\": \"".utf8_encode($row["nombre"])."\",\n";
	$json .= "\"apellido_paterno\": \"".utf8_encode($row["apellido_paterno"])."\",\n";
	$json .= "\"apellido_materno\": \"".utf8_encode($row["apellido_materno"])."\",\n";
	$json .= "\"puesto\": \"".utf8_encode($row["puesto"])."\",\n";
	$json .= "\"jefe_inmediato\": \"".$row["jefe_inmediato"]."\",\n";
	$json .= "\"id_gerencia\": \"".$row["id_gerencia"]."\",\n";
	$json .= "\"ubicacion\": \"".$row["ubicacion"]."\",\n";
	$json .= "\"id_obra\": \"".$row["obra_lugar"]."\",\n";
	$json .= "\"fecha_ingreso\": \"".$fecha_ingreso."\",\n";
	$json .= "\"empresa_contratante\": \"".$row["empresa_contratante"]."\",\n";
	$json .= "\"tipo_contratacion\": \"".$row["tipo_contratacion"]."\",\n";
	$json .= "\"sueldo_bruto_mensual\": \"".$row["sueldo_bruto_mensual"]."\",\n";
	$json .= "\"porcentaje_imss\": \"".$row["porcentaje_imss"]."\",\n";
	$json .= "\"fecha_nacimiento\": \"".$fecha_nacimiento."\",\n";
	$json .= "\"estado_civil\": \"".$row["estado_civil"]."\",\n";
	$json .= "\"lugar_de_origen\": \"".utf8_encode($row["lugar_de_origen"])."\",\n";
	$json .= "\"domicilio\": \"".utf8_encode($domicilio)."\",\n";
	$json .= "\"email\": \"".utf8_encode($row["email"])."\",\n";
	$json .= "\"nacionalidad\": \"".utf8_encode($row["nacionalidad"])."\",\n";
	$json .= "\"grado_de_estudios\": \"".$row["grado_de_estudios"]."\",\n";
	$json .= "\"rfc\": \"".$row["rfc"]."\",\n";
	$json .= "\"curp\": \"".utf8_encode($row["curp"])."\",\n";
	$json .= "\"tel\": \"".utf8_encode($row["tel"])."\",\n";
	$json .= "\"extension\": \"".utf8_encode($row["extension"])."\",\n";
	$json .= "\"archivo_alta\": \"".utf8_encode($archivo_alta)."\",\n";
	$json .= "\"fecha_finiquito\": \"".$fecha_finiquito."\",\n";
	$json .= "\"monto_finiquito\": \"".$row["monto_finiquito"]."\",\n";
	$json .= "\"archivo_finiquito\": \"".$archivo_finiquito."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
} else if (isset($_REQUEST["select"])){ /*** ENVIAMOS LOS DATOS PARA LLENAR EL SELECT  ********/
	$response.= "<option value='-1' selected='selected'>Ninguno</option>";
	$result2 = $miconexion->consulta("SELECT * FROM empleados ORDER BY nombre ASC;");
	if (mysql_num_rows($result2)!=0) {
		while ($row2 = mysql_fetch_array($result2)) {
			$response.= "<option value='".$row2["id_empleado"].
			"'>".htmlentities($row2["nombre"].
				" ".$row2["apellido_paterno"]." ".$row2["apellido_materno"])."</option>\n";
		}
	}
	
	echo $response;
}
else{ /*** ES PARA MOSTRAR LOS DATOS DEL EMPLEADO SOLAMENTE  ********/
	$response = "<td class='$class' colspan='7'>\n";
	$response.= "<div class='con_col'>\n";
	//Nombre
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Nombre: </div><div class='con_valor'>".htmlentities($row["nombre"]).
				" ".htmlentities($row["apellido_paterno"])." ".htmlentities($row["apellido_materno"])."</div>\n";
	$response.= "	</div>\n";
	//Puesto
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Puesto: </div><div class='con_valor'>".htmlentities($row["puesto"])."</div>\n";
	$response.= "	</div>\n";
	//Jefe inmediato
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Jefe Inmediato: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	if ($row["jefe_inmediato"] == NULL) {
		$response .= "Ninguno\n";
	}
	else {
		$result = $miconexion->consulta("SELECT * FROM empleados WHERE id_empleado = ".$row["jefe_inmediato"].";");
		$row2 = mysql_fetch_array($result);
		$response .= htmlentities($row2["nombre"])." ".htmlentities($row2["apellido_paterno"]).
					" ".htmlentities($row2["apellido_materno"])."\n";
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Coordinacion/Gerencia
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Coordinaci&oacute;n / Gerencia: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	if ($row["id_gerencia"] == NULL) {
		$response .= "Ninguna\n";
	}
	else {
		$result = $miconexion->consulta("SELECT * FROM gerencias WHERE id_gerencia = ".$row["id_gerencia"].";");
		$row2 = mysql_fetch_array($result);
		$response .= htmlentities($row2["nombre"])."\n";
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Ubicacion
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Ubicaci&oacute;n: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	switch ($row["ubicacion"]) {
		case 0:
			$response .= "Oficina Central WTC\n";
			break;
		case 1:
			$response .= "Oficina Monterrey\n";
			break;
		case 2:
			$response .= "Activo en Obra\n";
			break;		
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Obra/Lugar
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Obra-Lugar: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	if ($row["obra_lugar"] == NULL) {
		$response .= "Ninguna\n";
	}
	else {
		$result = $miconexion->consulta("SELECT * FROM obras WHERE id_obra = ".$row["obra_lugar"].";");
		$row2 = mysql_fetch_array($result);
		$response .= htmlentities($row2["nombre"])."\n";
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Fecha ingreso
	$arr = explode('-', $row["fecha_ingreso"]);
	$fecha_ingreso = $arr[2].'/'.$arr[1].'/'.$arr[0];
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Fecha de Ingreso: </div><div class='con_valor'>".$fecha_ingreso."</div>\n";
	$response.= "	</div>\n";
	//Empresa Contratante
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Empresa Contratante: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	switch ($row["empresa_contratante"]) {
		case 0:
			$response .= "INCA\n";
			break;
		case 1:
			$response .= "SAM\n";
			break;
		case 2:
			$response .= "SUCA\n";
			break;	
		case 3:
			$response .= "INCA/SUCA\n";
			break;
		case 4:
			$response .= "SAM/SUCA\n";
			break;	
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Tipo de Contratacion
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Tipo de Contrataci&oacute;n: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	switch ($row["tipo_contratacion"]) {
		case 0:
			$response .= "IMSS\n";
			break;
		case 1:
			$response .= "Recibo de Honorarios\n";
			break;
		case 2:
			$response .= "IMSS/Recibo de Honorarios\n";
			break;					
		case 3:
			$response .= "Factura de Honorarios\n";
			break;
		case 4:
			$response .= "Pago por Asimilables\n";
			break;
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Sueldo Bruto Mensual
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Sueldo Bruto Mensual: </div><div class='con_valor'>$ ".
				$row["sueldo_bruto_mensual"]."</div>\n";
	$response.= "	</div>\n";   
	//Porcentaje IMSS
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Porcentaje IMSS: </div><div class='con_valor'>";
		
	switch ($row["tipo_contratacion"]) {
		case 0: $response.= $row["porcentaje_imss"]." %\n";
			break;
		case 1: $response.= "Ninguno\n";
			break;
		case 2: $response.= $row["porcentaje_imss"]." %\n";
			break;
		case 3:
		case 4: $response.= "Ninguno\n";
			break;
	}	
	$response.= "		</div>\n";
	$response.= "	</div>\n"; 
	//Domicilio Actual
	$domicilio = str_replace(array("\r\n", "\n", "\r"), '<br />', htmlentities($row["domicilio"]));
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Domicilio Actual: </div><div class='con_valor'>".
				$domicilio."</div>\n";
	$response.= "	</div>\n";
	//Correo electronico
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Correo Electr&oacute;nico: </div><div class='con_valor'>".
				htmlentities($row["email"])."</div>\n";
	$response.= "	</div>\n";
	
	
	$response.= "</div>\n";
	$response.= "<div class='con_col'>\n";
	  
	
	//Fecha nacimiento
	$arr = explode('-', $row["fecha_nacimiento"]);
	$fecha = $arr[2].'/'.$arr[1].'/'.$arr[0];
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Fecha de Nacimiento: </div><div class='con_valor'>".$fecha."</div>\n";
	$response.= "	</div>\n"; 
	//Lugar de Origen
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Lugar de Origen: </div><div class='con_valor'>".
				htmlentities($row["lugar_de_origen"])."</div>\n";
	$response.= "	</div>\n";
	//Nacionalidad
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Nacionalidad: </div><div class='con_valor'>".
				htmlentities($row["nacionalidad"])."</div>\n";
	$response.= "	</div>\n"; 
	//Estado Civil
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Estado Civil: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	switch ($row["estado_civil"]) {
		case 0:
			$response .= "Soltero/a\n";
			break;
		case 1:
			$response .= "Casado/a\n";
			break;
		case 2:
			$response .= "Divorciado/a\n";
			break;	
		case 3:
			$response .= "Viudo/a\n";
			break;	
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//Grado de estudios
	$response.= "	<div class='con_linea'>\n";
	$response.= "		<div class='con_eti'> Grado de estudios: </div>\n";
	$response .= "		<div class='con_valor'>\n";
	switch ($row["grado_de_estudios"]) {
		case 0:
			$response .= "Primaria\n";
			break;
		case 1:
			$response .= "Secundaria\n";
			break;
		case 2:
			$response .= "Bachillerato Trunco\n";
			break;	
		case 3:
			$response .= "Bachillerato Técnico\n";
			break;	
		case 4:
			$response .= "Bachillerato\n";
			break;
		case 5:
			$response .= "Licenciatura Trunca\n";
			break;
		case 6:
			$response .= "Licenciatura\n";
			break;
		case 7:
			$response .= "Maestría Trunca\n";
			break;
		case 8:
			$response .= "Maestría\n";
			break;
	}
	$response .= "		</div>\n";
	$response.= "	</div>\n";
	//RFC
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> RFC: </div><div class='con_valor'>".
				htmlentities($row["rfc"])."</div>\n";
	$response.= "	</div>\n"; 
	//CURP
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> CURP: </div><div class='con_valor'>".
				htmlentities($row["curp"])."</div>\n";
	$response.= "	</div>\n"; 
	//Telefono
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Tel&eacute;fono: </div><div class='con_valor'>".
				htmlentities($row["tel"])."</div>\n";
	$response.= "	</div>\n"; 
	//Extension
	$response.= "	<div class='con_linea'>\n";			
	$response.= "		<div class='con_eti'> Extensi&oacute;n: </div><div class='con_valor'>".
				htmlentities($row["extension"])."</div>\n";
	$response.= "	</div>\n"; 
	//Archivo de alta
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Archivo de alta: </div><div class='con_valor'>";
	if ($row["archivo_alta"] == NULL || $row["archivo_alta"] == ""){
		$response .= "No cargado";
	}
	else {
		$response .= "<a href='./archivos/".$row["archivo_alta"]."' target='_blank'> Ver archivo </a>";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Finiquitado
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Finiquitado: </div><div class='con_valor'>";
	if ($row["finiquitado"] == 1){
		$response .= "S&iacute;";
	}
	else {
		$response .= "No";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Archivo de finiquito
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Archivo Finiquito: </div><div class='con_valor'>";
	if ($row["finiquitado"] == 1){		
		if ($row["archivo_finiquito"] == NULL || $row["archivo_finiquito"] == ""){
			$response .= "No cargado";
		}
		else {
			$response .= "<a href='./archivos/".$row["archivo_finiquito"]."' target='_blank'> Ver archivo </a>";
		}
	}
	else {
		$response .= "No aplica";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Fecha de finiquito
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Fecha de finiquito: </div><div class='con_valor'>";
	if ($row["finiquitado"] == 1){
		$arr = explode('-', $row["fecha_finiquito"]);
		$fecha = $arr[2].'/'.$arr[1].'/'.$arr[0];		
		$response.= $fecha;
	}
	else {
		$response .= "No aplica";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	//Monto de finiquito
	$response.= "	<div class='con_linea'>\n";	
	$response.= "		<div class='con_eti'> Monto de Finiquito: </div><div class='con_valor'>";
	if ($row["finiquitado"] == 1){		
		$response.= "$ ".$row["monto_finiquito"];
	}
	else {
		$response .= "No aplica";
	}
	$response.= "		</div>\n";
	$response.= "	</div>\n";
	
	
	$response.= "</div>";	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>