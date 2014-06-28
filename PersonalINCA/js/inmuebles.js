$(document).ready(function(){
	$('#asignacion').hide();
	$('#datos').hide(); //esconder los campos para insertar y modificar
	
	
	$('#insertar').click(function() {
		$('select[name=localidad]').val("-1");
		$('textarea[name=ubicacion]').val("");
		$('select[name=tipo]').val("0");
		$('input[name=renta]').val("");
		$('input[name=accion]').val("insertar");
		$.uniform.update("select");	
			
		$('#label_im').html("Insertar un Inmueble");
		$('#consulta').hide();
		$('#datos').show();	
		return false;	  
	});
	
	$('#cancelar').click(function() { 	
		$('#datos').hide();
		$('#consulta').show();	
		return false;	  
	});
	
	$('#regresar').click(function() { 	
		$('#asignacion').hide();
		$('#consulta').show();
		Buscar();	
		return false;	  
	});
	
	$('#modinsertar')
	   .validate({
         submitHandler: function(form) {
			 insertarModificar($('input[name=id_inmueble]').val());		           				
         }
	});
	
	Buscar(); //Busca y muestra todas las obras
});

//Devuelve tabla con todas los inmuebles
function Buscar() {        	 

	$.ajax({
		url: "buscarInmuebles.php",                    
		cache: false,            
		success: function (html) {   				        
			$('#tabla').html(html);			        
		}      
	});

	return false;
}

//inserta o modifica un registro de un inmueble
function insertarModificar(id) {
	
	var idr = id;
	var localidad = $('select[name=localidad]').val();
	var ubicacion = encodeURIComponent($('textarea[name=ubicacion]').val());
	var tipo = $('select[name=tipo]').val();
	var renta = $('input[name=renta]').val();
		
	var accion = $('input[name=accion]').val();
	
	var action = "insertarModificarInmuebles.php";

	var data = 'id=' + idr + '&localidad=' + localidad + '&ubicacion=' + ubicacion
	+ '&accion=' + accion + '&tipo=' + tipo + '&renta=' + renta;

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

//Se llama al hacer click en el boton de eliminar de un inmueble
function eliminarInmueble(id) {
	var data = 'id=' + id;
	 
	apprise('Se eliminar&aacute; permanentemente el registro y todos los dem&aacute;s<br />' 
			+ 'registros y archivos referenciando a este inmueble quedar&aacute;n con valores nulos. <br /><br />'
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#consulta').showLoading();
				$.ajax({
					url: 'eliminarInmuebles.php',      
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

//Se llama al hacer click en el boton de modificar de un inmueble
function iniModificar(id) {
	var data = 'id=' + id;

	$.ajax({
		url: 'consultarInmuebles.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		success: function (html) { 			
			$('select[name=localidad]').val(html.localidad);
			$('textarea[name=ubicacion]').val(html.ubicacion);	
			$('select[name=tipo]').val(html.tipo);
			$('input[name=renta]').val(html.renta);	
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_inmueble]').val(id);
			$.uniform.update("select");	
			
			$('#label_im').html("Modificar un Inmueble");
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

//Se llama al hacer click en el boton de asignacion de empleados
function iniAsignacion(id) {
	var data = 'id=' + id;
	$.ajax({
		url: 'consultarAsignacionEmpleados.php',      
		type: "GET",       
		data: data,            
		success: function (html) { 			
			$('#lista').html(html);
			$('input[name=id_inmueblea]').val(id);
			
			$('#label_ima').html("Asignaci&oacute;n de Empleados");
			$("#consulta").hide();
			$("#asignacion").show();
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}

//Se llama al hacer click en el boton de asignar un empleado
function addEmpleado() {
	var id = $('select[name=empleado]').val();
	var id_inmueble = $('input[name=id_inmueblea]').val();
	var data = 'id=' + id + '&id_inmueble=' + id_inmueble;
	
	$.ajax({
		url: 'asignarEmpleadosInmuebles.php',      
		type: "GET",       
		data: data,            
		success: function (html) {
			if (html.trim() == "success")
				iniAsignacion(id_inmueble);
			else
				apprise(html);			
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}

//Se llama al hacer click en el boton de asignar un empleado
function eliminar(id) {
	var id_inmueble = $('input[name=id_inmueblea]').val();
	var data = 'id=' + id + '&id_inmueble=' + id_inmueble + '&eliminar=true';
	
	$.ajax({
		url: 'asignarEmpleadosInmuebles.php',      
		type: "GET",       
		data: data,            
		success: function (html) {
			if (html.trim() == "success")
				iniAsignacion(id_inmueble);
			else
				apprise(html);			
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}


