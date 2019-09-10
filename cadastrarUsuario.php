<?php
   include_once 'conexao.php';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $nome = $_POST['nome'];
      $codigo = $_POST['codigo'];
      $senha = $_POST['senha'];
      $acesso = $_POST['acesso'];
      
      try{
         $sql = "INSERT INTO usuario (nome,codigo,senha,acesso) VALUES (?,?,?,?)";
         $stmt= $PDO->prepare($sql);
         $stmt->execute([$nome,$codigo,$senha,$acesso]);
         header('location: home.php');
      }catch(PDOException $erro){
         echo $erro;
      }
   }
?>