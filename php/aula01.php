<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        echo "Olá mundo PHP!";
        $nome = "Pamela";
        $idade = 18;
        echo "Meu nome é $nome e tenho $idade anos";

        if ($idade < 18){
            echo "Essa pessoa é menor de idade";
        }else{
            echo "Essa pessoa é maior de idade";
        }
    ?>
</body>
</html>