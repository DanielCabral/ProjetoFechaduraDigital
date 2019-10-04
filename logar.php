
<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("location: home.php");
}else{
    if(($_POST['email'] != "")){
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        include_once 'conexao.php';
        $consulta = $PDO->query("SELECT email FROM admin where email='".$email."' and senha=".$senha.";");

            $count = $consulta->rowCount();            
            if($count>0){
                $_SESSION['usuario']=$email;
                header("location: home.php");
            }
        
    }
}
?>