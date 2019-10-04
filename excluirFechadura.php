<?php
 include_once 'conexao.php';
    try{
      $sql = "delete from fechadura WHERE codigo=?";
      $stmt= $PDO->prepare($sql);
      $stmt->execute([$_GET['codigo']]);
      header('location: exibirFechaduras.php');
   }catch(PDOException $erro){
      echo $erro;
   }

?>