
  function mostrarFormulario(formId) {
            // Ocultar todos los formularios
            document.querySelectorAll('.form-container').forEach(function(form) {
                form.style.display = 'none';
            });

            // Mostrar el formulario seleccionado
            document.getElementById('form' + formId).style.display = 'block';
        }