// Theme Management
class ThemeManager {
    constructor() {
        this.body = document.body;
        this.themeToggle = document.getElementById('themeToggle');
        this.init();
    }

    init() {
        // Load saved theme or default to dark
        const savedTheme = localStorage.getItem('theme') || 'dark';
        this.setTheme(savedTheme);
        
        // Add event listener
        this.themeToggle.addEventListener('click', () => this.toggleTheme());
    }

    setTheme(theme) {
        if (theme === 'dark') {
            this.body.classList.add('dark');
        } else {
            this.body.classList.remove('dark');
        }
        localStorage.setItem('theme', theme);
    }

    toggleTheme() {
        const isDark = this.body.classList.contains('dark');
        this.setTheme(isDark ? 'light' : 'dark');
    }

    getCurrentTheme() {
        return this.body.classList.contains('dark') ? 'dark' : 'light';
    }
}

// Password Visibility Toggle
class PasswordToggle {
    constructor() {
        this.passwordInput = document.getElementById('password');
        this.passwordToggle = document.getElementById('passwordToggle');
        this.init();
    }

    init() {
        this.passwordToggle.addEventListener('click', () => this.toggle());
    }

    toggle() {
        const isPasswordVisible = this.passwordInput.type === 'text';
        
        if (isPasswordVisible) {
            this.passwordInput.type = 'password';
            this.passwordToggle.classList.remove('show');
        } else {
            this.passwordInput.type = 'text';
            this.passwordToggle.classList.add('show');
        }
    }
}

// Toast Notification System
class ToastManager {
    constructor() {
        this.toast = document.getElementById('toast');
        this.toastIcon = this.toast.querySelector('.toast-icon');
        this.toastTitle = this.toast.querySelector('.toast-title');
        this.toastDescription = this.toast.querySelector('.toast-description');

        // SVGs para cada tipo
        this.icons = {
            success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12l2 2 4-4"/>
                        <circle cx="12" cy="12" r="10"/>
                      </svg>`,
            error: `<svg style="stroke: #F44336;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>`
        };
    }

    show(title, description, type = 'success', duration = 3000) {
        this.toastTitle.textContent = title;
        this.toastDescription.textContent = description;

        // Remove classes anteriores
        this.toast.classList.remove('success', 'error');

        // Adiciona a classe do tipo
        this.toast.classList.add(type);

        // Troca o ícone
        this.toastIcon.innerHTML = this.icons[type] || this.icons.success;

        // Mostra o toast
        this.toast.classList.add('show');

        // Oculta após duração
        setTimeout(() => this.hide(), duration);
    }

    hide() {
        this.toast.classList.remove('show');
    }
}


// Form Validation and Submission
class LoginForm {
    constructor() {
        this.form = document.getElementById('loginForm');
        this.emailInput = document.getElementById('email');
        this.passwordInput = document.getElementById('password');
        this.loginButton = document.getElementById('loginButton');
        this.toast = new ToastManager();
        this.init();
    }

    init() {
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        // Add input validation
        this.emailInput.addEventListener('blur', () => this.validateEmail());
        this.passwordInput.addEventListener('blur', () => this.validatePassword());
        
        // Real-time validation
        this.emailInput.addEventListener('input', () => this.clearErrors());
        this.passwordInput.addEventListener('input', () => this.clearErrors());
    }

  async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateForm()) {
            return;
        }

        this.startLoading();
        
        const res = await fetch("./", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: this.emailInput.value.trim(),
                password: this.passwordInput.value.trim(),
            })
        });
        
        const data = await res.json();


        if(data.success){

            // Simulate login process
            setTimeout(() => {

                this.stopLoading();

                this.toast.show(
                    'Login realizado com sucesso!',
                    'Redirecionando para o painel...',
                    'success'
                );
                
                setTimeout(() => {
                   window.location.href = '../painel';
                }, 1500);
            }, 2000);
        }else{
            this.stopLoading();
            this.toast.show(
                'Erro de validação',
                data.error,
                'error'
            );
        }
    }

    validateForm() {
        const email = this.emailInput.value.trim();
        const password = this.passwordInput.value.trim();
        
        if (!email || !password) {
            this.toast.show(
                'Erro de validação',
                'Por favor, preencha todos os campos.',
                'error'
            );
            
            // Highlight empty fields
            if (!email) this.addError(this.emailInput);
            if (!password) this.addError(this.passwordInput);
            
            return false;
        }

        return true;
    }

    validateEmail() {
        const email = this.emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email) && email.indexOf('@') > -1) {
            this.addError(this.emailInput, 'Email inválido');
            return false;
        }
        
        this.removeError(this.emailInput);
        return true;
    }

    validatePassword() {
        const password = this.passwordInput.value.trim();
        
        if (password && password.length < 6) {
            this.addError(this.passwordInput, 'Senha deve ter pelo menos 6 caracteres');
            return false;
        }
        
        this.removeError(this.passwordInput);
        return true;
    }

    addError(input, message = '') {
        input.style.borderColor = '#ef4444';
        input.style.backgroundColor = 'rgba(239, 68, 68, 0.05)';
    }

    removeError(input) {
        input.style.borderColor = '';
        input.style.backgroundColor = '';
    }

    clearErrors() {
        this.removeError(this.emailInput);
        this.removeError(this.passwordInput);
    }

    startLoading() {
        this.loginButton.classList.add('loading');
        this.loginButton.disabled = true;
        this.emailInput.disabled = true;
        this.passwordInput.disabled = true;
    }

    stopLoading() {
        this.loginButton.classList.remove('loading');
        this.loginButton.disabled = false;
        this.emailInput.disabled = false;
        this.passwordInput.disabled = false;
    }
}

// Smooth Animations and Effects
class UIEffects {
    constructor() {
        this.init();
    }

    init() {
        // Add smooth hover effects
        this.addHoverEffects();
        
        // Add focus effects
        this.addFocusEffects();
        
        // Initialize entrance animations
        this.initAnimations();
    }

    addHoverEffects() {
        const buttons = document.querySelectorAll('button:not(.login-button)');
        
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                button.style.transform = 'translateY(-1px)';
            });
            
            button.addEventListener('mouseleave', () => {
                button.style.transform = 'translateY(0)';
            });
        });
    }

    addFocusEffects() {
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                input.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', () => {
                input.parentElement.style.transform = 'scale(1)';
            });
        });
    }

    initAnimations() {
        // Stagger animations for form elements
        const formGroups = document.querySelectorAll('.form-group');
        
        formGroups.forEach((group, index) => {
            group.style.opacity = '0';
            group.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                group.style.transition = 'all 0.6s ease';
                group.style.opacity = '1';
                group.style.transform = 'translateY(0)';
            }, index * 100);
        });
    }
}

// Keyboard Navigation
class KeyboardNavigation {
    constructor() {
        this.init();
    }

    init() {
        document.addEventListener('keydown', (e) => {
            // ESC to clear form
            if (e.key === 'Escape') {
                this.clearForm();
            }
            
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                document.getElementById('loginForm').dispatchEvent(new Event('submit'));
            }
            
            // Tab navigation enhancement
            if (e.key === 'Tab') {
                this.handleTabNavigation(e);
            }
        });
    }

    clearForm() {
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('remember').checked = false;
    }

    handleTabNavigation(e) {
        // Enhanced tab navigation for better UX
        const focusableElements = document.querySelectorAll(
            'input, button, [tabindex]:not([tabindex="-1"])'
        );
        
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        if (e.shiftKey && document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
        } else if (!e.shiftKey && document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
        }
    }
}

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ThemeManager();
    new PasswordToggle();
    new LoginForm();
    new UIEffects();
    new KeyboardNavigation();

    // Add some console styling for development
    console.log('%c🦁 Painel Administrativo Lion', 'color: #334155; font-size: 16px; font-weight: bold;');
    console.log('%cSistema de login carregado com sucesso!', 'color: #10b981; font-size: 12px;');
});

// Additional utility functions
const Utils = {
    // Debounce function for performance
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },
    
    // Format date for footer
    formatDate(date) {
        return date.toLocaleDateString('pt-BR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    },
    
    // Validate email format
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
};

// Export for potential module use
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { ThemeManager, PasswordToggle, ToastManager, LoginForm };
}