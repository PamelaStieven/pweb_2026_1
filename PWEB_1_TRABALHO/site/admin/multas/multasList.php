<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../header.php';
include '../autenticacao.php';
require_once "../db.class.php";

$db_emprestimo = new db('emprestimo'); 
$db_usuario = new db('usuario');
$db_livros = new db('livros');

$dados = $db_emprestimo->all();

$dias_permitidos = 15; 
$valor_por_dia_atraso = 5.00; 
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
        <i class="fa-solid fa-triangle-exclamation me-2"></i>Controle de Multas por Atraso
      </h3>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle border mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" style="width: 12%;"># Empréstimo</th>
            <th scope="col">Usuário / Aluno</th>
            <th scope="col">Livro</th>
            <th scope="col">Situação</th>
            <th scope="col" class="text-center">Dias de Atraso</th>
            <th scope="col" class="text-center" style="width: 15%;">Valor da Multa</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $tem_multa = false;
          if (!empty($dados)) {
              foreach ($dados as $item) {
                  $id              = isset($item->id) ? $item->id : $item['id'];
                  $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
                  $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
                  $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];
                  $data_devolucao  = isset($item->data_devolucao) ? $item->data_devolucao : ($item['data_devolucao'] ?? '');

                  $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + {$dias_permitidos} days"));
                  
                  $dias_atraso = 0;
                  $situacao = "";

                  if (!empty($data_devolucao) && $data_devolucao != '0000-00-00') {
                      if ($data_devolucao > $data_limite) {
                          $time_limite = strtotime($data_limite);
                          $time_devolucao = strtotime($data_devolucao);
                          $dias_atraso = round(($time_devolucao - $time_limite) / (60 * 60 * 24));
                          $situacao = "<span class='badge bg-secondary px-2 py-1'>Devolvido com Atraso</span>";
                      }
                  } 
                  else {
                      $hoje = date('Y-m-d');
                      if ($hoje > $data_limite) {
                          $time_limite = strtotime($data_limite);
                          $time_hoje = strtotime($hoje);
                          $dias_atraso = round(($time_hoje - $time_limite) / (60 * 60 * 24));
                          $situacao = "<span class='badge bg-danger px-2 py-1'>Pendente (Vencido)</span>";
                      }
                  }

                  if ($dias_atraso <= 0) {
                      continue;
                  }

                  $tem_multa = true;
                  $valor_multa = $dias_atraso * $valor_por_dia_atraso;

                  $u = $db_usuario->find($usuario_id);
                  $l = $db_livros->find($livro_id);
                  
                  $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
                  $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";

                  echo "<tr>
                        <th scope='row' class='text-secondary'>{$id}</th>
                        <td class='fw-bold text-dark'>{$nome_usuario}</td>
                        <td>{$nome_livro}</td>
                        <td>{$situacao}</td>
                        <td class='text-center'><strong class='text-danger'>{$dias_atraso} dias</strong></td>
                        <td class='text-center'><span class='badge bg-warning text-dark px-2 py-1'>R$ " . number_format($valor_multa, 2, ',', '.') . "</span></td>
                     </tr>";
              }
          }

          if (!$tem_multa) {
              echo "<tr><td colspan='6' align='center' class='text-success py-4'>🎉 Nenhuma multa ou atraso registrado no sistema.</td></tr>";
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