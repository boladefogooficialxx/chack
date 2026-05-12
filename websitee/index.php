<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Imóveis - Encontre o Imóvel dos Seus Sonhos</title>
    <link rel="stylesheet" href="/websitee/elite-imoveis.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Cabeçalho Fixo -->
    <header class="header" id="header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <span class="logo-icon">🏛️</span>
                    <span class="logo-text">Elite Imóveis</span>
                </div>
                <nav class="nav" id="nav">
                    <a href="#inicio" class="nav-link active">Início</a>
                    <a href="#imoveis" class="nav-link">Imóveis</a>
                    <a href="#corretores" class="nav-link">Corretores</a>
                    <a href="#sobre" class="nav-link">Sobre</a>
                    <a href="#contato" class="nav-link">Contato</a>
                </nav>
                <button class="menu-toggle" id="menuToggle" aria-label="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Seção Hero -->
    <section class="hero" id="inicio">
        <div class="hero-overlay"></div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    Encontre o imóvel dos seus <span class="highlight">sonhos</span>
                </h1>
                <p class="hero-subtitle">
                    Com a Elite Imóveis, você tem acesso aos imóveis mais exclusivos e sofisticados do mercado
                </p>
                <a href="#imoveis" class="btn btn-primary">Ver Imóveis</a>
            </div>
        </div>
    </section>

    <!-- Seção de Imóveis em Destaque -->
    <section class="properties" id="imoveis">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Imóveis em Destaque</h2>
                <p class="section-subtitle">Selecionamos os melhores imóveis especialmente para você</p>
            </div>
            <div class="properties-grid">
                <!-- Card 1 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?crop=entropy&cs=srgb&fm=jpg&ixid=M3w3NDQ2NDN8MHwxfHNlYXJjaHwxfHxsdXh1cnklMjByZWFsJTIwZXN0YXRlfGVufDB8fHx8MTc2MTIzOTMyOXww&ixlib=rb-4.1.0&q=85" alt="Vila Moderna com Piscina">
                        <span class="property-badge">Destaque</span>
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Vila Moderna com Piscina</h3>
                        <p class="property-location">📍 Alphaville, São Paulo</p>
                        <p class="property-price">R$ 3.500.000</p>
                        <div class="property-features">
                            <span>🛏️ 5 quartos</span>
                            <span>🚗 4 vagas</span>
                            <span>📐 450m²</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.unsplash.com/photo-1613490493576-7fde63acd811?crop=entropy&cs=srgb&fm=jpg&ixid=M3w3NDQ2NDN8MHwxfHNlYXJjaHwyfHxsdXh1cnklMjByZWFsJTIwZXN0YXRlfGVufDB8fHx8MTc2MTIzOTMyOXww&ixlib=rb-4.1.0&q=85" alt="Casa Contemporânea">
                        <span class="property-badge novo">Novo</span>
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Casa Contemporânea</h3>
                        <p class="property-location">📍 Morumbi, São Paulo</p>
                        <p class="property-price">R$ 2.800.000</p>
                        <div class="property-features">
                            <span>🛏️ 4 quartos</span>
                            <span>🚗 3 vagas</span>
                            <span>📐 380m²</span>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.unsplash.com/photo-1416331108676-a22ccb276e35?crop=entropy&cs=srgb&fm=jpg&ixid=M3w3NDQ2NDN8MHwxfHNlYXJjaHwzfHxsdXh1cnklMjByZWFsJTIwZXN0YXRlfGVufDB8fHx8MTc2MTIzOTMyOXww&ixlib=rb-4.1.0&q=85" alt="Residência de Luxo">
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Residência de Luxo</h3>
                        <p class="property-location">📍 Jardins, São Paulo</p>
                        <p class="property-price">R$ 4.200.000</p>
                        <div class="property-features">
                            <span>🛏️ 6 quartos</span>
                            <span>🚗 5 vagas</span>
                            <span>📐 520m²</span>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?crop=entropy&cs=srgb&fm=jpg&ixid=M3w3NDQ2NDN8MHwxfHNlYXJjaHw0fHxsdXh1cnklMjByZWFsJTIwZXN0YXRlfGVufDB8fHx8MTc2MTIzOTMyOXww&ixlib=rb-4.1.0&q=85" alt="Mansão Moderna">
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Mansão Moderna</h3>
                        <p class="property-location">📍 Granja Viana, Cotia</p>
                        <p class="property-price">R$ 5.500.000</p>
                        <div class="property-features">
                            <span>🛏️ 7 quartos</span>
                            <span>🚗 6 vagas</span>
                            <span>📐 680m²</span>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.pexels.com/photos/1732414/pexels-photo-1732414.jpeg" alt="Cobertura Premium">
                        <span class="property-badge novo">Novo</span>
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Cobertura Premium</h3>
                        <p class="property-location">📍 Itaim Bibi, São Paulo</p>
                        <p class="property-price">R$ 3.900.000</p>
                        <div class="property-features">
                            <span>🛏️ 5 quartos</span>
                            <span>🚗 4 vagas</span>
                            <span>📐 420m²</span>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="property-card">
                    <div class="property-image">
                        <img src="https://images.pexels.com/photos/34378029/pexels-photo-34378029.jpeg" alt="Casa de Alto Padrão">
                    </div>
                    <div class="property-info">
                        <h3 class="property-name">Casa de Alto Padrão</h3>
                        <p class="property-location">📍 Panamby, São Paulo</p>
                        <p class="property-price">R$ 4.800.000</p>
                        <div class="property-features">
                            <span>🛏️ 6 quartos</span>
                            <span>🚗 5 vagas</span>
                            <span>📐 550m²</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção Sobre Nós -->
    <section class="about" id="sobre">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="section-title">Sobre a Elite Imóveis</h2>
                    <p class="about-description">
                        Há mais de 15 anos no mercado imobiliário, a <strong>Elite Imóveis</strong> se consolidou como referência 
                        em imóveis de alto padrão e exclusividade. Nossa missão é conectar pessoas aos imóveis dos seus sonhos, 
                        oferecendo atendimento personalizado e um portfólio selecionado das melhores propriedades.
                    </p>
                    <div class="about-values">
                        <div class="value-item">
                            <div class="value-icon">✨</div>
                            <h3>Excelência</h3>
                            <p>Compromisso com qualidade em cada detalhe</p>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">🤝</div>
                            <h3>Confiança</h3>
                            <p>Transparência e integridade em todas as negociações</p>
                        </div>
                        <div class="value-item">
                            <div class="value-icon">🎯</div>
                            <h3>Profissionalismo</h3>
                            <p>Equipe especializada e altamente qualificada</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Corretores -->
    <section class="brokers" id="corretores">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Nossos Corretores</h2>
                <p class="section-subtitle">Profissionais especializados prontos para te atender</p>
            </div>
            <div class="brokers-grid">
                <!-- Corretor 1 -->
                <div class="broker-card">
                    <div class="broker-image">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a" alt="Carlos Mendes">
                    </div>
                    <h3 class="broker-name">Carlos Mendes</h3>
                    <p class="broker-role">Diretor Comercial</p>
                    <p class="broker-creci">CRECI 12345-F</p>
                    <div class="broker-contact">
                        <a href="tel:+5511999999999" class="broker-phone">📱 (11) 99999-9999</a>
                    </div>
                </div>

                <!-- Corretor 2 -->
                <div class="broker-card">
                    <div class="broker-image">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2" alt="Ana Silva">
                    </div>
                    <h3 class="broker-name">Ana Silva</h3>
                    <p class="broker-role">Gerente de Vendas</p>
                    <p class="broker-creci">CRECI 67890-F</p>
                    <div class="broker-contact">
                        <a href="tel:+5511988888888" class="broker-phone">📱 (11) 98888-8888</a>
                    </div>
                </div>

                <!-- Corretor 3 -->
                <div class="broker-card">
                    <div class="broker-image">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7" alt="Ricardo Santos">
                    </div>
                    <h3 class="broker-name">Ricardo Santos</h3>
                    <p class="broker-role">Consultor Imobiliário</p>
                    <p class="broker-creci">CRECI 11223-F</p>
                    <div class="broker-contact">
                        <a href="tel:+5511977777777" class="broker-phone">📱 (11) 97777-7777</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seção de Contato -->
    <section class="contact" id="contato">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Entre em Contato</h2>
                <p class="section-subtitle">Estamos prontos para encontrar o imóvel perfeito para você</p>
            </div>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <div>
                            <h3>Endereço</h3>
                            <p>Av. Paulista, 1000 - Bela Vista<br>São Paulo, SP - CEP 01310-100</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📞</div>
                        <div>
                            <h3>Telefone</h3>
                            <p>(11) 3000-0000<br>(11) 99000-0000</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">✉️</div>
                        <div>
                            <h3>Email</h3>
                            <p>contato@eliteimoveis.com.br<br>vendas@eliteimoveis.com.br</p>
                        </div>
                    </div>
                </div>
                <form class="contact-form" id="contactForm">
                    <div class="form-group">
                        <input type="text" class="form-input" placeholder="Seu Nome" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-input" placeholder="Seu Email" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" class="form-input" placeholder="Seu Telefone" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-input" rows="5" placeholder="Sua Mensagem" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <div class="footer-logo">
                        <span class="logo-icon">🏛️</span>
                        <span class="logo-text">Elite Imóveis</span>
                    </div>
                    <p class="footer-description">
                        Conectando você ao imóvel dos seus sonhos desde 2009.
                    </p>
                </div>
                <div class="footer-column">
                    <h4>Links Rápidos</h4>
                    <ul class="footer-links">
                        <li><a href="#inicio">Início</a></li>
                        <li><a href="#imoveis">Imóveis</a></li>
                        <li><a href="#corretores">Corretores</a></li>
                        <li><a href="#sobre">Sobre</a></li>
                        <li><a href="#contato">Contato</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Contato</h4>
                    <ul class="footer-links">
                        <li>📱 (11) 3000-0000</li>
                        <li>✉️ contato@eliteimoveis.com.br</li>
                        <li>📍 Av. Paulista, 1000 - SP</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Redes Sociais</h4>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">Facebook</a>
                        <a href="#" class="social-link" aria-label="Instagram">Instagram</a>
                        <a href="#" class="social-link" aria-label="LinkedIn">LinkedIn</a>
                        <a href="#" class="social-link" aria-label="WhatsApp">WhatsApp</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Elite Imóveis. Todos os direitos reservados. CRECI-SP 12345</p>
            </div>
        </div>
    </footer>

    <!-- Botão Voltar ao Topo -->
    <button class="scroll-top" id="scrollTop" aria-label="Voltar ao topo">
        ↑
    </button>

    <script src="/websitee/elite-imoveis.js"></script>
</body>
</html>