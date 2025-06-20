function mostrarFormulario(number) {
  let forms = document.querySelectorAll('.forms');

  forms.forEach(function(form, i) {
    console.log(number);
    form.classList.add('d-none'); // Oculta todos
    if (i === number-1) {
      form.classList.remove('d-none'); // Muestra solo uno
    }
  });
}
