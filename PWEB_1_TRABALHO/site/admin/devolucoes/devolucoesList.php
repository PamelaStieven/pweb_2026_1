<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db_emprestimo = new db('emprestimo'); 
$db_usuario = new db('usuario');
$db_livros = new db('livros');

// 🔄 LÓGICA DA BAIXA COM CÁLCULO DE MULTA DE R$ 10,00 POR DIA
if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'dar_baixa') {
    $emp = $db_emprestimo->find($_GET['id']);
    
    if ($emp) {
        $id              = isset($emp->id) ? $emp->id : $emp['id'];
        $usuario_id      = isset($emp->usuario_id) ? $emp->usuario_id : $emp['usuario_id'];
        $livro_id        = isset($emp->livro_id) ? $emp->livro_id : $emp['livro_id'];
        $data_emprestimo = isset($emp->data_emprestimo) ? $emp->data_emprestimo : $emp['data_emprestimo'];

        $hoje = date('Y-m-d');
        
        // Regra: Prazo de 15 dias para devolver
        $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + 15 days"));
        
        $valor_multa = 0;
        // Se a data de hoje passou dos 15 dias permitidos, calcula R$ 10 por dia de atraso
        if ($hoje > $data_limite) {
            $dias_atraso = round((strtotime($hoje) - strtotime($data_limite)) / (60 * 60 * 24));
            $valor_multa = $dias_atraso * 10.00; 
        }

        $dados_atualizacao = [
            'id'              => $id,
            'usuario_id'      => $usuario_id,
            'livro_id'        => $livro_id,
            'data_emprestimo' => $data_emprestimo,
            'data_devolucao'  => $hoje, // Registra o dia que o material foi devolvido
            'multa'           => $valor_multa // Salva o valor gerado (Certifique-se se seu banco tem essa coluna ou usaremos dinâmico na listagem)
        ];
        
        $db_emprestimo->update($dados_atualizacao);
    }
    echo "<script>window.location.href='devolucaoList.php';</script>";
    exit;
}

$dados = $db_emprestimo->all();
?>
<div class="row">
  <h3>📜 Histórico de Devoluções (Livros Entregues)</h3>
  <div class="mt-2">
      <a href="../index.php" class="btn btn-secondary">Voltar ao Painel</a>
  </div>
</div>

<div class="row mt-4">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Usuário / Aluno</th>
        <th scope="col">Livro</th>
        <th scope="col">Retirada (Pego em)</th>
        <th scope="col">Prazo Máximo (15 dias)</th>
        <th scope="col">Entrega Real</th>
        <th scope="col">Multa Aplicada</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $tem_devolvido = false;
      if (!empty($dados)) {
          foreach ($dados as $item) {
              $data_devolucao = isset($item->data_devolucao) ? $item->data_devolucao : ($item['data_devolucao'] ?? '');
              
              if (empty($data_devolucao) || $data_devolucao == '0000-00-00') {
                  continue;
              }

              $tem_devolvido = true;
              $id              = isset($item->id) ? $item->id : $item['id'];
              $usuario_id      = isset($item->usuario_id) ? $item->usuario_id : $item['usuario_id'];
              $livro_id        = isset($item->livro_id) ? $item->livro_id : $item['livro_id'];
              $data_emprestimo = isset($item->data_emprestimo) ? $item->data_emprestimo : $item['data_emprestimo'];

              $data_limite = date('Y-m-d', strtotime($data_emprestimo . " + 15 days"));
              
              // Calcula o valor dinamicamente para garantir exibição correta
              $valor_multa = 0;
              if ($data_devolucao > $data_limite) {
                  $dias_atraso = round((strtotime($data_devolucao) - strtotime($data_limite)) / (60 * 60 * 24));
                  $valor_multa = $dias_atraso * 10.00;
              }

              $u = $db_usuario->find($usuario_id);
              $l = $db_livros->find($livro_id);
              
              $nome_usuario = $u ? ((isset($u->nome) ? $u->nome : $u['nome']) . " " . (isset($u->sobrenome) ? $u->sobrenome : $u['sobrenome'])) : "Não encontrado";
              $nome_livro   = $l ? (isset($l->titulo) ? $l->titulo : $l['titulo']) : "Não encontrado";

              echo "<tr>
                    <th scope='row'>{$id}</th>
                    <td>{$nome_usuario}</td>
                    <td>{$nome_livro}</td>
                    <td>" . date('d/m/Y', strtotime($data_emprestimo)) . "</td>
                    <td>" . date('d/m/Y', strtotime($data_limite)) . "</td>
                    <td>" . date('d/m/Y', strtotime($data_devolucao)) . "</td>
                    <td>";
                    if ($valor_multa > 0) {
                        echo "<span class='badge bg-danger'>R$ " . number_format($valor_multa, 2, ',', '.') . "</span>";
                    } else {
                        echo "<span class='badge bg-success'>No Prazo (R$ 0,00)</span>";
                    }
              echo "</td>
                 </tr>";
          }
      }

      if (!$tem_devolvido) {
          echo "<tr><td colspan='7' align='center'>Nenhum histórico de devolução registrado ainda.</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>
<?php include '../footer.php'; ?>