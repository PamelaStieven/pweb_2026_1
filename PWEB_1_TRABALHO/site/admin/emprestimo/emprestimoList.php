<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db = new db('emprestimo');
$db_usuario = new db('usuario');
$db_livros = new db('livros');
$dados = [];

if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $db->destroy($_GET['id']);
    echo "<script>window.location.href='../emprestimos/emprestimoList.php';</script>";
    exit;
}

$dados = $db->all();
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

  <div class="p-4 mb-4 bg-white border rounded shadow-sm custom-card">
    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
      <h3 class="fw-bold text-dark m-0">
        <i class="fa-solid fa-hand-holding-caption me-2"></i>Gerenciamento de Empréstimos
      </h3>
      <a href="emprestimoForm.php" class="btn btn-success px-4">
        <i class="fa-solid fa-plus me-2"></i>Novo Empréstimo
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle border mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 8%;"># ID</th>
            <th scope="col">Usuário / Aluno</th>
            <th scope="col">Livro</th>
            <th scope="col">Data Empréstimo</th>
            <th scope="col">Data Devolução</th>
            <th scope="col" class="text-center" style="width: 25%;">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (empty($dados)) {
              echo "<tr><td colspan='6' align='center' class='text-muted py-4'>📋 Nenhum empréstimo registrado no momento.</td></tr>";
          } else {
              foreach ($dados as $item) {
                  $id              = isset($item->id) ? $item->id : $item['id'];
                  $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
                  $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
                  $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];
                  $data_devolucao  = isset($item->data_devolucao) ? $item->data_devolucao : $item['data_devolucao'];

                  $u = $db_usuario->find($usuario_id);
                  $l = $db_livros->find($livro_id);
                  
                  $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
                  $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";
                  
                  $dt_emp = date('d/m/Y', strtotime($data_emprestimo));
                  $dt_dev = !empty($data_devolucao) ? date('d/m/Y', strtotime($data_devolucao)) : "Pendente";

                  echo "<tr>
                        <th scope='row' class='text-secondary'>{$id}</th>
                        <td class='fw-bold text-dark'>{$nome_usuario}</td>
                        <td>{$nome_livro}</td>
                        <td><span class='badge bg-light text-dark border px-2 py-1'>{$dt_emp}</span></td>
                        <td><span class='badge bg-light text-dark border px-2 py-1'>{$dt_dev}</span></td>
                        <td class='text-center'>
                          <div class='d-flex justify-content-center gap-1'>
                            <a class='btn btn-success btn-sm shadow-sm' onclick='return confirm(\"Confirmar devolução e gerar registro?\")' href='../devolucoes/devolucaoList.php?id={$id}&acao=dar_baixa'>
                              <i class='fa-solid fa-check me-1'></i>Devolver
                            </a>                     
                            <a class='btn btn-warning btn-sm shadow-sm text-dark fw-bold' href='emprestimoForm.php?id={$id}'>
                              <i class='fa-solid fa-pen-to-square me-1'></i>Editar
                            </a>
                            <a class='btn btn-danger btn-sm shadow-sm' onclick='return confirm(\"Deseja realmente excluir este registro?\")' href='emprestimoList.php?id={$id}&acao=excluir'>
                              <i class='fa-solid fa-trash me-1'></i>Excluir
                            </a>
                          </div>
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
