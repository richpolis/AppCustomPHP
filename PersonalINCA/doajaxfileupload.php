<?php
	include ("../Acceso.php");
	/*if($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
		exit();
	}*/

	$error = "";
	$msg = "";
	//$fileElementName = 'fileToUpload';	
	$fileElementName = $_REQUEST["id"];
	$idempleado = $_REQUEST["idr"];
	$tipo = $_REQUEST["tipo"];
	$accion = $_REQUEST["accion"];
	
	if($tipo == "prestamo" || $tipo == "falta") {
		$idp = $_REQUEST["idp"];
	}
	
	if($tipo == "formato") {
		if(empty($_FILES[$fileElementName]['error'])){			
			if($accion == "modificar") {
				$result = $miconexion->consulta("SELECT * FROM formatos WHERE id_formato <> '$idempleado' AND id_formato = '".
												$_FILES[$fileElementName]['name']."';");
				if (mysql_num_rows($result)!=0) {
					echo "{";
					echo				"error: 'Ya existe un archivo con ese nombre. El archivo no se pudo subir.',\n";
					echo				"msg: '" . $msg . "'\n";
					echo "}";
					exit();
				}
			}
			else if($accion == "subir") {
				$result = $miconexion->consulta("SELECT * FROM formatos WHERE id_formato = '".$_FILES[$fileElementName]['name']."';");
				if (mysql_num_rows($result)!=0) {
					echo "{";
					echo				"error: 'Ya existe un archivo con ese nombre. El archivo no se pudo subir.',\n";
					echo				"msg: '" . $msg . "'\n";
					echo "}";
					exit();
				}
			}			
		}
	}
	
	if(!empty($_FILES[$fileElementName]['error']))
	{
		if($accion == "borrar") {
			if($tipo == "empleado") {					
				$result = $miconexion->consulta("SELECT * FROM empleados WHERE id_empleado = $idempleado;");
				$row = mysql_fetch_array($result);
				@unlink("./archivos/".$row["archivo_alta"]);
			} else if($tipo == "finiquito") {
				$result = $miconexion->consulta("SELECT archivo_finiquito FROM empleados".
									" WHERE id_empleado = $idempleado;");
				$row = mysql_fetch_array($result);
				@unlink("./archivos/".$row["archivo_finiquito"]);
			} else if($tipo == "obra") {
				$result = $miconexion->consulta("SELECT organigrama FROM obras".
									" WHERE id_obra = $idempleado;");
				$row = mysql_fetch_array($result);
				@unlink("./archivos/".$row["organigrama"]);
			} else if($tipo == "recibo1") {
				if ($accion == "borrar" ) {
					$result = $miconexion->consulta("SELECT * FROM empleados".
										" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["ultimo_recibo"]);
				}
			} else if($tipo == "recibo2") {
				if ($accion == "borrar") {
					$result = $miconexion->consulta("SELECT * FROM empleados".
										" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["penultimo_recibo"]);
				}				
			} else if($tipo == "prestamo") {
				if ($accion == "borrar") {
					$result = $miconexion->consulta("SELECT * FROM prestamos".
										" WHERE id_empleado = $idempleado AND id_prestamo = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
				}				
			} else if($tipo == "falta") {
				if ($accion == "borrar") {
					$result = $miconexion->consulta("SELECT * FROM archivos_faltas".
										" WHERE id_empleado = $idempleado AND id_archivo_faltas = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
				}				
			} else if($tipo == "foraneidad1") {
				if ($accion == "borrar" ) {
					$result = $miconexion->consulta("SELECT * FROM empleados".
										" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_alta_foraneidad"]);
				}
			} else if($tipo == "foraneidad2") {
				if ($accion == "borrar") {
					$result = $miconexion->consulta("SELECT * FROM empleados".
										" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_baja_foraneidad"]);
				}				
			}
		}
		else{
			switch($_FILES[$fileElementName]['error'])
			{
	
				case '1':
					$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
					break;
				case '2':
					$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
					break;
				case '3':
					$error = 'The uploaded file was only partially uploaded';
					break;
				case '4':
					$error = 'No file was uploaded.';				
					break;
	
				case '6':
					$error = 'Missing a temporary folder';
					break;
				case '7':
					$error = 'Failed to write file to disk';
					break;
				case '8':
					$error = 'File upload stopped by extension';
					break;
				case '999':
				default:
					$error = 'No error code avaiable';
			}
		}
	}elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
	{
			$error = 'No file was uploaded..';
	}else 
	{		
			$msg .= " File Name: " . $_FILES[$fileElementName]['name'] . ", ";
			$msg .= " File Size: " . @filesize($_FILES[$fileElementName]['tmp_name']);
			//for security reason, we force to remove all uploaded file
			$ext = strrchr($_FILES[$fileElementName]['name'], ".");
			/*****EMPLEADOS ******/
			if($tipo == "empleado") {
				if($accion == "subir") {
					$result = $miconexion->consulta("SELECT MAX(id_empleado) from empleados");
					$row = mysql_fetch_array($result);
					$idempleado = $row[0]+1;
					$nombre = "alta_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], "./archivos/".$nombre);
				}
				else if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo_alta FROM empleados WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_alta"]);
					$nombre = "alta_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
				"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo_alta FROM empleados WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_alta"]);
				}
			}		
			/***** FINIQUITO *******/	
			else if($tipo == "finiquito") {
				if($accion == "subir") {
					$nombre = "finiquito_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo_finiquito FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_finiquito"]);
					$nombre = "finiquito_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo_finiquito FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_finiquito"]);
				}
			} 
			/***** RECIBOS ******/
			else if($tipo == "recibo1") {				
				if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT ultimo_recibo FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["ultimo_recibo"]);
					$nombre = "ultimo_recibo_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT ultimo_recibo FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["ultimo_recibo"]);
				}
			} else if($tipo == "recibo2") {
				if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT penultimo_recibo FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["penultimo_recibo"]);
					$nombre = "penultimo_recibo_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT penultimo_recibo FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["penultimo_recibo"]);
				}
			}
			/***** FORANEIDADES ******/
			else if($tipo == "foraneidad1") {				
				if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo_alta_foraneidad FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_alta_foraneidad"]);
					$nombre = "alta_foraneidad_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo_alta_foraneidad FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_alta_foraneidad"]);
				}
			} else if($tipo == "foraneidad2") {
				if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo_baja_foraneidad FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_baja_foraneidad"]);
					$nombre = "baja_foraneidad_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo_baja_foraneidad FROM empleados".
									" WHERE id_empleado = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo_baja_foraneidad"]);
				}
			}
			/***** PRESTAMOS *******/	
			else if($tipo == "prestamo") {
				if($accion == "subir") {
					$result = $miconexion->consulta("SELECT MAX(id_prestamo) from prestamos WHERE id_empleado = $idempleado");
					$row = mysql_fetch_array($result);
					$idp = $row[0]+1;
					$nombre = "prestamo_".$idp."_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo FROM prestamos".
									" WHERE id_empleado = $idempleado AND id_prestamo = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
					$nombre = "prestamo_".$idp."_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo FROM prestamos".
									" WHERE id_empleado = $idempleado AND id_prestamo = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
				}
			}
			/***** ARCHIVOS FALTAS *******/	
			else if($tipo == "falta") {
				if($accion == "subir") {
					$result = $miconexion->consulta("SELECT MAX(id_archivo_faltas) from archivos_faltas WHERE id_empleado = $idempleado");
					$row = mysql_fetch_array($result);
					$idp = $row[0]+1;
					$nombre = "archivo_faltas_".$idp."_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT archivo FROM archivos_faltas".
									" WHERE id_empleado = $idempleado AND id_archivo_faltas = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
					$nombre = "archivo_faltas_".$idp."_empleado_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
										"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT archivo FROM archivos_faltas".
									" WHERE id_empleado = $idempleado AND id_archivo_faltas = $idp;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["archivo"]);
				}
			}
			/***** FORMATOS *******/	
			else if($tipo == "formato") {
				if($accion == "subir") {
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'],
										"../formatos/".utf8_decode($_FILES[$fileElementName]['name']));
				}
				else if($accion == "modificar") {
					@unlink("../formatos/".utf8_decode($idempleado));
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'],
										"../formatos/".utf8_decode($_FILES[$fileElementName]['name']));
				}
			}
			/*****OBRAS ******/
			if($tipo == "obra") {
				if($accion == "subir") {
					$result = $miconexion->consulta("SELECT MAX(id_obra) from obras");
					$row = mysql_fetch_array($result);
					$idempleado = $row[0]+1;
					$nombre = "organigrama_obra_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], "./archivos/".$nombre);
				}
				else if($accion == "modificar") {
					$result = $miconexion->consulta("SELECT organigrama FROM obras WHERE id_obra = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["organigrama"]);
					$nombre = "organigrama_obra_".$idempleado.$ext;
					move_uploaded_file($_FILES[$fileElementName]['tmp_name'], 
				"./archivos/".$nombre);
				}
				else if($accion == "borrar") {					
					$result = $miconexion->consulta("SELECT organigrama FROM obras WHERE id_obra = $idempleado;");
					$row = mysql_fetch_array($result);
					@unlink("./archivos/".$row["organigrama"]);
				}
			}
				
			$miconexion->desconectar();
			//@unlink($_FILES[$fileElementName]);		
	}		
	echo "{";
	echo				"error: '" . $error . "',\n";
	echo				"msg: '" . $msg . "'\n";
	echo "}";
?>