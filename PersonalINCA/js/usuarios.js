$(document).ready(function(){
	
	$('#usuario0')
	   .validate({
         submitHandler: function(form) {		 	
			 modificar("0", $('input[name=nombre0]').val(), $('input[name=id0]').val(), $('input[name=password0]').val(), 
			 			$('input[name=newpassword0]').val(), $('input[name=cnewpassword0]').val());	           				
         }
    });
	
	$('#usuario1')
	   .validate({
         submitHandler: function(form) {		 	
			 modificar("1", $('input[name=nombre1]').val(), $('input[name=id1]').val(), "", 
			 			$('input[name=newpassword1]').val(), $('input[name=cnewpassword1]').val());	           				
         }
    });
	
	$('#usuario2')
	   .validate({
         submitHandler: function(form) {		 	
			 modificar("2", $('input[name=nombre2]').val(), $('input[name=id2]').val(), "", 
			 			$('input[name=newpassword2]').val(), $('input[name=cnewpassword2]').val());	           				
         }
    });
	
	//Mensajes en espaniol para la validacion de la forma
	jQuery.extend( jQuery.validator.messages, {
	  required: "Este campo es obligatorio."	  
	});
});

//modificar un usuario
function modificar(nivel, nombre, id, password, newpassword, cnewpassword) {
	
	id = encodeURIComponent(id);
	nombre = encodeURIComponent(nombre);
	password = encodeURIComponent(password);
	newpassword = encodeURIComponent(newpassword);
	cnewpassword = encodeURIComponent(cnewpassword);
	
	var action = "modificarUsuarios.php";

	var data = 'nivel=' + nivel + '&id=' + id + '&nombre=' + nombre + '&password=' + password
	+ '&newpassword=' + newpassword + '&cnewpassword=' + cnewpassword;

	$.ajax({
		url: action,      
		type: "GET",      
		data: data,                
		cache: false,            
		success: function (html) {          
			if (html.trim() == "success") {						
				apprise("Se ha modificado el usuario correctamente.");						
			}
			else {
				apprise(html);
			}
		}      
	});	
}