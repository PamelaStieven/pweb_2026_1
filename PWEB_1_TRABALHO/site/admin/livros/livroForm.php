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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <!-- Card Principal -->
            <div class="card shadow-sm border-0 p-4">
                <div class="card-body p-0">
                    <h3 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa-solid fa-book me-2" style="color: #ffc107;"></i>
                        <?php echo $objeto ? "Editar Livro" : "Cadastrar Novo Livro"; ?>
                    </h3>
                    
                    <form action="livroForm.php" method="post">
                        <!-- ID Oculto -->
                        <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Título do Livro</label>
                            <input type="text" name="titulo" class="form-control" 
                                   value="<?php echo isset($objeto->titulo) ? $objeto->titulo : ($objeto['titulo'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Autor</label>
                            <input type="text" name="autor" class="form-control" 
                                   value="<?php echo isset($objeto->autor) ? $objeto->autor : ($objeto['autor'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Gênero</label>
                            <input type="text" name="genero" class="form-control" 
                                   value="<?php echo isset($objeto->genero) ? $objeto->genero : ($objeto['genero'] ?? ''); ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn px-4 fw-bold text-dark" style="background-color: #ffc107;">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Salvar
                            </button>
                            <a href="livroList.php" class="btn btn-outline-secondary px-4 fw-bold">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="../index.php" class="text-decoration-none text-muted small">
                    <i class="fa-solid fa-house me-2"></i>Voltar ao Painel Principal
                </a>
            </div>

        </div>
    </div>
</div>

<?php include '../footer.php'; ?>