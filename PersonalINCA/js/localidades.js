$(document).ready(function(){
	$('#datos').hide(); //esconder los campos para insertar y modificar
	
	$('#insertar').click(function() {
		$('input[name=nombre]').val("");
		$('input[name=accion]').val("insertar");
			
		$('#label_im').html("Insertar una Localidad");
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
			 insertarModificar($('input[name=id_localidad]').val());		           				
         }
	});
	
	Buscar(); //Busca y muestra todas las obras
});

//Devuelve tabla con todas las obras
function Buscar() {        	 

	$.ajax({
		url: "buscarLocalidades.php",                    
		cache: false,            
		success: function (html) {   				        
			$('#tabla').html(html);			        
		}      
	});

	return false;
}

//inserta o modifica un registro de una localidad
function insertarModificar(id) {
	
	var idr = id;
	var nombre = encodeURIComponent($('input[name=nombre]').val());		
	var accion = $('input[name=accion]').val();
	
	var action = "insertarModificarLocalidades.php";

	var data = 'id=' + idr + '&nombre=' + nombre
	+ '&accion=' + accion;

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

//Se llama al hacer click en el boton de eliminar de una localidad
function eliminarLocalidad(id) {
	var data = 'id=' + id;
	 
	apprise('Se eliminar&aacute; permanentemente el registro y todos los dem&aacute;s<br />' 
			+ 'registros y archivos referenciando a esta localidad quedar&aacute;n con valores nulos. <br /><br />'
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#consulta').showLoading();
				$.ajax({
					url: 'eliminarLocalidades.php',      
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

//Se llama al hacer click en el boton de modificar de una localidad
function iniModificar(id) {
	var data = 'id=' + id;

	$.ajax({
		url: 'consultarLocalidades.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		success: function (html) { 			
			$('input[name=nombre]').val(html.nombre);			
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_localidad]').val(id);
			
			$('#label_im').html("Modificar una Localidad");
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
