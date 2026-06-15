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
        <i class="fa-solid fa-calendar-days me-2"></i>Lista de Reservas
      </h3>
      <a href="reservasForm.php" class="btn btn-success px-4">
        <i class="fa-solid fa-plus me-2"></i>Nova Reserva
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle border mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 8%;"># ID</th>
            <th scope="col">Usuário</th>
            <th scope="col">Livro</th>
            <th scope="col">Data da Reserva</th>
            <th scope="col">Status</th>
            <th scope="col" class="text-center" style="width: 20%;">Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if (empty($dados)) {
              echo "<tr><td colspan='6' align='center' class='text-muted py-4'>📋 Nenhuma reserva cadastrada.</td></tr>";
          } else {
              foreach ($dados as $item) {
                  $u = $db_usuario->find($item->usuario_id);
                  $l = $db_livros->find($item->livro_id);

                  $nome_usuario = $u ? $u->nome . " " . $u->sobrenome : "Não encontrado";
                  $nome_livro = $l ? $l->titulo : "Não encontrado";

                  $dt_res = date('d/m/Y', strtotime($item->data_reserva));

                  echo "<tr>
                        <th scope='row' class='text-secondary'>{$item->id}</th>
                        <td class='fw-bold text-dark'>{$nome_usuario}</td>
                        <td>{$nome_livro}</td>
                        <td>{$dt_res}</td>
                        <td><span class='badge bg-secondary px-2 py-1'>{$item->status}</span></td>
                        <td class='text-center'>
                          <div class='d-flex justify-content-center gap-1'>
                            <a class='btn btn-warning btn-sm shadow-sm text-dark fw-bold' href='reservasForm.php?id={$item->id}'>
                              <i class='fa-solid fa-pen-to-square me-1'></i>Editar
                            </a>
                            <a class='btn btn-danger btn-sm shadow-sm' onclick='return confirm(\"Deseja Excluir?\")' href='reservasList.php?id={$item->id}&acao=excluir'>
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
