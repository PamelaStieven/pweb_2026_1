<?php

include_once './database/db.class.php';

// instanciar um objeto da classe DB
$conn = new db("usuario");

$dados = [
    'nome' => "Pamela Stieven",
    'telefone' => "49991133904",
    'email' => "pamela.s2008@aluno.ifsc.edu.br",
];

$conn->store($dados);
echo "Inserido com sucesso!";