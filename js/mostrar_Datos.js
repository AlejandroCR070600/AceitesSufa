



fetch("BD/mostrar_datos.php")
.then(res=>res.json())
.then(data=>{
    datos={};
    //guardamos los datos mandados de php en el objeo datos
    datos=data;
    
    
    //variables utilizadas
    
    let select_Folios=document.getElementById('selectF');
    let aceites_Disponibles=document.getElementById('aceites_stock');
    

    //agrega el valor de los aceites disponibles de momento en el h1
    aceites_Disponibles.textContent=datos['aceites_stock'];
    
    
    //crea los options de los folios
    for(let i=datos['folio'].length-1;i>=0;i--){
        let options=document.createElement('option');
        options.textContent=datos['folio'][i];
        select_Folios.appendChild(options);

    }
    
    // mostrar los datos de los aceites al iniciar la pagina
    crearTR(datos)
});

function crearTR(datos){
const tbody = document.getElementById("tbody");
    tbody.innerHTML = ""; // Limpiar tabla antes de agregar filas nuevas
    
    let control_aceites = ['id', 'Fecha', 'Moto_Num', 'Cant_Aceites', 'folio'];
    
    for (let i = 0; i < datos['show_datos'].length; i++) {
        let tr = document.createElement('tr');
        for (let e = 0; e < 6; e++) {
            let td = document.createElement('td');
            td.id = control_aceites[e] + (i + 1);
            td.textContent = datos['show_datos'][i][control_aceites[e]];
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }
};









