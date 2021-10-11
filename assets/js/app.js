function getPassword(){
  var chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%&/()_+<>:{}[]";
  var passwordLength = 16;
  var password = "";
  for( var i=0; i< passwordLength; i ++){
    var randomNumber = Math.floor(Math.random() * chars.length);
    password += chars.substring(randomNumber, randomNumber +1);
  }
  document.getElementById("clave").value = password;
}

function confirmDelete(e){
  var respuesta = confirm("Estas seguro que deseas de eliminar el registro!");

  if(respuesta == true){
    return true;
  }else{
    return false;
  }
}

function modalDelete(e){
  console.log("click");
  e.preventDefault();

  var modalEliminar = document.getElementById("modalEliminar");
  modalEliminar.classList.add(".is-active");


  //var respuesta = confirm("Estas seguro que deseas de eliminar el registro!");

  // if(respuesta == true){
  //   return true;
  // }else{
  //   return false;
  // }
}

const accordion = document.querySelectorAll(".content-accordion"), 
 icon = document.querySelectorAll(".btn-accordion i"),
 btnAccordion = document.querySelectorAll(".btn-accordion");

btnAccordion.forEach((item, i)  => {
  btnAccordion[i].addEventListener('click', () => {
    icon[i].classList.toggle('rotate180');
    
    accordion.forEach( ( item, i) => {
      accordion[i].classList.remove('active');
    })
    accordion[i].classList.add('active');
  })
})


