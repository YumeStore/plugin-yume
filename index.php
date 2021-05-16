<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yume Store</title>
</head>

<body>
    <?php
    include_once 'accessCoursesPlugin/consumo-api/consumo-api.php';
    $consumoApi = new ConsumoApi('https://www.iped.com.br/', 'b6d5ee6c0bee8cb0e35a33e9677b45afc60d7eff');
    
    $retorno = $consumoApi->retornoListaCursos();

    $decode = json_decode($retorno);
    ?>
    
    <a href="/plugin-yume/accessCoursesPlugin/views/listar.php">Listar</a>
    <script>
        console.log(<?php echo  $decode['COURSES'] ?>)
    </script>
</body>

</html>