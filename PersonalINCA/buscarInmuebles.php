<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$query = "SELECT * FROM inmuebles ORDER BY id_localidad ASC, ubicacion ASC;";

$result = $miconexion->consulta($query);
	
if (mysql_num_rows($result)!=0) {

	//Generar codigo de las tablas
	$response = "<table id='report' width='100%' style='margin: 0 auto;'>\n";
	$response .= "	<tr>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th>Localidad</th>\n".
				"		<th>Ubicaci&oacute;n</th>\n".
				"		<th>Tipo</th>\n".
				"		<th>Renta</th>\n".
				"		<th style='width: 40px;'>No. de Empleados</th>\n".
				"	</tr>\n";
	$c = 0;
	while($row = mysql_fetch_array($result)) {
		if ($c % 2 == 0)
			$class="filapar";
		else
			$class="filaimpar";			
		$c++;
		$response .= "	<tr id='".$row["id_inmueble"]."'>\n";
		$response .= "		<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return iniModificar(".$row["id_inmueble"].
						");' title='Modificar registro del inmueble'><img src='images/form_edit.png' /></a>";
		}		
		$response .= "</td>";
		
		$response .= "<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return eliminarInmueble(".$row["id_inmueble"].
						")' title='Eliminar registro del inmueble'><img src='images/sign_remove.png' /></a>";
		}					
		$response .= "		</td>\n";
		
		$response .= "<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return iniAsignacion(".$row["id_inmueble"].
						")' title='Asignaci&oacute;n de Empleados'><img src='images/page_edit.png' /></a>";
		}					
		$response .= "		</td>\n";
		
		//LOCALIDAD
		$response .= "		<td class='$class'>\n";				
		if ($row["id_localidad"] == NULL) {
			$response .= "		Ninguna\n";
		}
		else {
			$result2 = $miconexion->consulta("SELECT * FROM localidades_inmuebles WHERE id_localidad = ".$row["id_localidad"].";");
			$row2 = mysql_fetch_array($result2);
			$response .= "		".htmlentities($row2["nombre"])."\n";
		}		
		$response .= "		</td>\n";
		
		//UBICACION
		$ubicacion = str_replace(array("\r\n", "\n", "\r"), '<br />', htmlentities($row["ubicacion"]));
		$response .= "		<td class='$class'>\n";				
		$response .= "		".$ubicacion."\n";
		$response .= "		</td>\n";
		
		//TIPO
		$response .= "		<td class='$class'>\n";				
		if ($row["tipo"] == 0)
			$response .= "		Oficina\n";
		else if ($row["tipo"] == 1)
			$response .= "		Campamento\n";
		else if ($row["tipo"] == 2)
			$response .= "		Campamento/Oficina\n";			
		$response .= "		</td>\n";
		
		//RENTA
		$response .= "		<td class='$class'>\n$";				
		$response .= "		".$row["renta"]."\n";
		$response .= "		</td>\n";
		
		//NO. DE EMPLEADOS
		$response .= "		<td class='$class'>\n";
		$result_noemp = $miconexion->consulta("SELECT COUNT(id_inmueble) AS no FROM inmuebles_foraneidad ".
										"WHERE id_inmueble = ".$row["id_inmueble"].";");
		$row_noemp = mysql_fetch_array($result_noemp);
		$response .="		".htmlentities($row_noemp["no"])."\n";
		$response .= "		</td>\n";
		

		$response .= "	</tr>\n";					
	}
				
				
	$response .= "</table>\n";
	
	echo $response;
}
else {
	echo "<h1 style='text-align: center;'>".
		" <br />No se encontr&oacute; ning&uacute;n registro de inmuebles.".
		"</h1>\n";
}
$miconexion->desconectar();
exit();

?>