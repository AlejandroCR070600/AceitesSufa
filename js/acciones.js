function mostrarFormulario(number) {
  let forms = document.querySelectorAll('.forms');

  forms.forEach(function(form, i) {
    console.log(number);
    form.classList.add('d-none'); // Oculta todos
    if (i === number-1) {
      form.classList.remove('d-none'); // Muestra solo uno
    }
  });
}


let btnBuscar=document.getElementById("btnBuscar");
btnBuscar.addEventListener('click', function(event){
event.preventDefault()
  console.log("hola");
  buscar();
})


function buscar(){
  let selectOpciones=document.getElementById('opciones');
  let inputBuscar=document.getElementById('buscar');
    console.log( "holias") ;
  console.log( selectOpciones.value) ;
  console.log( inputBuscar.value) ;


}
