<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$query = "SELECT * FROM localidades_inmuebles ORDER BY nombre ASC;";

$result = $miconexion->consulta($query);
	
if (mysql_num_rows($result)!=0) {

	//Generar codigo de las tablas
	$response = "<table id='report' width='80%' style='margin: 0 auto;'>\n";
	$response .= "	<tr>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th style='width: 20px; padding: 0;'></th>\n".
				"		<th>Nombre</th>\n".
				"	</tr>\n";
	$c = 0;
	while($row = mysql_fetch_array($result)) {
		if ($c % 2 == 0)
			$class="filapar";
		else
			$class="filaimpar";			
		$c++;
		$response .= "	<tr id='".$row["id_localidad"]."'>\n";
		$response .= "		<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return iniModificar(".$row["id_localidad"].
						");' title='Modificar registro de la localidad'><img src='images/form_edit.png' /></a>";
		}		
		$response .= "</td>";
		
		$response .= "<td class='$class'>";
		if ($_SESSION['nivel'] == 0) {
			$response .= "<a href='#' onclick='return eliminarLocalidad(".$row["id_localidad"].
						")' title='Eliminar registro de la localidad'><img src='images/sign_remove.png' /></a>";
		}					
		$response .= "		</td>\n".
					"		<td class='$class'>\n".
					"		".htmlentities($row["nombre"])."\n".
					"		</td>\n".					
					"	</tr>\n";					
	}
				
				
	$response .= "</table>\n";
	
	echo $response;
}
else {
	echo "<h1 style='text-align: center;'>".
		" <br />No se encontr&oacute; ning&uacute;n registro de localidades.".
		"</h1>\n";
}
$miconexion->desconectar();
exit();

?>