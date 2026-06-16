<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: login.php");
    exit();
}

include 'header.php';
include_once 'db.class.php'; 

// Dados do Carrossel de Gêneros
$generos = [
    ['nome' => 'Ficção', 'icon' => 'fa-book-open', 'cor' => '#ffc107'],
    ['nome' => 'Fantasia', 'icon' => 'fa-wand-magic-sparkles', 'cor' => '#6c757d'],
    ['nome' => 'Técnico/Educação', 'icon' => 'fa-graduation-cap', 'cor' => '#0d6efd'],
    ['nome' => 'Biografia', 'icon' => 'fa-user-pen', 'cor' => '#dc3545'],
    ['nome' => 'Infantil', 'icon' => 'fa-child', 'cor' => '#20c997']
];

// Dados da Estrutura Física
$fotos_estrutura = [
    ['arquivo' => 'exterior.webp', 'titulo' => 'Fachada Principal'],
    ['arquivo' => 'interior_01.webp', 'titulo' => 'Área de Leitura'],
    ['arquivo' => 'interno_02.png', 'titulo' => 'Setor de Acervo']
];
?>

<div class="container-fluid p-0 bg-light" style="min-height: 100vh;">
  <div class="row g-0">
    
    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 d-flex flex-column p-3 bg-white border-end" style="min-height: 100vh;">
      <a href="#" class="d-flex align-items-center mb-4 me-md-auto text-decoration-none">
        <i class="fa-solid fa-book-bookmark me-2" style="color: #ffc107;"></i>
        <span class="fs-5 fw-bold text-dark" style="letter-spacing: 1px;">ACCIO LIBRARY</span>
      </a>
      <hr class="text-secondary">
      
      <ul class="nav nav-pills flex-column mb-auto gap-2">
        <li class="nav-item">
          <a href="#" class="nav-link active py-2.5 px-3 rounded text-dark fw-bold" style="background-color: #ffc107;">
            <i class="fa-solid fa-chart-pie me-2"></i> Pagina Inicial
          </a>
        </li>
        <li><a href="usuario/usuarioList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-users me-2" style="color: #ffc107;"></i> Leitores</a></li>
        <li><a href="livros/livroList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-book-open me-2" style="color: #ffc107;"></i> Acervo</a></li>
        <li><a href="emprestimo/emprestimoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-business-time me-2" style="color: #ffc107;"></i> Empréstimos</a></li>
        <li><a href="devolucoes/devolucaoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-clipboard-check me-2" style="color: #ffc107;"></i> Devoluções</a></li>
        <li><a href="multas/multasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-receipt me-2" style="color: #ffc107;"></i> Multas</a></li>
        <li><a href="reservas/reservasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar"><i class="fa-solid fa-calendar-days me-2" style="color: #ffc107;"></i> Reservas</a></li>
      </ul>
      
      <hr class="text-secondary">
      <div class="d-flex flex-column gap-2">
        <a href="../../index.php" class="btn btn-sm btn-outline-dark w-100"><i class="fa-solid fa-globe me-2"></i>Ver Site</a>
        <a href="./login.php" class="btn btn-sm btn-outline-danger w-100"><i class="fa-solid fa-right-from-bracket me-2"></i>Sair do Painel</a>
      </div>
    </div>

    <!-- Conteúdo Principal -->
    <div class="col-md-9 col-lg-10 p-4 p-md-5 bg-white">
      
      <!-- Seção 1: Gêneros -->
      <div class="mb-5 border-bottom pb-4">
        <h1 class="fw-bold text-dark m-0 h2">Gêneros em Destaque</h1>
        <span class="text-muted small">Gerencie as categorias de livros do seu acervo</span>
      </div>

      <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
          <div id="carrosselGeneros" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php foreach ($generos as $index => $item): ?>
                <div class="carousel-item <?php echo ($index === 0) ? 'active' : ''; ?>">
                  <div class="card border-0 shadow-lg p-5 text-center mx-auto" style="border-top: 10px solid <?php echo $item['cor']; ?>; min-height: 400px;">
                    <div class="card-body d-flex flex-column justify-content-center">
                      <i class="fa-solid <?php echo $item['icon']; ?> fa-5x mb-4" style="color: <?php echo $item['cor']; ?>;"></i>
                      <h2 class="fw-bold text-dark display-6"><?php echo $item['nome']; ?></h2>
                      <p class="text-muted lead mt-2">Gerencie todos os livros desta categoria.</p>
                      <a href="livros/livroList.php?genero=<?php echo $item['nome']; ?>" class="btn btn-lg text-white mt-4 shadow-sm align-self-center px-5" style="background-color: <?php echo $item['cor']; ?>;">Acessar Acervo</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carrosselGeneros" data-bs-slide="prev">
              <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carrosselGeneros" data-bs-slide="next">
              <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
            </button>
          </div>
        </div>
      </div>

      <!-- Seção 2: Estrutura Física -->
      <div class="pt-4 border-top">
        <h3 class="fw-bold text-dark mb-4"><i class="fa-solid fa-building me-2" style="color: #ffc107;"></i>Estrutura Física</h3>
        <div class="row g-4">
          <?php foreach ($fotos_estrutura as $foto): ?>
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <img src="IMG/<?php echo $foto['arquivo']; ?>" class="card-img-top" alt="Estrutura" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                  <h6 class="card-title fw-bold text-dark mb-0"><?php echo $foto['titulo']; ?></h6>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>