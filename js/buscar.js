let btnBuscar=document.getElementById("btnBuscar");
let datos={};

btnBuscar.addEventListener("click", function(event){
event.preventDefault();

let inputFolio=document.getElementById("opciones");
let inputBuscar=document.getElementById("buscar");


datos={
    "columna":inputFolio.value,
    "buscar":inputBuscar.value,
    "btn":btnBuscar.value
};


fetch("BD/buscar.php",{
method:"POST",
headers:{
    "Content-Type": "application/json"
},
body:JSON.stringify(datos)
})
.then(res=>res.json())
.then(data=>{
    const control_aceites=['id','Fecha','Moto_Num','Cant_Aceites','folio'];
    
    datos=data;
    crearTR(datos['datos']);

});

});