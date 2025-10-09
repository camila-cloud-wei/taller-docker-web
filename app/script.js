function validarFormulario() {
    const nombre = document.getElementById('nombre').value.trim();
    const correo = document.getElementById('correo').value.trim();
    const telefono = document.getElementById('telefono').value.trim();
    const tipoConsulta = document.getElementById('tipo_consulta').value;
    const categoria = document.getElementById('categoria').value;
    const mensaje = document.getElementById('mensaje').value.trim();
    
    if (!nombre || !correo || !telefono || !tipoConsulta || !categoria || !mensaje) {
        alert("Por favor completa todos los campos.");
        return false;
    }
    
    if (telefono.length < 5) {
        alert("El teléfono debe tener al menos 5 dígitos.");
        return false;
    }
    
    return true;
}

function validarCampo(campo) {
    const valor = campo.value.trim();
    const errorElement = document.getElementById(campo.id + 'Error');
    
    // Remover clases previas
    campo.classList.remove('valid', 'invalid');
    
    if (campo.type === 'tel' && campo.required) {
        if (valor.length >= 5) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'El teléfono debe tener al menos 5 dígitos.';
        }
    }
    
    if (campo.type === 'email' && campo.required) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailRegex.test(valor)) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Por favor ingresa un email válido.';
        }
    }
    
    if (campo.type === 'text' && campo.required && campo.id !== 'telefono') {
        if (valor.length > 0) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
    
    if (campo.tagName === 'SELECT' && campo.required) {
        if (valor !== '') {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
    
    if (campo.tagName === 'TEXTAREA' && campo.required) {
        if (valor.length > 0) {
            campo.classList.add('valid');
            errorElement.textContent = '';
        } else {
            campo.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio.';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('invalid')) {
                validarCampo(this);
            }
        });
    });
});