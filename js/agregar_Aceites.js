let btnAgregarDatos=document.getElementById("btnAgregarDatos");
btnAgregarDatos.addEventListener('click',function(event){


let aceites=document.getElementById('agregarDatos').value;
let folio=document.getElementById('agregarFolio').value;
let btn=btnAgregarDatos.value;

let datos=[aceites,folio, btn];


fetch("BD/aceites_Disponibles.php",{
    method:"POST",
    headers:{
        "Content-Type": "application/json"
    },
    body: JSON.stringify(datos)
})
.then(res=>res.text())
.then(data=>{
let h1=document.getElementById("aceites_stock");
h1.textContent="10";
})



});

