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

$livros = (new db('livros'))->all();
?>

<div class="container-fluid p-0 bg-light" style="min-height: 100vh;">
  <div class="row g-0">
    
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
        <li>
          <a href="usuario/usuarioList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-users me-2" style="color: #ffc107;"></i> Leitores
          </a>
        </li>
        <li>
          <a href="livros/livroList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-book-open me-2" style="color: #ffc107;"></i> Acervo
          </a>
        </li>
        <li>
          <a href="emprestimo/emprestimoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-business-time me-2" style="color: #ffc107;"></i> Empréstimos
          </a>
        </li>
        <li>
          <a href="devolucoes/devolucaoList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-clipboard-check me-2" style="color: #ffc107;"></i> Devoluções
          </a>
        </li>
        <li>
          <a href="multas/multasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-receipt me-2" style="color: #ffc107;"></i> Multas
          </a>
        </li>
        <li>
          <a href="reservas/reservasList.php" class="nav-link py-2.5 px-3 rounded text-dark hover-sidebar">
            <i class="fa-solid fa-calendar-days me-2" style="color: #ffc107;"></i> Reservas
          </a>
        </li>
      </ul>
      
      <hr class="text-secondary">
      <div class="d-flex flex-column gap-2">
        <a href="../../index.php" class="btn btn-sm btn-outline-dark w-100">
          <i class="fa-solid fa-globe me-2"></i>Ver Site
        </a>
        <a href="./login.php" class="btn btn-sm btn-outline-danger w-100">
          <i class="fa-solid fa-right-from-bracket me-2"></i>Sair do Painel
        </a>
      </div>
    </div>

    <div class="col-md-9 col-lg-10 p-4 p-md-5 bg-white">
      
      <div class="mb-5 border-bottom pb-3">
        <h1 class="fw-bold text-dark m-0 h2">Painel de Controle</h1>
        <span class="text-muted small">Gestão interna e monitoramento do acervo bibliotecário</span>
      </div>

      <?php if (!empty($livros)): ?>
      <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
          <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-bookmark me-2" style="color: #ffc107;"></i>Destaques do Acervo Literário</h5>
          <div id="carrosselAdmin" class="carousel slide border rounded shadow-sm bg-dark" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <?php 
              $i = 0;
              foreach ($livros as $l) {
                  $act = ($i === 0) ? 'class="active" aria-current="true"' : '';
                  echo '<button type="button" data-bs-target="#carrosselAdmin" data-bs-slide-to="'.$i.'" '.$act.'></button>';
                  $i++;
              }
              ?>
            </div>
            <div class="carousel-inner">
              <?php 
              $first = true;
              foreach ($livros as $l) {
                  $actClass = $first ? 'active' : '';
                  $first = false;
                  $titulo = isset($l->titulo) ? $l->titulo : $l['titulo'];
                  $autor  = isset($l->autor) ? $l->autor : $l['autor'];
                  $nome_img = isset($l->imagem) ? $l->imagem : ($l['imagem'] ?? '');
                  $imagem = (!empty($nome_img) && file_exists("../IMG/".$nome_img)) ? "../IMG/".$nome_img : "../IMG/capa_padrao.png";
              ?>
                <div class="carousel-item <?php echo $actClass; ?>">
                  <img src="<?php echo $imagem; ?>" class="d-block mx-auto py-2" alt="<?php echo $titulo; ?>">
                  <div class="carousel-caption bg-black bg-opacity-75 rounded p-2">
                    <h5 style="color: #ffc107;"><?php echo $titulo; ?></h5>
                    <p class="m-0 small text-white">Autor: <?php echo $autor; ?></p>
                  </div>
                </div>
              <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carrosselAdmin" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carrosselAdmin" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3">
          <div class="p-4 rounded-3 border bg-white d-flex align-items-center justify-content-between shadow-sm card-stat">
            <div>
              <span class="text-muted d-block small mb-1 fw-bold">TOTAL DE TÍTULOS</span>
              <h3 class="fw-bold m-0 text-dark">Acervo</h3>
            </div>
            <div class="p-3 rounded-3 bg-light" style="color: #ffc107;">
              <i class="fa-solid fa-book fa-xl"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="p-4 rounded-3 border bg-white d-flex align-items-center justify-content-between shadow-sm card-stat">
            <div>
              <span class="text-muted d-block small mb-1 fw-bold">RETIRADAS</span>
              <h3 class="fw-bold m-0 text-dark">Empréstimos</h3>
            </div>
            <div class="p-3 rounded-3 bg-light" style="color: #ffc107;">
              <i class="fa-solid fa-clock-history fa-xl"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="p-4 rounded-3 border bg-white d-flex align-items-center justify-content-between shadow-sm card-stat">
            <div>
              <span class="text-muted d-block small mb-1 fw-bold">LISTA DE ESPERA</span>
              <h3 class="fw-bold m-0 text-dark">Reservas</h3>
            </div>
            <div class="p-3 rounded-3 bg-light" style="color: #ffc107;">
              <i class="fa-solid fa-hourglass-half fa-xl"></i>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-xl-3">
          <div class="p-4 rounded-3 border bg-white d-flex align-items-center justify-content-between shadow-sm card-stat">
            <div>
              <span class="text-muted d-block small mb-1 fw-bold">PENDÊNCIAS</span>
              <h3 class="fw-bold m-0 text-dark">Multas</h3>
            </div>
            <div class="p-3 rounded-3 bg-light" style="color: #ffc107;">
              <i class="fa-solid fa-triangle-exclamation fa-xl"></i>
            </div>
          </div>
        </div>
      </div>

      <h5 class="fw-bold text-dark mb-4">Ações Rápidas</h5>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="p-4 rounded-3 h-100 border bg-white card-action">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-plus-circle me-2" style="color: #ffc107;"></i>Conceder Empréstimo</h5>
            <p class="text-muted small">Efetue a saída rápida de um livro associando o leitor ao exemplar físico disponível.</p>
            <a href="emprestimo/emprestimoForm.php" class="btn btn-sm mt-2 px-4 text-dark fw-bold" style="background-color: #ffc107;">Iniciar Saída</a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="p-4 rounded-3 h-100 border bg-white card-action">
            <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-book-medical me-2" style="color: #ffc107;"></i>Catalogar Novo Livro</h5>
            <p class="text-muted small">Adicione um novo livro ao catálogo da biblioteca de forma instantânea sem burocracia.</p>
            <a href="livros/livroForm.php" class="btn btn-sm mt-2 px-4 text-dark fw-bold" style="background-color: #ffc107;">Inserir no Acervo</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<?php
include 'footer.php';
?>