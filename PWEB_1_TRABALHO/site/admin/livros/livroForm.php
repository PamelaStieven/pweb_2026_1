<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('livros');
$objeto = null;

if (!empty($_GET['id'])) {
  $objeto = $db->find($_GET['id']);
}

if (!empty($_POST)) {
  if (!empty($_POST['id'])) {
    $db->update($_POST);
  } else {
    $_POST['id'] = time();
    $db->store($_POST);
  }
  echo "<script>window.location.href='../livros/livroList.php';</script>";
  exit;
}
?>

<div class="row my-4 justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="p-4 bg-white border rounded shadow-sm custom-card">
      <h3 class="fw-bold text-dark border-bottom pb-2 mb-4">
        <i class="fa-solid fa-book me-2"></i><?php echo $objeto ? "Editar Livro" : "Cadastrar Novo Livro"; ?>
      </h3>
      
      <form action="livroForm.php" method="post">
        <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Título do Livro</label>
          <input type="text" name="titulo" class="form-control" 
                 value="<?php echo isset($objeto->titulo) ? $objeto->titulo : ($objeto['titulo'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold text-secondary">Autor</label>
          <input type="text" name="autor" class="form-control" 
                 value="<?php echo isset($objeto->autor) ? $objeto->autor : ($objeto['autor'] ?? ''); ?>" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold text-secondary">Gênero</label>
          <input type="text" name="genero" class="form-control" 
                 value="<?php echo isset($objeto->genero) ? $objeto->genero : ($objeto['genero'] ?? ''); ?>" required>
        </div>

        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-success px-4">
            <i class="fa-solid fa-floppy-disk me-2"></i>Salvar
          </button>
          <a href="livroList.php" class="btn btn-secondary px-4">Voltar</a>
        </div>
      </form>
    </div>

    <div class="mt-3 text-center">
      <a href="../index.php" class="btn btn-outline-dark bg-white">
        <i class="fa-solid fa-house me-2"></i>Voltar ao Painel Principal
      </a>
    </div>
  </div>
</div>

<?php
include '../footer.php';
?>