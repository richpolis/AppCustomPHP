$(document).ready(function(){
	$('#datos').hide(); //esconder los campos para insertar y modificar
	
	$('#insertar').click(function() {
		$('input[name=descripcion]').val("");
		$('input[name=privado]').attr('checked', false);
		$(":checkbox").uniform();
		$('#archivo_div').html("<input type='file' id='archivo' name='archivo' value='' />");
		$(":file").uniform();
		$('input[name=accion]').val("insertar");
		$('#archivo_eliminar').hide();
			
		$('#label_im').html("Insertar un Formato");
		$('#consulta').hide();
		$('#datos').show();	
		return false;	  
	});
	
	$('#cancelar').click(function() { 	
		$('#datos').hide();
		$('#consulta').show();	
		return false;	  
	});
	
	$('#modinsertar')
	   .validate({
         submitHandler: function(form) {			 
			 if ($('input[name=accion]').val() == "modificar"){
				 ajaxFileUpload("formato", "modificar", "archivo", $('input[name=id_formato]').val()); 
			 }
			 else if ($('input[name=accion]').val() == "insertar"){
				 ajaxFileUpload("formato", "subir", "archivo", ""); 
			 }			           				
         }
	});
	
	Buscar(); //Busca y muestra todas los formatos
});

//Devuelve tabla con todos los formatos
function Buscar() {        	 

	$.ajax({
		url: "buscarFormatos.php",                    
		cache: false,            
		success: function (html) {   				        
			$('#tabla').html(html);			        
		}      
	});

	return false;
}

//inserta o modifica un registro de un formato
function insertarModificar(id, arch) {
	var idr = id;
	var descripcion = encodeURIComponent($('input[name=descripcion]').val());
	var privado;
	if ($('input[name=privado]').is(':checked')) {
		privado = "1";
	}
	else {
		privado = "0";
	}
	
	var accion = $('input[name=accion]').val();	
	
	var archivo = arch;
	
	var action = "insertarModificarFormatos.php";

	var data = 'id=' + idr + '&descripcion=' + descripcion + '&archivo=' + archivo
	+ '&accion=' + accion + '&privado=' + privado;

	$.ajax({
		url: action,      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) {
			jQuery('#datos').hideLoading();           
			if (html.trim() == "success") {						
				$('#datos').hide();
				$('#consulta').show();
				Buscar();
				if (accion == "insertar") {
					apprise("Se ha insertado el registro correctamente.");	
				} else {
					apprise("Se ha modificado el registro correctamente.");	
				}							
			}
			else {
				apprise(html);
			}
		}      
	});	
}

//Sube primero el archivo y luego llama los procedimientos de insertar o modificar
function ajaxFileUpload(tipo, accion, id, idr){
	
	arch = encodeURIComponent($('#archivo').val().replace(/^.*[\\\/]/, ''));
	
	jQuery('#datos').showLoading();
	if (arch == "" && accion == "modificar") {
		insertarModificar(encodeURIComponent(idr), "");
		return false;
	}
	
	if ($('#archivo').val().trim() == "" && accion == "subir") {
		apprise("Debe elegir un archivo para el formato. No se pudo guardar el registro.");
		jQuery('#datos').hideLoading();
		return false;
	}
	
	$.ajaxFileUpload({
			url:'doajaxfileupload.php',
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr },
			success: function (data, status){
				if(typeof(data.error) != 'undefined'){
					if(data.error != ''){
						apprise(data.error);
						jQuery('#datos').hideLoading();
					}else{
						insertarModificar(encodeURIComponent(idr), arch);
						//alert(data.msg);
					}
				}
				/*if(typeof(data.error) != 'undefined'){
					insertarModificar(idr);					
				}
				else {
					alert(data.msg + data.error);
				}*/
			},
			error: function (data, status, e){
				apprise(e);
				jQuery('#datos').hideLoading();
			}
		}
	)	
	return false;
}

//Se llama al hacer click en el boton de eliminar de un formato
function eliminarFormato(id) {
	var data = 'id=' + id;
	 
	apprise('¿Seguro que desea eliminar permanentemente el formato?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el formato'}, 
		function(r){
    		if(r){
				jQuery('#consulta').showLoading();
				$.ajax({
					url: 'eliminarFormatos.php',      
					type: "GET",       
					data: data,            
					cache: false,            
					//success
					success: function (html) { 
						jQuery('#consulta').hideLoading(); 
						Buscar();
						//apprise(html);
						apprise("Se ha eliminado el registro con &eacute;xito.");	
					},  
					error: function (data, status, e)
					{
						jQuery('#consulta').hideLoading(); 
						apprise(e);
					}    
				});
			}
			else {
				return false;
			}
		});
		
	return false;
}

//Se llama al hacer click en el boton de modificar de un formato
function iniModificar(id) {
	var data = 'id=' + id;
	
	$.ajax({
		url: 'consultarFormatos.php',
		type: "GET",
		data: data,  
		dataType: 'json',             
		success: function (html) {	
			$('input[name=descripcion]').val(html.descripcion);
			if (html.privado == "0") {
				$('input[name=privado]').attr('checked', false);
			}
			else{
				$('input[name=privado]').attr('checked', true);
			}
			$(":checkbox").uniform();
			
			$('#archivo_div').html("<input type='file' id='archivo' name='archivo' value='' />");
			$(":file").uniform();
			
			if (html.archivo == "") {
				$('#archivo_eliminar').hide();
			} else {
				$('#archivo_actual').html("<a href='../formatos/" + html.archivo + "' target='_blank'> " + html.archivo + "</a>");
				$('#archivo_eliminar').show();	
			}
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_formato]').val(id);
			
			$('#label_im').html("Modificar un Formato");
			$('#consulta').hide();
			$('#datos').show();	
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}
