<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('reservas');
$db_usuario = new db('usuario');
$db_livros = new db('livros');

if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $db->destroy($_GET['id']);
    echo "<script>window.location.href='reservasList.php';</script>";
    exit;
}


$dados = $db->all();

if (!empty($_POST) && !empty($_POST['valor'])) {

    $valor_busca = strtolower($_POST['valor']);
    $tipo_busca  = $_POST['tipo'];

    $dados = array_filter($dados, function($item) use ($db_usuario, $db_livros, $valor_busca, $tipo_busca) {

        $valor = isset($item->$tipo_busca) ? $item->$tipo_busca : ($item[$tipo_busca] ?? '');

        if ($tipo_busca == 'usuario_id') {
            $u = $db_usuario->find($valor);
            $valor = $u ? ($u->nome . " " . $u->sobrenome) : '';
        }

       
        if ($tipo_busca == 'livro_id') {
            $l = $db_livros->find($valor);
            $valor = $l ? $l->titulo : '';
        }

        return strpos(strtolower($valor), $valor_busca) !== false;
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
    color: #000 !important;
    font-weight: bold !important;
  }
</style>

<div class="container py-4">

  <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">

    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">

      <h3 class="fw-bold text-dark m-0">
        <i class="fa-solid fa-calendar-days me-2"></i>Lista de Reservas
      </h3>

      <a href="reservasForm.php" class="btn btn-success px-4">
        <i class="fa-solid fa-plus me-2"></i>Nova Reserva
      </a>

    </div>

    <form action="reservasList.php" method="post" class="bg-light p-3 border rounded mb-4 shadow-sm">

      <div class="row g-3 align-items-end">

        <div class="col-md-3">
          <label class="form-label fw-semibold text-secondary small">Buscar por:</label>
          <select name="tipo" class="form-select">
            <option value="usuario_id">Usuário</option>
            <option value="livro_id">Livro</option>
            <option value="data_reserva">Data Reserva</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold text-secondary small">Termo de Pesquisa:</label>
          <input type="text" name="valor" class="form-control" placeholder="O que você procura?">
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
            <th># ID</th>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Data Reserva</th>
            <th>Status</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>

        <tbody>
        <?php
        if (empty($dados)) {
            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Nenhuma reserva encontrada.</td></tr>";
        } else {

            foreach ($dados as $item) {

                $usuario_id = $item->usuario_id ?? $item['usuario_id'];
                $livro_id   = $item->livro_id ?? $item['livro_id'];

                $u = $db_usuario->find($usuario_id);
                $l = $db_livros->find($livro_id);

                $nome_usuario = $u ? $u->nome . " " . $u->sobrenome : "Não encontrado";
                $nome_livro   = $l ? $l->titulo : "Não encontrado";

                $dt_res = date('d/m/Y', strtotime($item->data_reserva));

                echo "
                <tr>
                  <th>{$item->id}</th>
                  <td>{$nome_usuario}</td>
                  <td>{$nome_livro}</td>
                  <td>{$dt_res}</td>
                  <td class='text-center'>
                    <a class='btn btn-warning btn-sm'
                       href='reservasForm.php?id={$item->id}'>
                       Editar
                    </a>

                    <a class='btn btn-danger btn-sm'
                       onclick='return confirm(\"Excluir reserva?\")'
                       href='reservasList.php?id={$item->id}&acao=excluir'>
                       Excluir
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

  <a href="../index.php" class="btn btn-outline-dark">
    Voltar ao Painel
  </a>

</div>

<?php include '../footer.php'; ?>