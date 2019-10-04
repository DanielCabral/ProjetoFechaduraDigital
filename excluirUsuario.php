<?php
 include_once 'conexao.php';
    try{
      $sql = "delete from usuario WHERE codigo=?";
      $stmt= $PDO->prepare($sql);
      $stmt->execute([$_GET['codigo']]);
      header('location: exibirUsuarios.php');
   }catch(PDOException $erro){
      echo $erro;
   }

?>