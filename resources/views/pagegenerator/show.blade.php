<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <!-- Mobile-first: meta responsiva -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- SEO -->
    <title>{{ $page->title }}</title>
    <meta name="description" content="{{ $metaDescription ?? Str::limit(strip_tags($page->content), 160) }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $page->title }}">
    <meta property="og:description" content="{{ $metaDescription ?? Str::limit(strip_tags($page->content), 160) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Nome da Empresa">
    <meta property="og:locale" content="pt_BR">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $page->title }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? Str::limit(strip_tags($page->content), 160) }}">
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Estilos customizados inspirados na identidade visual New Box Info v3 -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            color: #333;
        }
        /* Header e Navbar */
        header {
            background-color: #1a1a1a;
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 600;
        }
        .navbar-nav .nav-link:hover {
            color: #ff4b5c !important;
        }
        /* Hero Section */
        .hero {
            position: relative;
            background: url('{{ asset('images/hero-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }
        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
        }
        .hero .container {
            position: relative;
            z-index: 2;
        }
        /* Botões */
        .btn-primary {
            background-color: #ff4b5c;
            border: none;
        }
        .btn-primary:hover {
            background-color: #e04350;
        }
        /* Seções internas */
        section {
            padding: 60px 0;
        }
        section h2 {
            font-weight: 600;
            margin-bottom: 30px;
        }
        /* Footer */
        footer {
            background-color: #1a1a1a;
            color: #fff;
        }
        footer a {
            color: #fff;
            text-decoration: none;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho com Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg container">
            <a class="navbar-brand" href="#">Nome da Empresa</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#sobre">Sobre</a></li>
                    <li class="nav-item"><a class="nav-link" href="#diferenciais">Diferenciais</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Portfólio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#depoimentos">Depoimentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contato">Contato</a></li>
                </ul>
            </div>
        </nav>
    </header>
    
    <!-- Seção Hero -->
    <section class="hero">
        <div class="container">
            <h1 class="display-4">{{ $page->title }}</h1>
            <p class="lead">{{ $metaDescription ?? Str::limit(strip_tags($page->content), 160) }}</p>
            <a href="#contato" class="btn btn-primary btn-lg mt-3">Solicite um Orçamento</a>
        </div>
    </section>
    
    <!-- Seção Sobre o Serviço -->
    <section id="sobre">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Sobre o Serviço</h2>
                    <p>{!! $page->content !!}</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/sobre-servico.jpg') }}" alt="Sobre o Serviço" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Seção Diferenciais -->
    <section id="diferenciais" class="bg-light">
        <div class="container">
            <h2 class="text-center">Por Que Escolher Nossos Serviços</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4">
                    <i class="fa-solid fa-mobile-screen fa-3x text-primary mb-3"></i>
                    <h4>Mobile First</h4>
                    <p>Sites responsivos que se adaptam a qualquer dispositivo, garantindo uma ótima experiência ao usuário.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fa-solid fa-code fa-3x text-primary mb-3"></i>
                    <h4>SEO Otimizado</h4>
                    <p>Desenvolvimento com as melhores práticas de SEO para melhorar sua visibilidade no Google.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fa-solid fa-thumbs-up fa-3x text-primary mb-3"></i>
                    <h4>Design Personalizado</h4>
                    <p>Layouts modernos e personalizados que reforçam a identidade visual da sua marca.</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Seção Portfólio -->
    <section id="portfolio">
        <div class="container">
            <h2 class="text-center">Portfólio</h2>
            <div class="row">
                <!-- Exemplo de card de portfólio -->
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/portfolio1.jpg') }}" class="card-img-top" alt="Projeto 1">
                        <div class="card-body">
                            <h5 class="card-title">Projeto 1</h5>
                            <p class="card-text">Descrição breve do projeto realizado.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/portfolio2.jpg') }}" class="card-img-top" alt="Projeto 2">
                        <div class="card-body">
                            <h5 class="card-title">Projeto 2</h5>
                            <p class="card-text">Descrição breve do projeto realizado.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('images/portfolio3.jpg') }}" class="card-img-top" alt="Projeto 3">
                        <div class="card-body">
                            <h5 class="card-title">Projeto 3</h5>
                            <p class="card-text">Descrição breve do projeto realizado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Seção Depoimentos -->
    <section id="depoimentos" class="bg-light">
        <div class="container">
            <h2 class="text-center">Depoimentos</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <blockquote class="blockquote">
                        <p>"A qualidade e o atendimento foram excepcionais! Recomendo fortemente."</p>
                        <footer class="blockquote-footer">Cliente Satisfeito</footer>
                    </blockquote>
                </div>
                <div class="col-md-6 mb-4">
                    <blockquote class="blockquote">
                        <p>"O novo site trouxe mais visibilidade e melhores resultados para nossa empresa."</p>
                        <footer class="blockquote-footer">Outro Cliente</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Seção Contato / Call to Action -->
    <section id="contato">
        <div class="container text-center">
            <h2>Pronto para transformar seu negócio?</h2>
            <p>Entre em contato conosco e solicite um orçamento sem compromisso.</p>
            <a href="mailto:contato@empresa.com" class="btn btn-primary btn-lg">Fale Conosco</a>
        </div>
    </section>
    
    <!-- Rodapé -->
    <footer class="py-4">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Nome da Empresa. Todos os direitos reservados.</p>
            <p>
                <a href="#">Política de Privacidade</a> |
                <a href="#">Termos de Uso</a>
            </p>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
