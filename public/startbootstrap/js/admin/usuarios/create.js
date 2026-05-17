function toggleVetFields() {
    var rol = document.getElementById('rol').value;
    var vetFields = document.getElementById('veterinario_fields');
    var cedulaInput = document.getElementById('cedula_profesional');
    
    if (rol === 'veterinario') {
        vetFields.style.display = 'block';
        cedulaInput.required = true;
    } else {
        vetFields.style.display = 'none';
        cedulaInput.required = false;
    }
}

// Ejecutar al cargar la página por si hay errores de validación y se mantuvo la opción seleccionada
window.onload = function() {
    toggleVetFields();
};
