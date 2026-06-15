<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db_emprestimo = new db('emprestimo');
$usuarios = (new db('usuario'))->all();
$livros = (new db('livros'))->all();
$objeto = null;

if (!empty($_GET['id'])) {
  $objeto = $db_emprestimo->find($_GET['id']);
}

if (!empty($_POST)) {
  if (!empty($_POST['id'])) {
   
    $db_emprestimo->update($_POST);
  } else {
   
    $_POST['id'] = time();
    $db_emprestimo->store($_POST);
  }
  echo "<script>window.location.href='devolucaoList.php';</script>";
  exit;
}
?>
<div class="row">
  <h3> Registrar / Editar Devolução Manual</h3>
  
  <form action="devolucaoForm.php" method="post" class="col-6 mt-3">
    <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

    <div class="mb-3">
      <label class="form-label">Usuário / Aluno</label>
      <select name="usuario_id" class="form-select" required>
        <option value=""> Selecione </option>
        <?php foreach ($usuarios as $u): 
          $u_id   = isset($u->id) ? $u->id : $u['id'];
          $u_nome = isset($u->nome) ? $u->nome : $u['nome'];
          $u_sobrenome = isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'];
          $obj_u_id = isset($objeto->usuario_id) ? $objeto->usuario_id : ($objeto['usuario_id'] ?? '');
        ?>
          <option value="<?php echo $u_id; ?>" <?php echo ($obj_u_id == $u_id) ? 'selected' : ''; ?>>
            <?php echo "$u_nome $u_sobrenome"; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Livro Entregue</label>
      <select name="livro_id" class="form-select" required>
        <option value=""> Selecione </option>
        <?php foreach ($livros as $l): 
          $l_id = isset($l->id) ? $l->id : $l['id'];
          $l_titulo = isset($l->titulo) ? $l->titulo : $l['titulo'];
          $obj_l_id = isset($objeto->livro_id) ? $objeto->livro_id : ($objeto['livro_id'] ?? '');
        ?>
          <option value="<?php echo $l_id; ?>" <?php echo ($obj_l_id == $l_id) ? 'selected' : ''; ?>>
            <?php echo $l_titulo; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Data de Retirada (Material Pego em)</label>
      <?php $obj_dt_emp = isset($objeto->data_emprestimo) ? $objeto->data_emprestimo : ($objeto['data_emprestimo'] ?? date('Y-m-d')); ?>
      <input type="date" name="data_emprestimo" class="form-control" value="<?php echo $obj_dt_emp; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Data de Devolução Real (Entregue em)</label>
      <?php $obj_dt_dev = isset($objeto->data_devolucao) ? $objeto->data_devolucao : ($objeto['data_devolucao'] ?? date('Y-m-d')); ?>
      <input type="date" name="data_devolucao" class="form-control" value="<?php echo $obj_dt_dev; ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar Devolução</button>
    <a href="devolucaoList.php" class="btn btn-secondary">Voltar para a Lista</a>
  </form>
</div>
<?php include '../footer.php'; ?>