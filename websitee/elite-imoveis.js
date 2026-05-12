// ===== NAVEGAÇÃO SMOOTH SCROLL =====
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerOffset = 80;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
            
            // Fecha o menu mobile após o clique
            const nav = document.getElementById('nav');
            const menuToggle = document.getElementById('menuToggle');
            nav.classList.remove('active');
            menuToggle.classList.remove('active');
        }
    });
});

// ===== MENU MOBILE TOGGLE =====
const menuToggle = document.getElementById('menuToggle');
const nav = document.getElementById('nav');

menuToggle.addEventListener('click', () => {
    menuToggle.classList.toggle('active');
    nav.classList.toggle('active');
});

// ===== HEADER SCROLL EFFECT =====
const header = document.getElementById('header');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    // Adiciona classe 'scrolled' quando rolar
    if (currentScroll > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
    
    lastScroll = currentScroll;
});

// ===== ATIVAR LINK DA NAVEGAÇÃO BASEADO NA SEÇÃO =====
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav-link');

function activateNavLink() {
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');
        
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${sectionId}`) {
                    link.classList.add('active');
                }
            });
        }
    });
}

window.addEventListener('scroll', activateNavLink);

// ===== BOTÃO VOLTAR AO TOPO =====
const scrollTopBtn = document.getElementById('scrollTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        scrollTopBtn.classList.add('visible');
    } else {
        scrollTopBtn.classList.remove('visible');
    }
});

scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// ===== ANIMAÇÃO DE ENTRADA DOS ELEMENTOS =====
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observar cards de imóveis
const propertyCards = document.querySelectorAll('.property-card');
propertyCards.forEach(card => {
    card.style.opacity = '0';
    observer.observe(card);
});

// Observar cards de corretores
const brokerCards = document.querySelectorAll('.broker-card');
brokerCards.forEach(card => {
    card.style.opacity = '0';
    observer.observe(card);
});

// Observar items de valores
const valueItems = document.querySelectorAll('.value-item');
valueItems.forEach(item => {
    item.style.opacity = '0';
    observer.observe(item);
});

// ===== FORMULÁRIO DE CONTATO =====
const contactForm = document.getElementById('contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Simula envio do formulário
    const formData = new FormData(contactForm);
    
    // Aqui você poderia adicionar integração com backend
    // Por enquanto, apenas mostra mensagem de sucesso
    
    // Feedback visual
    const submitBtn = contactForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Enviando...';
    submitBtn.disabled = true;
    
    setTimeout(() => {
        submitBtn.textContent = '✓ Mensagem Enviada!';
        submitBtn.style.background = 'linear-gradient(135deg, #4CAF50, #2E7D32)';
        
        // Limpa o formulário
        contactForm.reset();
        
        // Restaura o botão após 3 segundos
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
            submitBtn.style.background = '';
        }, 3000);
    }, 1500);
});

// ===== EFEITO PARALLAX NO HERO =====
const hero = document.querySelector('.hero');

window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxSpeed = 0.5;
    
    if (hero) {
        hero.style.backgroundPositionY = `${scrolled * parallaxSpeed}px`;
    }
});

// ===== HOVER EFFECT NOS CARDS DE IMÓVEIS =====
propertyCards.forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.zIndex = '10';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.zIndex = '1';
    });
});

// ===== LOG DE INICIALIZAÇÃO =====
console.log('%c✨ Elite Imóveis Website Carregado! ✨', 'color: #d4af37; font-size: 16px; font-weight: bold;');
console.log('%cDesenvolvido com HTML, CSS e JavaScript puro', 'color: #666; font-size: 12px;');