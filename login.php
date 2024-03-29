
<?php
session_start();
if(isset($_SESSION['usuario'])){
    header("location: home.php");
}else{
    if(($_POST['email'] != "")){
        $email=$_POST['email'];
        $senha=$_POST['senha'];
        include_once 'conexao.php';
        $consulta = $PDO->query("SELECT email FROM cliente where email='".$email."' and senha=".$senha.";");

            $count = $consulta->rowCount();            
            if($count>0){
                $_SESSION['usuario']=$email;
                header("location: home.php");
            }
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
<style>
body {
            background: #000 !important;
        }
        .card {
            border: 1px solid #28a745;
        }
        .card-login {
            margin-top: 130px;
            padding: 18px;
            max-width: 30rem;
        }

        .card-header {
            color: #fff;
            /*background: #ff0000;*/
            font-family: sans-serif;
            font-size: 20px;
            font-weight: 600 !important;
            margin-top: 10px;
            border-bottom: 0;
        }

        .input-group-prepend span{
            width: 50px;
            background-color: #ff0000;
            color: #fff;
            border:0 !important;
        }

        input:focus{
            outline: 0 0 0 0  !important;
            box-shadow: 0 0 0 0 !important;
        }

        .login_btn{
            width: 130px;
        }

        .login_btn:hover{
            color: #fff;
            background-color: #ff0000;
        }

        .btn-outline-danger {
            color: #fff;
            font-size: 18px;
            background-color: #28a745;
            background-image: none;
            border-color: #28a745;
        }

        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: 0.375rem 0.75rem;
            font-size: 1.2rem;
            line-height: 1.6;
            color: #28a745;
            background-color: transparent;
            background-clip: padding-box;
            border: 1px solid #28a745;
            border-radius: 0;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .input-group-text {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.6;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0;
        }
</style>
</head>
<body>
<div class="container">
    <div class="card card-login mx-auto text-center bg-dark">
        <div class="card-header mx-auto bg-dark">
            <span> <img src="fundo.png" class="w-75" alt="Logo"> </span><br/>
                        <span class="logo_title mt-5"> Login </span>
<!--            <h1>--><?php //echo $message?><!--</h1>-->

        </div>
        <div class="card-body">
            <form action="login.php" method="post">
                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                </div>

                <div class="input-group form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha">
                </div>

                <div class="form-group">
                    <!--<button type="button" class="btn btn-outline-danger float-right login_btn" onclick="logar()">Login</button>-->
                    <input type="submit" name="btn" value="Login" class="btn btn-outline-danger float-right login_btn">
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function logar() {
    var email=document.getElementById("email");
    var senha=document.getElementById("senha");
    console.log(email.value);
    console.log(senha.value);
    if (senha.value.length < 4) {
       alert("Senha precisa ter ao menos 4 caracteres");
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "gethint.php?q=" + email.value+"", true);
        xmlhttp.send();
    }
}
</script>
</body>
</html>