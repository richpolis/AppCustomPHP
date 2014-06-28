$(document).ready(function(){
	
	//Inicializacion para los botones de insertar, cancelar y modificar
	$('#datos').hide();
	
	$('#change-form')
	   .validate({
         submitHandler: function(form) {			 
			 ajaxFileUpload("foraneidad1", "archivo_alta", $('input[name=id_empleado]').val());        				
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
            url: "buscarForaneidades.php",      
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
		
	//para cambiar de pagina	
	//if submit button is clicked
    //$('.cambiapag').click(function () {  
	 
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
		url: "buscarForaneidades.php",      
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
	//Get the data from all the fields

	var data = 'id=' + id + '&class=' + clase;
	//jQuery('#datos').showLoading();

	$.ajax({
		url: 'consultarForaneidades.php',      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) { 
			//jQuery('#datos').hideLoading();  
			$('#info_' + id).html(html);		
		}      
	});
}

//Se llama al hacer click en el boton de modificar foraneidades
function iniModificar(id) {
	var data = 'id=' + id + '&modificar=true';

	$.ajax({
		url: 'consultarForaneidades.php',      
		type: "GET",       
		data: data,  
		dataType: 'json',             
		//cache: false,            
		//success
		success: function (html) { 
			//jQuery('#datos').hideLoading(); 
			
			$('select[name=estado]').val(html.estado);	
			$('input[name=monto]').val(html.monto);	
			$('input[name=transporte]').val(html.transporte);			
			$('input[name=eliminar_archivo_alta]').attr('checked', false);
			$('input[name=eliminar_archivo_baja]').attr('checked', false);
			$('#archivo_alta_div').html("<input type='file' id='archivo_alta' name='archivo_alta' value='' />");
			$('#archivo_baja_div').html("<input type='file' id='archivo_baja' name='archivo_baja' value='' />");
			$(":file").uniform();
			
			if (html.archivo_alta == "") {
				$('#archivo_alta_eliminar').hide();
			} else {
				$('#archivo_alta_actual').html("<a href='./archivos/" + html.archivo_alta + "' target='_blank'> Ver archivo</a>");
				$('#archivo_alta_eliminar').show();	
			}
			
			if (html.archivo_baja == "") {
				$('#archivo_baja_eliminar').hide();
			} else {
				$('#archivo_baja_actual').html("<a href='./archivos/" + html.archivo_baja + "' target='_blank'> Ver archivo</a>");
				$('#archivo_baja_eliminar').show();	
			}
						
			$('input[name=id_empleado]').val(id);
			$.uniform.update("select");	
			
			$('#label_im').html("Modificar Foraneidad/Compensación de " + html.nombre);
			$('#buscar').hide();
			$('#datos').show();	
		},  
		error: function (data, status, e)
		{
				apprise(e);
		}    
	});
		
	return false;
}

//modifica un registro de una foraneidad
function modificar(id, arch1, arch2) {
	//Get the data from all the fields	
	var idr = id;
	var eliminar_archivo1;
	var eliminar_archivo2;
	var estado = $('select[name=estado]').val();
	var monto = $('input[name=monto]').val();
	var transporte = $('input[name=transporte]').val();
	var archivo_alta = arch1;
	var archivo_baja = arch2;
	var accion = "modificar";
	
	if ($('input[name=eliminar_archivo_alta]').is(':checked')) {
		archivo_alta = "";
		eliminar_archivo1 = "1";
	}
	else {
		eliminar_archivo1 = "0";
	}
	if ($('input[name=eliminar_archivo_baja]').is(':checked')) {
		archivo_baja = "";
		eliminar_archivo2 = "1";
	}
	else {
		eliminar_archivo2 = "0";
	}
	
	var action = "modificarForaneidades.php";

	var data = 'id=' + idr + '&estado=' + estado + '&monto=' + monto + '&transporte=' + transporte + '&archivo_alta=' + archivo_alta
	+ '&archivo_baja=' + archivo_baja + '&accion=' + accion + '&eliminar_archivo1=' + eliminar_archivo1
	+ '&eliminar_archivo2=' + eliminar_archivo2;

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
				apprise("Se ha modificado el registro correctamente.");							
			}
			else {
				apprise(html);
			}
		}      
	});	
}
	
function ajaxFileUpload(tipo, id, idr){
	//starting setting some animation when the ajax starts and completes
	jQuery('#datos').showLoading();
	var arch1 = encodeURIComponent($('#archivo_alta').val().replace(/^.*[\\\/]/, ''));
	
	if (arch1 == "" && !$('input[name=eliminar_archivo_alta]').is(':checked')) {
		ajaxFileUpload2("foraneidad2", "archivo_baja", idr, arch1);
		return false;	
	}
	
	var accion = "";

	if ($('input[name=eliminar_archivo_alta]').is(':checked')) {
		accion = "borrar";
	}
	else {
		accion = "modificar";
	}

	$.ajaxFileUpload
	(
		{
			url:'doajaxfileupload.php', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr },
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{
						apprise(data.error);
					}else {
						ajaxFileUpload2("foraneidad2", "archivo_baja", idr, arch1);
						//apprise(data.msg);
					}
					
				}
				else {
					//alert(data.msg + data.error);
				}
			},
			error: function (data, status, e) {
				apprise(e);
			}
		}
	)	
	return false;
}

function ajaxFileUpload2(tipo, id, idr, arch1){
	//starting setting some animation when the ajax starts and completes
	jQuery('#datos').showLoading();
	var arch2 = encodeURIComponent($('#archivo_baja').val().replace(/^.*[\\\/]/, ''));
	
	if (arch2 == "" && !$('input[name=eliminar_archivo_baja]').is(':checked')) {
		modificar(idr, arch1, arch2);
		return false;	
	}
	
	var accion = "";
	
	if ($('input[name=eliminar_archivo_baja]').is(':checked')) {
		accion = "borrar";
	}
	else {
		accion = "modificar";
	}

	$.ajaxFileUpload
	(
		{
			url:'doajaxfileupload.php', 
			secureuri:false,
			fileElementId:id,
			dataType: 'json',
			data:{tipo:tipo, accion:accion, id:id, idr:idr },
			success: function (data, status)
			{
				if(typeof(data.error) != 'undefined')
				{
					if(data.error != '')
					{
						apprise(data.error);
					}else {
						modificar(idr, arch1, arch2);
						//apprise(data.msg);
					}
					
				}
				else {
					//alert(data.msg + data.error);
				}
			},
			error: function (data, status, e) {
				apprise(e);
			}
		}
	)	
	return false;
}
