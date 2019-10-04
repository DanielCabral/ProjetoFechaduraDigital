<?php
   session_start();
   include_once 'conexao.php';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $nome = $_POST['nome'];
      $codigo = $_POST['codigo'];
      $senha = $_POST['senha'];
      $acesso = $_POST['acesso'];
      
      try{
         $sql = "INSERT INTO usuario (nome,codigo,senha,acesso,fk_Cliente_email) VALUES (?,?,?,?,?)";
         $stmt= $PDO->prepare($sql);
         $stmt->execute([$nome,$codigo,$senha,$acesso,$_SESSION['usuario']]);
         header('location: exibirUsuarios.php');
      }catch(PDOException $erro){
         echo $erro;
      }
   }
?>