<?php
include '../header.php';
include '../autenticacao.php';
include_once '../db.class.php';

$db = new db('reservas');
$db_usuario = new db('usuario');
$db_livros = new db('livros');

// EXCLUIR RESERVA
if (!empty($_GET['id']) && isset($_GET['acao']) && $_GET['acao'] == 'excluir') {
    $db->destroy($_GET['id']);
    echo "<script>window.location.href='reservasList.php';</script>";
    exit;
}

$dados = $db->all();
?>

<div class="row">
  <h3> Lista de Reservas</h3>

  <div class="mt-2">
      <a href="reservasForm.php" class="btn btn-success">Nova Reserva</a>
      <a href="../index.php" class="btn btn-secondary">Voltar ao Painel</a>
  </div>
</div>

<div class="row mt-4">

<table class="table table-striped table-hover">

    <thead>
        <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Data da Reserva</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>

    <tbody>

    <?php

    if (empty($dados)) {

        echo "<tr>
                <td colspan='6' align='center'>
                    Nenhuma reserva cadastrada.
                </td>
              </tr>";

    } else {

        foreach ($dados as $item) {

            $u = $db_usuario->find($item->usuario_id);
            $l = $db_livros->find($item->livro_id);

            $nome_usuario = $u ? $u->nome . " " . $u->sobrenome : "Não encontrado";
            $nome_livro = $l ? $l->titulo : "Não encontrado";

            $dt_res = date('d/m/Y', strtotime($item->data_reserva));

            echo "<tr>
                    <th scope='row'>{$item->id}</th>
                    <td>{$nome_usuario}</td>
                    <td>{$nome_livro}</td>
                    <td>{$dt_res}</td>
                    <td>{$item->status}</td>
                    <td>
                        <a class='btn btn-warning btn-sm'href='reservasForm.php?id={$item->id}'>Editar</a>
                        <a class='btn btn-danger btn-sm'onclick='return confirm(\"Deseja Excluir?\")'href='reservasList.php?id={$item->id}&acao=excluir'>Excluir</a>
                    </td>
                </tr>";
        }
    }
?>

    </tbody>
</table>
</div>

<?php include '../footer.php'; ?>