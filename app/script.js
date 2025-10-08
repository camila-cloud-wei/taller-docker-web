// Validaciones en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    // Patrones de validación
    const patterns = {
        nombre: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,}$/,
        correo: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
        telefono: /^[\d\s\-\+]{10,}$/,
        mensaje: /^.{10,}$/
    };

    // Mensajes de error
    const errorMessages = {
        nombre: 'El nombre debe tener al menos 2 caracteres y solo contener letras y espacios',
        correo: 'Por favor ingresa un correo electrónico válido',
        telefono: 'El teléfono debe tener al menos 10 dígitos',
        tipo_consulta: 'Por favor selecciona un tipo de consulta',
        mensaje: 'El mensaje debe tener al menos 10 caracteres'
    };

    // Validación en tiempo real
    inputs.forEach(input => {
        if (input.type !== 'checkbox') {
            input.addEventListener('input', function() {
                validateField(this);
            });
            
            input.addEventListener('blur', function() {
                validateField(this);
            });
        }
    });

    // Validación del formulario completo al enviar
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        inputs.forEach(input => {
            if (input.type !== 'checkbox' && input.required) {
                if (!validateField(input)) {
                    isValid = false;
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            showNotification('Por favor corrige los errores en el formulario', 'error');
        }
    });

    function validateField(field) {
        const fieldName = field.name;
        const value = field.value.trim();
        const errorElement = document.getElementById(`${fieldName}-error`);
        
        // Reset estado
        field.classList.remove('valid', 'invalid');
        errorElement.textContent = '';

        // Validar campo vacío
        if (field.required && !value) {
            field.classList.add('invalid');
            errorElement.textContent = 'Este campo es obligatorio';
            return false;
        }

        // Validar según patrón
        if (patterns[fieldName] && !patterns[fieldName].test(value)) {
            field.classList.add('invalid');
            errorElement.textContent = errorMessages[fieldName];
            return false;
        }

        // Validación especial para select
        if (field.tagName === 'SELECT' && field.required && !value) {
            field.classList.add('invalid');
            errorElement.textContent = errorMessages[fieldName];
            return false;
        }

        // Campo válido
        field.classList.add('valid');
        return true;
    }

    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert ${type}`;
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            animation: slideIn 0.3s ease;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, 5000);
    }

    // Smooth scroll para navegación
    document.querySelectorAll('nav a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Efectos hover mejorados
    const buttons = document.querySelectorAll('button, .social-link, nav a');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Animación para elementos al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observar elementos para animaciones
    document.querySelectorAll('.form-section, .table-section, .about-section').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(section);
    });
});