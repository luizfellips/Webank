<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="source/css/criarConta.css">
    <title>Criar conta</title>
</head>

<body>
    <section class="area-credentials">
        <div class="credentials">
            <div>
                <img src="source/img/toppng.com-gear-icon-white-white-cogs-icon-384x369.png" alt="">
            </div>
            <form action="criarConta.php" method="post">
            <?php if (isset($_GET['Erro'])) {
                if($erro == 1){
                    echo "<p style=color:red> Um erro ocorreu no registro.</p>";
                }
            }
            ?>

                <div class="first-form-block">
                    <input type="text" name="Usuario" placeholder="Seu usuário" pattern=".{10,25}" required autofocus>
                    <input type="text" name="Email" placeholder="Seu e-mail" required>
                    <input type="password" name="Senha" placeholder="Sua senha" required>
                    <input type="password" name="ConfirmarSenha" placeholder="Confirme sua senha" required>
                </div>

                <div class="buttons">
                    <input type="submit" value="Criar">
                    <a href="index.php">Voltar</a>
                </div>

            </form>

        </div>
    </section>
</body>


</html>


<?php 
if(isset($_GET['Erro'])){
    echo "<script> document.getElementById('login').style.height = '450px' </script>";
}
?>


<?php
if (isset($_POST['Usuario']) && isset($_POST['Email']) && isset($_POST['Senha']) && isset($_POST['ConfirmarSenha'])) {
    if ($_POST['Senha'] != $_POST['ConfirmarSenha']) {
        header("Location: criarConta.php?Erro=1");

    } 
    
    else {
        require_once("modules/dbauth/Conexao.php");
        require_once("modules/dbauth/Constants.php");
        include("modules/classes/Usuario.php");
        try {
            $Conexao = Conexao::getConnection();
            $usuario = $_POST['Usuario'];
            $senha = $_POST['Senha'];
            $email = $_POST['Email'];
            $obj_usuario = new Usuario($Conexao, usuario: $usuario, senha: $senha, email: $email);
            if ($obj_usuario->RegistrarConta()) {
                header("Location: index.php?Sucesso=1");
            } else {
                header("Location: criarConta.php?Erro=1");
            }
        } catch (Exception $err) {
            print_r($err);
        }
    }
}

?>