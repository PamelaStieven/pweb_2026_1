<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db = new db('livros');
$objeto = null;

//edicao
if (!empty($_GET['id'])) {
  $objeto = $db->find($_GET['id']);
}

// salva
if (!empty($_POST)) {
  if (!empty($_POST['id'])) {
    $db->update($_POST);
  } else {
    $_POST['id'] = time();
    $db->store($_POST);
  }
  echo "<script>window.location.href='livroList.php';</script>";
  exit;
}
?>

<div class="row">
  <h3><?php echo $objeto ? "Editar Livro" : "Novo Livro"; ?></h3>
  
  <form action="livroForm.php" method="post" class="col-6">
    
    <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

    <div class="mb-3">
      <label class="form-label">Título do Livro</label>
      <input type="text" name="titulo" class="form-control" 
             value="<?php echo isset($objeto->titulo) ? $objeto->titulo : ($objeto['titulo'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Autor</label>
      <input type="text" name="autor" class="form-control" 
             value="<?php echo isset($objeto->autor) ? $objeto->autor : ($objeto['autor'] ?? ''); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Gênero</label>
      <input type="text" name="genero" class="form-control" 
             value="<?php echo isset($objeto->genero) ? $objeto->genero : ($objeto['genero'] ?? ''); ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="livroList.php" class="btn btn-secondary">Voltar</a>
     <div class="mt-3">
                <a href="../index.php" class="btn btn-outline-dark">Voltar ao Painel</a>
            </div>
  </form>
</div>

<?php
include '../footer.php';
?>