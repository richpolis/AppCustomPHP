$(document).ready(function(){
	$('#datos').hide(); //esconder los campos para insertar y modificar
	
	$('#insertar').click(function() {
		$('input[name=nombre]').val("");
		$('#organigrama_div').html("<input type='file' id='organigrama' name='organigrama' value='' />");
		$(":file").uniform();
		$('input[name=accion]').val("insertar");
		$('#organigrama_eliminar').hide();
			
		$('#label_im').html("Insertar una Obra");
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
				 ajaxFileUpload("obra", "modificar", "organigrama", $('input[name=id_obra]').val()); 
			 }
			 else if ($('input[name=accion]').val() == "insertar"){
				 ajaxFileUpload("obra", "subir", "organigrama", ""); 
			 }			           				
         }
	});
	
	Buscar(); //Busca y muestra todas las obras
});

//Devuelve tabla con todas las obras
function Buscar() {        	 

	$.ajax({
		url: "buscarObras.php",                    
		cache: false,            
		success: function (html) {   				        
			$('#tabla').html(html);			        
		}      
	});

	return false;
}

//inserta o modifica un registro de una obra
function insertarModificar(id, arch) {
	
	var idr = id;
	var eliminar_organigrama;
	var nombre = encodeURIComponent($('input[name=nombre]').val());
	//var organigrama = encodeURIComponent($('input[name=organigrama]').val());		
	var accion = $('input[name=accion]').val();
	
	if ($('input[name=eliminar_organigrama]').is(':checked')) {
		arch = "";
		eliminar_organigrama = "1";		
	}
	else {
		eliminar_organigrama = "0";
	}
	
	var action = "insertarModificarObras.php";

	var data = 'id=' + idr + '&nombre=' + nombre + '&organigrama=' + arch
	+ '&accion=' + accion + '&eliminar_organigrama=' + eliminar_organigrama;
	
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
	arch = encodeURIComponent($('#organigrama').val().replace(/^.*[\\\/]/, ''));

	jQuery('#datos').showLoading();
	if (arch == "" && !$('input[name=eliminar_organigrama]').is(':checked')) {
		insertarModificar(idr, arch);
		return false;	
	}

	if ($('input[name=eliminar_organigrama]').is(':checked')) {
		accion = "borrar";	
	}
	
	$.ajaxFileUpload({
			url:'doajaxfileupload.php', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr },
			success: function (data, status){
				if(typeof(data.error) != 'undefined'){
					insertarModificar(idr, arch);					
				}
				else {
					//alert(data.msg + data.error);
				}
			},
			error: function (data, status, e){
				apprise(e);
			}
		}
	)	
	return false;
}

//Se llama al hacer click en el boton de eliminar de una obra
function eliminarObra(id) {
	var data = 'id=' + id;
	 
	apprise('Se eliminar&aacute; permanentemente el registro y todos los dem&aacute;s<br />' 
			+ 'registros y archivos referenciando a esta quedar&aacute;n con valores nulos. <br /><br />'
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#consulta').showLoading();
				$.ajax({
					url: 'eliminarObras.php',      
					type: "GET",       
					data: data,            
					cache: false,            
					//success
					success: function (html) { 
						jQuery('#consulta').hideLoading(); 
						Buscar();
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

//Se llama al hacer click en el boton de modificar de una obra
function iniModificar(id) {
	var data = 'id=' + id;

	$.ajax({
		url: 'consultarObras.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		success: function (html) { 			
			$('input[name=nombre]').val(html.nombre);			
			$('input[name=eliminar_organigrama]').attr('checked', false);
			$('#organigrama_div').html("<input type='file' id='organigrama' name='organigrama' value='' />");
			$(":file").uniform();
			
			if (html.organigrama == "") {
				$('#organigrama_eliminar').hide();
			} else {
				$('#organigrama_actual').html("<a href='./archivos/" + html.organigrama + "' target='_blank'> Ver archivo</a>");
				$('#organigrama_eliminar').show();	
			}
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_obra]').val(id);
			
			$('#label_im').html("Modificar una Obra");
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
