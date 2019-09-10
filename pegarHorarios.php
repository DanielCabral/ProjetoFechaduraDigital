<?php
    $codigo=$_GET['codigo'];
    $senha=$_GET['senha'];
    include_once 'conexao.php';
    $consulta = $PDO->query("SELECT codigo FROM usuario where codigo=".$codigo." and senha=".$senha.";");
    $count = $consulta->rowCount();
    $cadastrado="false";
    if($count>0){
        $cadastrado="true"; 
    }
    echo $cadastrado;
?>