

//fetch para mandar el folio que se quiere
let select= document.getElementById('selectF');
let datosR ={};
let control_aceites=['id','Fecha','Moto_Num','Cant_Aceites','folio'];
select.addEventListener('change', function(){
    let value=select.value;
    let id=select.id;
    
    datos={
        'folio':value,
        'id':id,
    };
    

    fetch("BD/mostrar_datos.php",{
        method:"POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(datos)
})
.then(res=> res.json())
.then(data=>{
    datosR=data;
    console.log(data['show_datos']);
    crearTR(datos['show_datos']);
    
});

});


