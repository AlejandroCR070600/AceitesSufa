let btnAgregarDatos=document.getElementById("btnAgregarDatos");
btnAgregarDatos.addEventListener('click',function(event){
event.preventDefault();

let aceites=document.getElementById('ingresoAceites').value;
let folio=document.getElementById('ingresoFolio').value;
let btn=btnAgregarDatos.value;

let datos={aceites,folio, btn};


 fetch("BD/aceites_Disponibles.php",{
        method:"POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(datos)
})
.then(res=> res.json())
.then(data=>{
console.log(data);
})



});