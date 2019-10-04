<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Remote Lock</title>
    <meta name="description" content="curso de bootstrap 3">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="jquery-3.4.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script> 
    $(function(){
      $("#includedContent").load("cabecalho.php"); 
    });
    </script> 
</head>
<body>
<div id="includedContent"></div>
<br><br>

<div class="container">
<div class="row col-md-3"></div>
    <div class="row col-md-6 col-md-offset-2 custyle">
    <table class="table table-striped custab">
    <thead>
    <a href="cadastroUsuario.html" class="btn btn-primary btn-xs pull-right"><b>+</b> Adicionar nova permissão de acesso</a>
        <tr><th>Nome do Usuario</th>
            <th>Nome do Sala</th>
            <th class="text-center">Opções</th>
        </tr>
    </thead>
            <?php
             include_once 'conexao.php';
             $consulta = $PDO->query("SELECT u.nome as u_nome,f.nome as f_nome,u.codigo as codigo,f.codigo as f_codigo FROM usuario as u,fechadura as f,tem_acessa where fk_Usuario_codigo=u.codigo and fk_Fechadura_codigo=f.codigo;");
             $count = $consulta->rowCount();            
             if($count>0){
                while ($row = $consulta->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                <td>".$row['u_nome']."</td>
                <td>".$row['f_nome']."</td>
                <td class=\"text-center\"><a class='btn btn-info btn-xs' href=\"editarUsuario.php?codigo=".$row['codigo']."\"><span class=\"glyphicon glyphicon-edit\"></span> Editar</a> <a href=\"excluirUsuario.php?codigo=".$row['codigo']."\" class=\"btn btn-danger btn-xs\"><span class=\"glyphicon glyphicon-remove\"></span> Excluir</a></td>
                </tr>";
                }
            } else {
                echo "0 results";
            }
           ?>
    </table>
    </div>
    <div class="row col-md-3"></div>
</div>
</body>
</html>