<?php
session_start();
include ("../Acceso.php");
if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	exit();
}

$id = $_REQUEST['id'];

if (isset($_REQUEST["idf"]))
	$idf = $_REQUEST['idf'];

if (isset($_REQUEST["class"]))
	$class = $_REQUEST['class'];


if (isset($_REQUEST["modificar"])){ /*** ENVIAMOS LOS DATOS PARA MODIFICAR VIA JSON  ********/
	$query = "SELECT * FROM viaticos WHERE id_empleado = $id AND id_viatico = $idf";
	$result = $miconexion->consulta($query);
	$row = mysql_fetch_array($result);

	$arr = explode('-', $row["fecha_salida"]);
	$fecha_salida = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	$arr = explode('-', $row["fecha_regreso"]);
	$fecha_regreso = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	$query2 = "SELECT * FROM empleados WHERE id_empleado = $id";
	$result2 = $miconexion->consulta($query2);
	$row2 = mysql_fetch_array($result2);

	//return in JSON format
	$motivo = str_replace("\n", "\\n", $row["motivo"]);
	$motivo = str_replace("\r", "\\r", $motivo);
	$motivo = str_replace("\t", "\\t", $motivo);
	
	$json = "{";
	$json .= "\"fecha_salida\": \"".$fecha_salida."\",\n";
	$json .= "\"fecha_regreso\": \"".$fecha_regreso."\",\n";
	$json .= "\"monto\": \"".htmlentities($row["monto_autorizado"])."\",\n";
	$json .= "\"nombre\": \"".htmlentities($row2["nombre"]).
				" ".htmlentities($row2["apellido_paterno"])." ".htmlentities($row2["apellido_materno"])."\",\n";
	$json .= "\"motivo\": \"".utf8_encode($motivo)."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
}
else{ /*** ES PARA MOSTRAR LOS DATOS DE LOS VIATICOS DEL EMPLEADO  ********/
	$query = "SELECT * FROM viaticos WHERE id_empleado = $id ORDER BY fecha_salida DESC;";
	$result = $miconexion->consulta($query);
	
	$response = "<td class='$class' colspan='7'>\n";
	
	if (mysql_num_rows($result)!=0) {
		$c = true;
		while($row = mysql_fetch_array($result)) {
			if ($c == false){
				$response.= "	<div class='con_linea'><hr style='width: 98%; padding: 0; margin: 0;' /></div>\n";			
			}
			else 
				$c = false;
			//Fecha de salida
			$arr = explode('-', $row["fecha_salida"]);
			$fecha_salida = $arr[2].'/'.$arr[1].'/'.$arr[0];
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti' style='width: 30%;'>";
			if ($_SESSION['nivel'] == 0) {
				$response.= "<div style='float: left;'><a style='float: left;' href='#' onclick='return iniModificar("
						.$row["id_empleado"].", ".$row["id_viatico"].");' title='Modificar Vi&aacute;ticos'><img src='images/form_edit.png' /></a>".
						"<a style='padding-left: 10px; float: right;' href='#' onclick='return eliminarViaticos(".$row["id_empleado"].", ".$row["id_viatico"].
						");' title='Eliminar Vi&aacute;ticos'><img src='images/sign_remove.png' /></a></div>";
			}			
						
			$response.= "Fecha de salida: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>".$fecha_salida."</div>\n";
			//Fecha de regreso
			$arr = explode('-', $row["fecha_regreso"]);
			$fecha_regreso = $arr[2].'/'.$arr[1].'/'.$arr[0];			
			$response.= "		<div class='con_eti' style='width: 30%;'><div style='float: left;'>".
						"</div>Fecha de regreso: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>".$fecha_regreso."</div>\n";
			$response.= "	</div>\n";
			
			//Monto
			$response.= "	<div class='con_linea'>\n";
			$response.= "		<div class='con_eti' style='width: 30%;'><div style='float: left;'>".
						"</div>Monto Autorizado: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>$".htmlentities($row["monto_autorizado"])."</div>\n";
			$response.= "	</div>\n";
		
			//Motivo
			$domicilio = str_replace(array("\r\n", "\n", "\r"), '<br />', htmlentities($row["motivo"]));
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti' style='width: 20%;'> Motivo: </div><div class='con_valor' style='width: 70%; float: left;'>".
						$domicilio."</div>\n";
			$response.= "	</div>\n";
		}
	}
	else{
		$response.= "	<h2>No hay ning&uacute;n registro de vi&aacute;ticos para este(a) empleado(a).</h2>\n";
	}
	
	
	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>