$(document).ready(function(){

	$('#datos').hide();
	
	$('#change-form')
	   .validate({
         submitHandler: function(form) {		 
		 	 if ($('input[name=accion]').val() == "modificar"){
				 ajaxFileUpload("prestamo", "modificar", "archivo", $('input[name=id_empleado]').val(), $('input[name=id_prestamo]').val()); 
			 }
			 else if ($('input[name=accion]').val() == "insertar"){
				 ajaxFileUpload("prestamo", "subir", "archivo", $('input[name=id_empleado]').val(), $('input[name=id_prestamo]').val()); 
			 }			 			           				
         }
        });
	
	//Mensajes en espaniol para la validacion de la forma
	jQuery.extend( jQuery.validator.messages, {
	  required: "Este campo es obligatorio.",
	  remote: "Por favor, rellena este campo.",
	  email: "Por favor, escribe una dirección de correo válida",
	  url: "Por favor, escribe una URL válida.",
	  date: "Por favor, escribe una fecha válida.",
	  dateISO: "Por favor, escribe una fecha (ISO) válida.",
	  number: "Por favor, escribe un número entero válido.",
	  digits: "Por favor, escribe sólo dígitos.",
	  creditcard: "Por favor, escribe un número de tarjeta válido.",
	  equalTo: "Por favor, escribe el mismo valor de nuevo.",
	  accept: "Por favor, escribe un valor con una extensión aceptada.",
	  maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
	  minlength: jQuery.validator.format("Por favor, no escribas menos de {0} caracteres."),
	  rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
	  range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
	  max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
	  min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")	  
	});
	
	//Inicializacion del DatePicker
	$.datepicker.setDefaults( $.datepicker.regional[""] );
	$("#fecha_solicitud").datepicker( $.datepicker.regional["es"] );
	$("#fecha_solicitud").datepicker( "option", "changeMonth", true);
	$("#fecha_solicitud").datepicker( "option", "changeYear", true);
	
	$("#fecha_fin").datepicker( $.datepicker.regional["es"] );
	$("#fecha_fin").datepicker( "option", "changeMonth", true);
	$("#fecha_fin").datepicker( "option", "changeYear", true);
	 
	$('#cancelar').click(function() { 	
		$('#datos').hide();
		$('#buscar').show();	
		return false;	  
	});
	 
	 //Funciones para la tabla de resultados
	$("#report tr:odd").addClass("odd");
	$("#report tr:not(.odd)").hide();
	$("#report tr:first-child").show();
	
	$("#report tr.odd").click(function(){
		$(this).next("tr").toggle();
		$(this).find(".arrow").toggleClass("up");
	});
	//$("#report").jExpand();	
	
	//para enviar la busqueda	
	//if submit button is clicked
    $('#doBuscar').click(function () {    
         
        //Get the data from all the fields
		var page = $('input[name=page]');
        var nombre = $('input[name=nombre]');
        var gerencia = $('select[name=gerencia]');
        var ubicacion = $('select[name=ubicacion]');
        var obra = $('select[name=obra]');
		var empresa = $('select[name=empresa]');
		var tipo = $('select[name=tipo]');	
		var finiquitado = $('select[name=finiquitado]');		
		$('input[name=nombre2]').val(nombre.val());		
        $('input[name=gerencia2]').val(gerencia.val());		
        $('input[name=ubicacion2]').val(ubicacion.val());
        $('input[name=obra2]').val(obra.val());
		$('input[name=empresa2]').val(empresa.val());
		$('input[name=tipo2]').val(tipo.val());
		$('input[name=finiquitado2]').val(finiquitado.val());

		page.val("");
		
        //organize the data properly
        var data = 'nombre=' + nombre.val() + '&gerencia=' + gerencia.val() + '&ubicacion='
        + ubicacion.val() + '&obra=' + obra.val() + '&empresa=' + empresa.val() + '&tipo='  + tipo.val()
		+ '&finiquitado=' + finiquitado.val();
         
        //start the ajax
        $.ajax({
            //this is the php file that processes the data and send mail
            url: "buscarPrestamos.php",      
            //GET method is used
            type: "GET",
            //pass the data        
            data: data,                
            //Do not cache the page
            cache: false,            
            //success
            success: function (html) {             
                $('#right').html(html); 
				//Funciones para la tabla de resultados 
				$("#report tr:odd").addClass("odd");
				$("#report tr:not(.odd)").hide();
				$("#report tr:first-child").show();  
				/*$("#report div.arrow").click(function(){
					$(this).next("tr").toggle();
					$(this).find(".arrow").toggleClass("up");
				});  */
				$("#report div.arrow").click(function(){
					$(this).parent().parent().find(".arrow").toggleClass("up");
					if ($(this).parent().parent().next("tr").is(":visible")){
						$('#info_' + $(this).parent().parent().attr('id')).html("");
						$(this).parent().parent().next("tr").slideUp();												
					}
					else{
						getInfoEmpleado($(this).parent().parent().attr('id'), $(this).parent().attr('class'));
						$(this).parent().parent().next("tr").slideDown();						
					}
					//$(this).parent().parent().next("tr").toggle();				
				});      
            }      
        });
		
		//cancel the submit button default behaviours
        return false;
	}); 
	
	//Hacer búsqueda de inicio
	$("#doBuscar").trigger("click"); 
	 
});

//para cambiar de pagina
function Buscar(pageno) {        
         
	//Get the data from all the fields
	var page = pageno;
	var nombre = $('input[name=nombre2]');
	var gerencia = $('input[name=gerencia2]');
	var ubicacion = $('input[name=ubicacion2]');
	var obra = $('input[name=obra2]');
	var empresa = $('input[name=empresa2]');
	var tipo = $('input[name=tipo2]');
	var finiquitado = $('input[name=finiquitado2]');

	//organize the data properly
	var data = 'nombre=' + nombre.val() + '&gerencia=' + gerencia.val() + '&ubicacion='
	+ ubicacion.val() + '&obra=' + obra.val() + '&empresa=' + empresa.val() + '&tipo='  + tipo.val()
	+ '&finiquitado='  + finiquitado.val()+ '&page='  + page;
	 
	//start the ajax
	$.ajax({
		//this is the php file that processes the data and send mail
		url: "buscarPrestamos.php",      
		//GET method is used
		type: "GET",
		//pass the data        
		data: data,                
		//Do not cache the page
		cache: false,            
		//success
		success: function (html) {   				        
			$('#right').html(html);
			//Funciones para la tabla de resultados 
			$("#report tr:odd").addClass("odd");
			$("#report tr:not(.odd)").hide();
			$("#report tr:first-child").show(); 	
			$("#report div.arrow").click(function(){
				$(this).parent().parent().find(".arrow").toggleClass("up");
				if ($(this).parent().parent().next("tr").is(":visible")){
					$('#info_' + $(this).parent().parent().attr('id')).html("");
					$(this).parent().parent().next("tr").slideUp();												
				}
				else{
					getInfoEmpleado($(this).parent().parent().attr('id'), $(this).parent().attr('class'));
					$(this).parent().parent().next("tr").slideDown();						
				}
				//$(this).parent().parent().next("tr").toggle();
			});         
		}      
	});
	 
	//cancel the submit button default behaviours
	return false;
}

function getInfoEmpleado(id, clase) {
	var data = 'id=' + id + '&class=' + clase;

	$.ajax({
		url: 'consultarPrestamos.php',      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) {  
			$('#info_' + id).html(html);		
		}      
	});
}

//Se llama al hacer click en el boton de modificar de un prestamo
function iniModificar(id, idf) {
	var data = 'id=' + id + '&idf=' + idf + '&modificar=true';
	
	$.ajax({
		url: 'consultarPrestamos.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',
		success: function (html) { 
			
			$('input[name=fecha_solicitud]').val(html.fecha_solicitud);	
			$('input[name=fecha_fin]').val(html.fecha_fin);	
			$('input[name=monto]').val(html.monto);
			$('select[name=estado]').val(html.estado);
			
			$('input[name=eliminar_archivo]').attr('checked', false);
			$('#archivo_div').html("<input type='file' id='archivo' name='archivo' value='' />");
			$(":file").uniform();
			
			if (html.archivo == "") {
				$('#archivo_eliminar').hide();
			} else {
				$('#archivo_actual').html("<a href='./archivos/" + html.archivo + "' target='_blank'> Ver archivo</a>");
				$('#archivo_eliminar').show();	
			}
						
			$('input[name=accion]').val("modificar");
			$('input[name=id_empleado]').val(id);
			$('input[name=id_prestamo]').val(idf);
			$.uniform.update("select");	
			
			$('#label_im').html("Modificar Pr&eacute;stamo para " + html.nombre);
			$('#buscar').hide();
			$('#datos').show();	
		},  
		error: function (data, status, e) {
			apprise(status);
		}    
	});
		
	return false;
}

//Se llama al hacer click en el boton de insertar prestamos
function iniInsertar(id, nombre) {
	$('input[name=fecha_solicitud]').val("");
	$('input[name=fecha_fin]').val("");
	$('input[name=monto]').val("");
	$('select[name=estado]').val("0");
	
	$('#archivo_div').html("<input type='file' id='archivo' name='archivo' value='' />");
	$(":file").uniform();
	$('#archivo_eliminar').hide();
		
	$('input[name=accion]').val("insertar");
	$('input[name=id_empleado]').val(id);
	$.uniform.update("select");	
		
	$('#label_im').html("Agregar pr&eacute;stamo a " + nombre);
	$('#buscar').hide();
	$('#datos').show();	
	return false;
}

//Se llama al hacer click en el boton de eliminar prestamos
function eliminarPrestamos(id, idf) {
	var data = 'id=' + id + '&idf=' + idf;
	 
	apprise('Se eliminar&aacute; permanentemente el registro del pr&eacute;stamo. <br /><br />' 
			+ '¿Seguro que desea eliminar el registro?', 
		{'verify':true, 'textYes':'Si, elim&iacute;nalo!', 'textNo':'No, quiero conservar el registro'}, 
		function(r){
    		if(r){
				jQuery('#buscar').showLoading();
				$.ajax({
					url: 'eliminarPrestamos.php',    
					type: "GET",       
					data: data,            
					cache: false,            
					//success
					success: function (html) { 
						jQuery('#buscar').hideLoading(); 
						$("#doBuscar").trigger("click");
						apprise("Se ha eliminado el registro con &eacute;xito.");	
					},  
					error: function (data, status, e)
					{
						jQuery('#buscar').hideLoading(); 
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

//inserta o modifica un registro de prestamo
function modinsertar(id, idf, arch) {
	//Get the data from all the fields	
	var idr = id;
	var eliminar_archivo;
	var fecha_solicitud = $('input[name=fecha_solicitud]').val();
	var fecha_fin = $('input[name=fecha_fin]').val();
	var monto = $('input[name=monto]').val();
	var estado = $('select[name=estado]').val();
	var archivo = arch;
	var accion = $('input[name=accion]').val();
	
	if ($('input[name=eliminar_archivo]').is(':checked')) {
		archivo = "";
		eliminar_archivo = "1";
	}
	else {
		eliminar_archivo = "0";
	}
	
	var action = "insertarModificarPrestamos.php";
	
	var data = 'id=' + idr + '&idf=' + idf + '&fecha_solicitud=' + fecha_solicitud 
	+ '&fecha_fin=' + fecha_fin + '&monto=' + monto + '&estado=' + estado + '&archivo='
	+ archivo + '&accion=' + accion + '&eliminar_archivo=' + eliminar_archivo;

	$.ajax({
		//this is the php file that processes the data and send mail
		url: action,      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			jQuery('#datos').hideLoading();           
			if (html.trim() == "success") {						
				$('#datos').hide();
				$('#buscar').show();
				$("#doBuscar").trigger("click");
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

function ajaxFileUpload(tipo, accion, id, idr, idp){
	jQuery('#datos').showLoading();
	var arch = encodeURIComponent($('#archivo').val().replace(/^.*[\\\/]/, ''));
	if (arch == "" && !$('input[name=eliminar_archivo]').is(':checked')) {
		modinsertar(idr, idp, arch);
		return false;
	}

	if ($('input[name=eliminar_archivo]').is(':checked')) {
		accion = "borrar";	
	}	
	
	$.ajaxFileUpload
	(
		{
			url:'doajaxfileupload.php', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr, idp:idp },
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined') {
					if(data.error != '') {
						apprise(data.error);
					} else {
						modinsertar(idr, idp, arch);
						//alert(data.msg);
					}					
				}
				else {
					//alert(data.msg + data.error);
				}
			},
			error: function (data, status, e)
			{
				apprise(e);
			}
		}
	)	
	return false;
}