<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

    // olá mundo
        echo "Olá mundo PHP!";

    //nome e idade
        echo"<br>";
        $nome = "Pamela";
        $idade = 18;
        echo "<br> Meu nome é $nome e tenho $idade anos";

    //mostrar se é maior ou menor de idade
        if ($idade < 18){
            echo "<br> Sou de menor de idade";
        }else{
            echo "<br> Sou de maior de idade";
        }

    //notas
        echo"<br>";
        $notas =[5,7,10,9];
        echo"<br>";
        echo "As notas do aluno são:";
        for ($i = 0; $i < count($notas); $i++){
            echo $notas[$i]. " - ";
        }
        echo "<br>";
        
        foreach($notas as $item){
            echo "A nota do aluno é:";
            echo $item. "<br>";
        }

    //nomes
         $nomes =["Pamela","Vicenzo","Paola","Kadson","Helena"];
        echo"<br>";
        echo "Tabela de nomes: <br>";
        for ($i = 0; $i < count($nomes); $i++){
            echo $nomes[$i]. " <br> ";
        }
        
        foreach($nomes as $item){
            echo "O nome é:";
            echo $item. "<br>";
        }
        
        //carros
        echo"<br>";
        $carro = ['modelo' => "Mustang", 'cor' => "Branco", 'ano' => 2026];

        echo "O carro é: <br>";
        echo $carro['modelo']. " - ". $carro['cor'];
        
        ?>
        <p> Meu site <?= $carro['modelo']." - ano:" .$carro['ano'] ?> </p>
        
        <?php
            include "./aula02.php";
        ?>
</body>
</html>