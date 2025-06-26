function mostrarFormulario(number) {
  let forms = document.querySelectorAll('.forms');

  forms.forEach(function(form, i) {
    
    form.classList.add('d-none'); // Oculta todos
    if (i === number-1) {
      form.classList.remove('d-none'); // Muestra solo uno
    }
  });
}
//--------------------------------- ENTREGAR ACEITES----------------------------------------------------
let btnAgregar=document.getElementById("btnAgregar");
btnAgregar.addEventListener('click',function(event){
  event.preventDefault();
  let aceites=document.getElementById('aceites').value;
  let num_Moto=document.getElementById('Num_moto').value;
  let fecha=document.getElementById('fecha').value;
  btn=btnAgregar.value
  datos=[aceites,num_Moto, fecha,btn];
  

  fetch("BD/entregar_Aceite.php",{
    method:"POST",
    headers:{
      "Content-Type" : "application/json"
    },
    body: JSON.stringify(datos)
  })
  .then(res=> res.json())
  .then(data=>{
    console.log(data);
  })
  



});



