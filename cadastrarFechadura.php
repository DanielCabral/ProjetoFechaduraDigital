<?php
   session_start();
   include_once 'conexao.php';
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      $nome = $_POST['nome'];
      $codigo = $_POST['codigo'];
      $estado = $_POST['estado'];
      
      try{
         $sql = "INSERT INTO fechadura(nome,codigo,estado,fk_Cliente_email) VALUES (?,?,?,?)";
         $stmt= $PDO->prepare($sql);
         //$stmt->execute([$nome,$codigo,$estado, $_SESSION['usuario']]);
         if ($stmt->execute([$nome,$codigo,$estado, $_SESSION['usuario']])){
            header('location: exibirFechaduras.php');
         }
      }catch(PDOException $erro){
         echo $erro;
      }
   }
?>