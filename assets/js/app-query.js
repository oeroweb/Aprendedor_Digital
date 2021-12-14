$(document).ready(function(){
  //INGRESAR SOLO NUMEROS - Clase
  $('.number').keypress(function(tecla) {
    // solo numeros
          if(tecla.charCode < 46 || tecla.charCode > 57) return false;
    // con punto
          if((tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode != 46)) return false;
  });
      
  //INGRESAR SOLO LETAS - clase
  $('.texto').keypress(function(tecla) {
  if((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode >= 192 && tecla.charCode <= 255) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 32) && (charCode >= 187 && charCode <= 255)) return false;
  });
    
  //LIMITE DE CARACTERES - ID
  // <input type="text" name="oc" id="oc" data-maxlength="12">    
  //$('.text50').keyup(validateMaxLength);
  //$('.nombre').keyup(validateMaxLength);
  
  
  function validateMaxLength(){
    var text = $(this).val();
    var maxlength = $(this).data('maxlength');
    if(maxlength > 0) {
      $(this).val(text.substr(0, maxlength)); 
    }
  }

  //LIMITE DE CARACTERES - COUNTER
  //<input type="text" name="" maxlength="12">
  //<span class="counter">20</span>
  // const input = document.querySelector("form .inputnombre"), 
  //   maxlength = input.getAttribute("maxlength"),
  //   counter = document.querySelector("form .counterNombre"); 

  // input.onkeyup = () =>{
  //   counter.innerText = maxlength - input.value.length;
  // }

  // CERRAR MODAL
	$(".fa-times").click(function(){
		$("#modalBienvenida").slideToggle(2000);
	});

});
  