<?php
include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="card shadow-sm border-0 p-4">
                <div class="card-body p-0">

                    <h3 class="fw-bold text-dark border-bottom pb-3 mb-4">
                        <i class="fa-solid fa-bookmark me-2" style="color: #ffc107;"></i>
                        <?php echo $objeto ? "Editar Reserva" : "Cadastrar Nova Reserva"; ?>
                    </h3>

                    <form action="reservasForm.php" method="post">

                        <input type="hidden" name="id" value="<?php echo isset($objeto->id) ? $objeto->id : ($objeto['id'] ?? ''); ?>">

                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-bold">Usuário / Aluno</label>
                            <select name="usuario_id" class="form-select" required>
                                <option value="">Selecione</option>

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
                            <label class="form-label text-secondary small fw-bold">Livro</label>
                            <select name="livro_id" class="form-select" required>
                                <option value="">Selecione</option>

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

                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Data da Reserva</label>
                            <?php
                            $obj_dt_emp = isset($objeto->data_reserva) ? $objeto->data_reserva : ($objeto['data_reserva'] ?? date('Y-m-d'));
                            ?>
                            <input type="date" name="data_reserva" class="form-control" value="<?php echo $obj_dt_emp; ?>" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn px-4 fw-bold text-dark" style="background-color: #ffc107;">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Salvar
                            </button>
                            <a href="reservasList.php" class="btn btn-outline-secondary px-4 fw-bold">Voltar</a>
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