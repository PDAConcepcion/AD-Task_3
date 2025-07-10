// Main application functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus first input on page load
    const firstInput = document.querySelector('input[type="text"], input[type="email"], input[type="password"]');
    if (firstInput) {
        firstInput.focus();
    }
    
    // Enhanced button interactions
    initializeButtons();
    
    // Auto-hide alerts
    initializeAlerts();
    
    // Form validation
    initializeFormValidation();
    
    // Navbar enhancements
    initializeNavbar();
});

// Button initialization
function initializeButtons() {
    document.querySelectorAll('.btn-danger').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && this.href.includes('logout')) {
                if (!confirm('Are you sure you want to logout?')) {
                    e.preventDefault();
                }
            }
        });
    });
}

// Alert system
function initializeAlerts() {
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });
}

// Form validation
function initializeFormValidation() {
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

function validateField(field) {
    const isValid = field.checkValidity() && (field.hasAttribute('required') ? field.value.trim() : true);
    
    if (isValid) {
        field.style.borderColor = '#28a745';
        field.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.1)';
    } else {
        field.style.borderColor = '#dc3545';
        field.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
    }
}

// Navbar enhancements
function initializeNavbar() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.navbar-nav a').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.style.background = 'rgba(102, 126, 234, 0.2)';
            link.style.color = '#667eea';
        }
    });
}