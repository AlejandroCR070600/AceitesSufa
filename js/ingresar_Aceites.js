let btnAgregarDatos=document.getElementById("btnAgregarDatos");
btnAgregarDatos.addEventListener('click',function(event){


let aceites=document.getElementById('ingresoAceites').value;
let folio=document.getElementById('ingresoFolio').value;
let btn=btnAgregarDatos.value;

let datos=[aceites,folio, btn];


 fetch("BD/ingresar_Aceites.php",{
        method:"POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(datos)
})
.then(res=> res.json())
.then(data=>{
let h1=document.getElementById("aceites_stock");
h1.textContent="10";
})



});

