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
    const td=document.querySelectorAll("td");
    td.forEach(fila=>fila.remove() );

    for(let i=1;i<=datosR['show_datos'].length;i++){
        
        let tr=document.createElement('tr');
        for(let e=0;e<6;e++){
            
            let td=document.createElement('td');
            let restaI=i-1;
          
            td.id=control_aceites[e]+i;
            td.textContent=datosR['show_datos'][restaI][control_aceites[e]];
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }
    
});

})