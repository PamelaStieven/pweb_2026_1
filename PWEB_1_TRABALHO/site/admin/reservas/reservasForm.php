<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db = new db('reservas'); 

$usuarios = (new db('usuario'))->all();
$livros = (new db('livros'))->all();
$objeto = null;

if (!empty($_GET['id'])) {
  $objeto = $db->find($_GET['id']);
}

if (!empty($_POST)) {
  if (!empty($_POST['id'])) {
    $db->update($_POST);
  } else {
    unset($_POST['id']);
    $db->store($_POST);
  }
  echo "<script>window.location.href='reservasList.php';</script>";
  exit;
}
?>

<div class="row">
  <h3><?php echo $objeto ? "Editar Reserva" : "Nova Reserva"; ?></h3>
  
  <form action="reservasForm.php" method="post" class="col-6">
    
    <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

    <div class="mb-3">
      <label class="form-label">Usuário / Aluno</label>
      <select name="usuario_id" class="form-select" required>
        <option value=""> Selecione </option>

        <?php foreach ($usuarios as $u): 
          $u_id = isset($u->id) ? $u->id : $u['id'];
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
      <label class="form-label">Livro</label>
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
      <label class="form-label">Data da reserva</label>
      <?php 
        $obj_dt_emp = isset($objeto->data_reserva) ? $objeto->data_reserva : ($objeto['data_reserva'] ?? date('Y-m-d')); 
      ?>
      <input type="date" name="data_reserva" class="form-control" value="<?php echo $obj_dt_emp; ?>" required>
    </div>

    <button type="submit" class="btn btn-success">Salvar</button>
    <a href="reservasList.php" class="btn btn-secondary">Voltar</a>

  </form>
</div>

<?php include '../footer.php'; ?>