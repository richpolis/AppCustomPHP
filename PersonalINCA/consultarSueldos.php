<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];
if (isset($_REQUEST['idmod']))
	$idmod = $_REQUEST['idmod'];
if (isset($_REQUEST['tipo']))
	$tipo = $_REQUEST['tipo'];

if (isset($_REQUEST["class"]))
	$class = $_REQUEST['class'];



if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/

	if ($tipo == "normal") {
		$query = "SELECT * FROM mod_sueldos WHERE id_empleado = $id AND id_mod_sueldo = $idmod";
	}
	else {
		$query = "SELECT * FROM mod_sueldos_aumento WHERE id_empleado = $id AND id_mod_sueldo_aumento = $idmod";
	}	
	
	$result = $miconexion->consulta($query);
	
	$row = mysql_fetch_array($result);

	$arr = explode('-', $row["fecha"]);
	$fecha = $arr[2].'/'.$arr[1].'/'.$arr[0];

	$query = "SELECT * FROM empleados WHERE id_empleado = $id";
	$result = $miconexion->consulta($query);
	$row = mysql_fetch_array($result);
	
	$json = "{";
	$json .= "\"fecha\": \"".$fecha."\",\n";
	$json .= "\"nuevo_sueldo\": \"".$row["sueldo_bruto_mensual"]."\",\n";
	$json .= "\"nuevo_porcentaje\": \"".$row["porcentaje_imss"]."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
} 
else{ /*** ES PARA MOSTRAR LOS DATOS DEL EMPLEADO SOLAMENTE  ********/
	$query = "SELECT * FROM mod_sueldos WHERE id_empleado = $id ORDER BY fecha ASC";	
	$result1 = $miconexion->consulta($query);	
	
	$query = "SELECT * FROM mod_sueldos_aumento WHERE id_empleado = $id ORDER BY fecha ASC";	
	$result2 = $miconexion->consulta($query);

	$response = "<td class='$class' colspan='7'>\n";
	$response.= "<div class='con_col'>\n";
	//MODIFICACIONES A SUELDO
	$response.= "	<div class='con_linea' style='padding: 0; margin: 0;'>\n";
	$response.= "		<h2 style='padding: 0; margin: 0;'>Modificaciones a Sueldo: </h2>\n";
	$response.= "	</div>\n";
	if (mysql_num_rows($result1)!=0) {
		//Lista de modificaciones a sueldo
		while($row = mysql_fetch_array($result1)) {
			//Fecha
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti'> Fecha: </div><div class='con_valor'>".htmlentities($row["fecha"])."</div>\n";
			$response.= "	</div>\n";
			//Cantidad anterior
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti'> Cantidad Anterior: </div><div class='con_valor'>$".htmlentities($row["cantidad_anterior"])."</div>\n";
			$response.= "	</div>\n";
			//Porcentaje anterior
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti'> Porcentaje IMSS Anterior: </div><div class='con_valor'>".htmlentities($row["porcentaje_anterior"]).
						"%</div>\n";
			$response.= "	</div>\n";
			
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<hr style='width: 90%;'/>\n";
			$response.= "	</div>\n";
		}
		$query = "SELECT * FROM mod_sueldos WHERE id_empleado = $id ORDER BY fecha DESC, id_mod_sueldo DESC;";	
		$result1 = $miconexion->consulta($query);
		$row = mysql_fetch_array($result1);
		if ($_SESSION['nivel'] == 0) {
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<a href='#' onclick='return iniModificar($id, ".$row["id_mod_sueldo"].
								", \"normal\");'>Editar &uacute;ltima modificaci&oacute;n</a><br />\n";
			$response.= "		<a href='#' onclick='return eliminarModificacion($id, ".$row["id_mod_sueldo"].
								", \"normal\");'>Eliminar &uacute;ltima modificaci&oacute;n</a><br />\n";
			$response.= "	</div>\n";
		}
	} else {
		$response.= "	<div class='con_linea'>\n";
		$response.= "		No se ha hecho ninguna modificaci&oacute;n\n";
		$response.= "	</div>\n";
	}
	
	$response.= "</div>\n";
	$response.= "<div class='con_col'>\n";
	  
	//MODIFICACIONES A SUELDO POR AUMENTO
	$response.= "	<div class='con_linea' style='padding: 0; margin: 0;'>\n";
	$response.= "		<h2 style='padding: 0; margin: 0;'>Modificaciones a Sueldo por Aumento: </h2>\n";
	$response.= "	</div>\n";
	
	if (mysql_num_rows($result2)!=0) {
		//Lista d emodificaciones a sueldo por aumento
		while($row = mysql_fetch_array($result2)) {
			//Fecha
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti'> Fecha: </div><div class='con_valor'>".htmlentities($row["fecha"])."</div>\n";
			$response.= "	</div>\n";
			//Cantidad anterior
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti'> Cantidad Anterior: </div><div class='con_valor'>$".htmlentities($row["cantidad_anterior"])."</div>\n";
			$response.= "	</div>\n";			
			
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<hr style='width: 90%;' />\n";
			$response.= "	</div>\n";
		}
		$query = "SELECT * FROM mod_sueldos_aumento WHERE id_empleado = $id ORDER BY fecha DESC, id_mod_sueldo_aumento DESC;";	
		$result2 = $miconexion->consulta($query);
		$row = mysql_fetch_array($result2);
		if ($_SESSION['nivel'] == 0) {
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<a href='#' onclick='return iniModificar($id, ".$row["id_mod_sueldo_aumento"].
								", \"aumento\");'>Editar &uacute;ltima modificaci&oacute;n</a><br />\n";
			$response.= "		<a href='#' onclick='return eliminarModificacion($id, ".$row["id_mod_sueldo_aumento"].", \"aumento\");'>".
									"Eliminar &uacute;ltima modificaci&oacute;n</a><br />\n";
			$response.= "	</div>\n";
		}
	} else {
		$response.= "	<div class='con_linea'>\n";
		$response.= "		No se ha hecho ninguna modificaci&oacute;n\n";
		$response.= "	</div>\n";
	}
	
	$response.= "</div>";	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>