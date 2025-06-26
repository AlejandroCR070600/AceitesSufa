let btnBuscar=document.getElementById("btnBuscar");
let datos={};
btnBuscar.addEventListener("click", function(event){
event.preventDefault();

let inputFolio=document.getElementById("opciones");
let inputBuscar=document.getElementById("buscar");


datos={
    "folio":inputFolio.value,
    "buscar":inputBuscar.value,
    "btn":btnBuscar.value
};

console.log(datos["folio"]);
console.log(datos["buscar"]);
fetch("BD/buscar.php",{
method:"POST",
headers:{
    "Content-Type": "application/json"
},
body:JSON.stringify(datos)
})
.then(res=>res.json())
.then(data=>{
console.log(data["folio"]);

})

});