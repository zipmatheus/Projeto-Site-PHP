<?php

    $dbHost = 'localhost';
    $dbUsername = 'user';
    $dbPassword = 'pass';
    $dbName = 'banco';

    $conexao = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    //if($conexao->connect_errno)
    //{
    //    echo "Erro";
    //}
    //else
    //{
    //    echo "conexao realizada com sucesso";
    //}
?>