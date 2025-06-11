function mostrarFormulario(formID){

console.log(formID);
document.querySelectorAll('.form').forEach(function(form) {
                form.style.display = 'none';
            });

            // Mostrar el formulario seleccionado
            document.getElementById('form' + formID).style.display = 'block';
}