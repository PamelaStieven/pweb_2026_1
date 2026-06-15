<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('livros');
$dados = [];

if (!empty($_GET['id'])) {
    try {
        $db->destroy($_GET['id']);
        echo "<script>window.location.href='../livros/livroList.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<div class='alert alert-danger shadow-sm'>Erro ao deletar: " . $e->getMessage() . "</div>";
    }
}

if (!empty($_POST) && !empty($_POST['valor'])) {
    $dados = $db->all();
    $valor_busca = strtolower($_POST['valor']);
    $tipo_busca = $_POST['tipo'];
    
    $dados = array_filter($dados, function($item) use ($valor_busca, $tipo_busca) {
        $campo_valor = isset($item->$tipo_busca) ? $item->$tipo_busca : ($item[$tipo_busca] ?? '');
        return strpos(strtolower($campo_valor), $valor_busca) !== false;
    });
} else {
    $dados = $db->all();
}
?>

<style>
  .custom-card h3, 
  .custom-card h3 i, 
  h3.text-dark {
    color: #ffc107 !important;
  }

  .table-responsive .table thead.table-dark,
  .table-responsive .table thead.table-dark th {
    background-color: #ffc107 !important;
    background: #ffc107 !important;
    color: #000000 !important;
    font-weight: bold !important;
    border-bottom: 2px solid #e0a800 !important;
  }
</style>

<div class="container py-4">

  <?php if (!empty($dados)): ?>
  <div class="row mb-4 justify-content-center">
    <div class="col-md-8">
      <div id="carrosselLivros" class="carousel slide border rounded shadow-sm bg-dark" data-bs-ride="carousel">
        
        <div class="carousel-indicators">
          <?php 
          $controle = 0;
          foreach ($dados as $item) {
              $active = ($controle === 0) ? 'class="active" aria-current="true"' : '';
              echo '<button type="button" data-bs-target="#carrosselLivros" data-bs-slide-to="' . $controle . '" ' . $active . ' aria-label="Slide ' . ($controle + 1) . '"></button>';
              $controle++;
          }
          ?>
        </div>

        <div class="carousel-inner" style="height: 350px;">
          <?php 
          $isFirst = true;
          foreach ($dados as $item) {
              $activeClass = $isFirst ? 'active' : '';
              $isFirst = false;

              $titulo = isset($item->titulo) ? $item->titulo : $item['titulo'];
              $autor  = isset($item->autor) ? $item->autor : $item['autor'];
              $genero = isset($item->genero) ? $item->genero : $item['genero'];
              $imagem = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0fPRI-8I3AkjCvzaizhqUbu8W_VG93eHax83Cf1qixw&s=10"; 
              $imagem_2 = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTso_fd8UFytI69O1s7HnaQ1UgORXPMxc2HQHMdDnNGXg&s=10";
          ?>
            <div class="carousel-item <?php echo $activeClass; ?> h-100">
              <img src="<?php echo $imagem; ?>" class="d-block h-100 mx-auto" alt="<?php echo $titulo; ?>" style="object-fit: contain; opacity: 0.8;">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-75 rounded p-2">
                <h5><?php echo $titulo; ?></h5>
                <p><?php echo $autor; ?> | <span class="badge bg-warning text-dark"><?php echo $genero; ?></span></p>
              </div>
            </div>
          <?php } ?>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carrosselLivros" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carrosselLivros" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Próximo</span>
        </button>

      </div>
    </div>
  </div>
  <?php endif; ?>

  <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">
    
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
      <h3 class="fw-bold text-dark m-0">
        <i class="fa-solid fa-bookmark me-2"></i>Listagem de Livros
      </h3>
      <a href="livroForm.php" class="btn btn-success px-4">
        <i class="fa-solid fa-plus me-2"></i>Novo Livro
      </a>
    </div>

    <form action="livroList.php" method="post" class="bg-light p-3 border rounded mb-4 shadow-sm">
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <label for="tipo" class="form-label fw-semibold text-secondary small">Buscar por:</label>
          <select name="tipo" class="form-select">
            <option value="titulo">Título</option>
            <option value="autor">Autor</option>
            <option value="genero">Gênero</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="valor" class="form-label fw-semibold text-secondary small">Termo de Pesquisa:</label>
          <input type="text" name="valor" placeholder="O que você procura?..." class="form-control">
        </div>
        <div class="col-md-3 d-grid">
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-magnifying-glass me-2"></i>Buscar
          </button>
        </div>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle border mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 8%;"># ID</th>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Gênero</th>
            <th scope="col" class="text-center" style="width: 12%;">Editar</th>
            <th scope="col" class="text-center" style="width: 12%;">Excluir</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (empty($dados)) {
              echo "<tr><td colspan='6' align='center' class='text-muted py-4'>📚 Nenhum livro encontrado ou cadastrado no momento.</td></tr>";
          } else {
              foreach ($dados as $item) {
                  $id     = isset($item->id) ? $item->id : $item['id'];
                  $titulo = isset($item->titulo) ? $item->titulo : $item['titulo'];
                  $autor  = isset($item->autor) ? $item->autor : $item['autor'];
                  $genero = isset($item->genero) ? $item->genero : $item['genero'];

                  echo "<tr>
                        <th scope='row' class='text-secondary'>{$id}</th>
                        <td class='fw-bold text-dark'>{$titulo}</td>
                        <td>{$autor}</td>
                        <td><span class='badge bg-secondary px-2 py-1'>{$genero}</span></td>
                        <td class='text-center'>
                          <a class='btn btn-warning btn-sm shadow-sm text-dark fw-bold' href='livroForm.php?id={$id}'>
                            <i class='fa-solid fa-pen-to-square me-1'></i>Editar
                          </a>
                        </td>
                        <td class='text-center'>
                          <a class='btn btn-danger btn-sm shadow-sm' onclick='return confirm(\"Deseja realmente excluir este livro do acervo?\")' href='livroList.php?id={$id}'>
                            <i class='fa-solid fa-trash me-1'></i>Deletar
                          </a>
                        </td>
                     </tr>";
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="mb-4">
    <a href="../index.php" class="btn btn-outline-dark bg-white">
      <i class="fa-solid fa-house me-2"></i>Voltar ao Painel Principal
    </a>
  </div>

</div>

<?php
include '../footer.php';
?>