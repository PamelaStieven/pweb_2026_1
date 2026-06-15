<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'site/admin/autenticacao.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>ACCIO LIBRARY</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="PWEB_1_TRABALHO/site/admin/css/style.css">
</head>

<body>
<header class="p-3">
  <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
    <div class="container">

      <a class="navbar-brand" href="index.php">
        <img src="IMG/logo.png-removebg-preview.png" alt="Accio Library Logo" height="80" class="d-inline-block align-top">
      </a>

      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav ms-auto mb-0">
          <li class="nav-item">
            <a class="nav-link text-white" href="PWEB_1_TRABALHO/site/admin/index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="TrabalhoBootstrap/PAGINAS/sobre.html">Sobre</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="TrabalhoBootstrap/PAGINAS/diverso.html">Blog</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="TrabalhoBootstrap/PAGINAS/contato.html">Contato</a>
          </li>
        </ul>
      </div>

    </div>
  </nav>
</header>

<main class="container my-4">
  <div class="row">

    <article class="col-md-8">

      <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="IMG/exterior.webp" class="d-block w-100" alt="Exterior">
          </div>
          <div class="carousel-item">
            <img src="IMG/interior_01.webp" class="d-block w-100" alt="Interior 1">
          </div>
          <div class="carousel-item">
            <img src="IMG/interno_02.png" class="d-block w-100" alt="Interior 2">
          </div>
        </div>

        <button class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>

      <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">
        <h1 class="mb-3 text-dark">Sistema da Biblioteca</h1>
        <p class="lead text-secondary">Bem-vindo ao sistema da biblioteca!</p>
        
        <div class="d-flex flex-wrap gap-2 my-4">
          <a href="site/admin/login.php" class="btn btn-primary px-4">Ir para o Login</a>
          <a href="site/admin/registrar.php" class="btn btn-success px-4">Criar Nova Conta</a>
          <a href="site/admin/login.php" class="btn btn-outline-danger px-4">Sair</a>
        </div>
      </div>

      <section class="mb-3 p-3 bg-light border">
        <h2>Bem vindos a Accio Library!</h2>
        <p>Unimos a tradição das grandes bibliotecas clássicas com a tecnologia do mundo moderno. Um refúgio para quem busca silêncio, foco e um vasto acervo físico e digital.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Sobre a nossa biblioteca:</h5>
        <p>Este sistema serve para organizar os livros da nossa escola. Aqui o aluno consegue ver os livros que estão guardados e também pode controlar os dias que pegou emprestado para não esquecer de devolver na data certa.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Nossos Gêneros Disponíveis:</h5>
        <p>Temos um acervo muito rico para ajudar nos seus estudos e também para os momentos de lazer. Você vai encontrar livros de romance, ficção científica, terror, suspense, poesia, biografias, além de uma seção cheia de livros didáticos, gibis e mangás.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Como funciona para pegar e devolver livros:</h5>
        <p>Para ler um livro, o aluno deve fazer a reserva ou o empréstimo direto na nossa bancada. Você pode ficar com o livro por até 7 dias seguidos. Quando esse prazo acabar, é obrigatório trazer o livro de volta para fazer a devolução ou pedir uma renovação se ninguém estiver esperando por ele.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Avisos Importantes sobre Multas:</h5>
        <p>Fique muito atento ao prazo de entrega! Caso você esqueça de devolver o livro na data certa, o sistema vai gerar uma multa automática no valor de R$ 1,00 por cada dia de atraso. O aluno que tiver com alguma multa pendente ou atrasada no sistema não vai conseguir pegar novos livros até ir à secretaria regularizar a situação e pagar o valor.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Nosso ambiente para Estudo:</h5>
        <p>Salas individuais com isolamento acústico e áreas coletivas equipadas com Wi-Fi de alta velocidade. O espaço ideal para seu conhecimento e aprendizado.</p>
      </section>

      <section class="mb-3 p-3 bg-light border">
        <h5>Eventos Culturais:</h5>
        <p>Participe de nossos clubes de leitura mensais, lançamentos de livros e workshops de escrita criativa. Cultura e conhecimento vivos em cada estante.</p>
      </section>

    </article>

    <aside class="col-md-4">
        <div class="p-3 bg-light border mb-4 custom-aside-box">
            <h4 class="fw-bold text-dark border-bottom pb-2">Opiniões de nossos clientes</h4>
            <ul class="list-unstyled mb-0 small">
                <li class="mb-2">"Estudar na Accio é o mais próximo que já cheguei de estar em um filme. O silêncio é absoluto e a verticalidade das estantes realmente traz uma aura de mistério que me ajuda a focar como em nenhum outro lugar."
                  <br><strong>— Lucas Alencar, Escritor.</strong></li>
                <li class="mb-2">"Amo como eles uniram o design clássico com a facilidade digital. O sistema de busca é impecável e as salas de estudo têm uma conectividade que surpreende para um ambiente tão tradicional."
                  <br><strong>— Beatriz Soares, Pesquisadora Acadêmica.</strong></li>
                <li class="mb-2">"Melhor acervo da cidade. O ambiente é inspirador e o atendimento dos bibliotecários é de uma educação rara hoje em dia. Um verdadeiro refúgio para quem ama o conhecimento."
                  <br><strong>— Dr. Ricardo Menezes, Historiador.</strong></li>
                <li class="btn-saiba-mais"><strong>Saiba mais...</strong></li>
            </ul>
        </div>

        <div class="p-3 bg-light border custom-aside-box">
            <h4 class="fw-bold text-dark border-bottom pb-2">Nossa biblioteca nas mídias</h4>
            <ul class="list-unstyled mb-0 small">
                <li class="mb-2"><strong>"O BookTok invadiu a Accio:" </strong>Os 5 cantos mais instagramáveis da nossa biblioteca.</li>
                <li class="mb-2"><strong>Relíquia da Semana:</strong> O manuscrito que acaba de sair do restauro</li>
                <li class="mb-2"><strong>Design Premiado:</strong> A primeira biblioteca a ganhar o selo de arquitetura sustentável mantendo traços do século XIX.</li>
                <li class="btn-saiba-mais"><strong>Saiba mais...</strong></li>
            </ul>
        </div>
    </aside>

  </div>
</main>

<footer class="p-3">
  <div class="container d-flex justify-content-between align-items-center">
    <nav>
      <a class="text-white me-3" href="TrabalhoBootstrap/PAGINAS/contato.html">Trabalhe Conosco</a>
      <a class="text-white" href="TrabalhoBootstrap/PAGINAS/contato.html">Contato</a>
    </nav>
    <div class="text-white">
      Siga-nos:
      <a href="#" class="text-white ms-2"><i class="fab fa-facebook"></i></a>
      <a href="#" class="text-white ms-2"><i class="fa-brands fa-instagram"></i></a>
      <a href="#" class="text-white ms-2"><i class="fa-brands fa-twitter"></i></a>    
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>