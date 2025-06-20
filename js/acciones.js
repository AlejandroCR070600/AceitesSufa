function mostrarFormulario(number){
    let forms=document.querySelectorAll('.form');
    
    
    forms.forEach(function(form, i){
        form.style.display="none";
        if( i===number){
            form.style.display="block";
            form.offsetHeight;
        }
        
        
    });
}