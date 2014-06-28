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
	$query = "SELECT * FROM prestamos WHERE id_empleado = $id AND id_prestamo = $idf";
	$result = $miconexion->consulta($query);
	$row = mysql_fetch_array($result);

	$arr = explode('-', $row["fecha_solicitud"]);
	$fecha_solicitud = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	$arr = explode('-', $row["fecha_fin"]);
	$fecha_fin = $arr[2].'/'.$arr[1].'/'.$arr[0];
	
	if ($row["archivo"] == NULL)
		$archivo = "";
	else
		$archivo = $row["archivo"];
	
	$query2 = "SELECT * FROM empleados WHERE id_empleado = $id";
	$result2 = $miconexion->consulta($query2);
	$row2 = mysql_fetch_array($result2);

	//return in JSON format
	
	$json = "{";
	$json .= "\"fecha_solicitud\": \"".$fecha_solicitud."\",\n";
	$json .= "\"fecha_fin\": \"".$fecha_fin."\",\n";
	$json .= "\"monto\": \"".htmlentities($row["monto"])."\",\n";
	$json .= "\"nombre\": \"".htmlentities($row2["nombre"]).
				" ".htmlentities($row2["apellido_paterno"])." ".htmlentities($row2["apellido_materno"])."\",\n";
	$json .= "\"estado\": \"".$row["estado"]."\",\n";
	$json .= "\"archivo\": \"".$archivo."\"\n";
	$json .= "}";
		
	//echo $json;
	echo $json;
}
else{ /*** ES PARA MOSTRAR LOS DATOS DE LOS PRESTAMOS DEL EMPLEADO  ********/
	$query = "SELECT * FROM prestamos WHERE id_empleado = $id ORDER BY fecha_solicitud DESC;";
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
			$arr = explode('-', $row["fecha_solicitud"]);
			$fecha_solicitud = $arr[2].'/'.$arr[1].'/'.$arr[0];
			$response.= "	<div class='con_linea'>\n";			
			$response.= "		<div class='con_eti' style='width: 30%;'>";
			if ($_SESSION['nivel'] == 0) {
				$response.= "<div style='float: left;'><a style='float: left;' href='#' onclick='return iniModificar("
						.$row["id_empleado"].", ".$row["id_prestamo"].");' title='Modificar Pr&eacute;stamo'><img src='images/form_edit.png' /></a>".
						"<a style='padding-left: 10px; float: right;' href='#' onclick='return eliminarPrestamos(".$row["id_empleado"].", "
						.$row["id_prestamo"].");' title='Eliminar Pr&eacute;stamo'><img src='images/sign_remove.png' /></a></div>";
			}
						
			$response.= "Fecha de solicitud: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>".$fecha_solicitud."</div>\n";
			//Fecha de regreso
			$arr = explode('-', $row["fecha_fin"]);
			$fecha_fin = $arr[2].'/'.$arr[1].'/'.$arr[0];			
			$response.= "		<div class='con_eti' style='width: 30%;'><div style='float: left;'>".
						"</div>Fecha de fin: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>".$fecha_fin."</div>\n";
			$response.= "	</div>\n";
			
			//Monto y Estado
			$response.= "	<div class='con_linea'>\n";
			$response.= "		<div class='con_eti' style='width: 30%;'>Monto: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>$".htmlentities($row["monto"])."</div>\n";
			$response.= "		<div class='con_eti' style='width: 30%;'>Estado: </div>".
						"<div class='con_valor' style='width: 10%; float: left;'>";
			if ($row["estado"] == 0)
				$response.=  "Activo";
			else if ($row["estado"] == 1)
				$response.= "Pagado";
			$response.= "</div>\n";
			$response.= "	</div>\n";
		
			//Archivo			
			$response.= "	<div class='con_linea'>\n";	
			$response.= "		<div class='con_eti'>";
		
			if ($row["archivo"] != NULL && $row["archivo"] != ""){
				$response .= "<a href='./archivos/".$row["archivo"]."' target='_blank'> Ver archivo </a>";
			}

			$response.= "		</div>\n";
			$response.= "	</div>\n";
		}
	}
	else{
		$response.= "	<h2>No hay ning&uacute;n registro de pr&eacute;stamos para este(a) empleado(a).</h2>\n";
	}
	
	
	
	
	$response .= "</td>\n";
	
	echo $response;
}

$miconexion->desconectar();
exit();

?>