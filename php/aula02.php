<?php

    $pessoas = [
        ["nome" =>"Pamela Stieven", "idade" => 18],
        ["nome" =>"Vicenzo Scalvi", "idade" => 17],
        ["nome" =>"Paola Farias Turmena", "idade" => 18],
    ];

    foreach ($pessoas as $key => $item){
        $nome = $item ['nome'];
        $idade = $item ['idade'];
        echo "Indice: $key Nome:$nome Idade:$idade <br>";
    };