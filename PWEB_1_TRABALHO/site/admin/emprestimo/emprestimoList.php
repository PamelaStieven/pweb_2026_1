<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('emprestimo');
$db_usuario = new db('usuario');
$db_livros = new db('livros');

if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    try {
        $db->destroy($_GET['id']);
        echo "<script>window.location.href='../emprestimo/emprestimoList.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}

$dados = $db->all();

if (!empty($_POST) && !empty($_POST['valor'])) {

    $valor_busca = strtolower($_POST['valor']);
    $tipo_busca  = $_POST['tipo'];

    $dados = array_filter($dados, function ($item) use ($db_usuario, $db_livros, $valor_busca, $tipo_busca) {

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
        <i class="fa-solid fa-hand-holding-caption me-2"></i>Gerenciamento de Empréstimos
      </h3>

      <a href="emprestimoForm.php" class="btn btn-success px-4">
        <i class="fa-solid fa-plus me-2"></i>Novo Empréstimo
      </a>

    </div>

    <form action="emprestimoList.php" method="post" class="bg-light p-3 border rounded mb-4 shadow-sm">

      <div class="row g-3 align-items-end">

        <div class="col-md-3">
          <label class="form-label fw-semibold text-secondary small">Buscar por:</label>
          <select name="tipo" class="form-select">
            <option value="usuario_id">Usuário</option>
            <option value="livro_id">Livro</option>
            <option value="data_emprestimo">Data Empréstimo</option>
            <option value="data_devolucao">Data Devolução</option>
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
            <th>Empréstimo</th>
            <th>Devolução</th>
            <th class="text-center">Ações</th>
          </tr>
        </thead>

        <tbody>
        <?php
        if (empty($dados)) {
            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Nenhum empréstimo encontrado.</td></tr>";
        } else {

            foreach ($dados as $item) {

                $id         = isset($item->id) ? $item->id : $item['id'];
                $usuario_id = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
                $livro_id   = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];

                $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];
                $data_devolucao  = isset($item->data_devolucao) ? $item->data_devolucao : $item['data_devolucao'];

                $u = $db_usuario->find($usuario_id);
                $l = $db_livros->find($livro_id);

                $nome_usuario = $u ? $u->nome . " " . $u->sobrenome : "Não encontrado";
                $nome_livro   = $l ? $l->titulo : "Não encontrado";

                $dt_emp = date('d/m/Y', strtotime($data_emprestimo));
                $dt_dev = !empty($data_devolucao)
                    ? date('d/m/Y', strtotime($data_devolucao))
                    : "Pendente";

                echo "
                <tr>
                  <th>{$id}</th>
                  <td>{$nome_usuario}</td>
                  <td>{$nome_livro}</td>
                  <td><span class='badge bg-light text-dark border'>{$dt_emp}</span></td>
                  <td><span class='badge bg-light text-dark border'>{$dt_dev}</span></td>
                  <td class='text-center'>
                    <a class='btn btn-success btn-sm'
                       onclick='return confirm(\"Confirmar devolução?\")'
                       href='../devolucoes/devolucaoList.php?id={$id}&acao=dar_baixa'>
                       Devolver
                    </a>

                    <a class='btn btn-warning btn-sm'
                       href='emprestimoForm.php?id={$id}'>
                       Editar
                    </a>

                    <a class='btn btn-danger btn-sm'
                       onclick='return confirm(\"Excluir registro?\")'
                       href='emprestimoList.php?id={$id}&acao=excluir'>
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