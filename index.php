<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./source/css/index.css">
    <title>Login</title>
</head>

<body>
    <section class="area-login">

        <div class="login" id="login">

            <div>
                <img src="source/img/toppng.com-gear-icon-white-white-cogs-icon-384x369.png" alt="">
            </div>
            <?php if (isset($_GET['Erro'])) {
                echo "<p style=color:red> Um erro ocorreu na autenticação, verifique suas credenciais e tente novamente.</p>";
            }
            ?>
            <?php if (isset($_GET['Sucesso'])) {
                echo "<p style=color:blue> Conta criada com sucesso!</p>";
            }
            ?>
            <form action="index.php" method="POST">
                <input type="text" name="Usuario" placeholder="Nome de usuário ou e-mail" required autofocus>
                <input type="password" name="Senha" placeholder="Sua senha" required>
                <input class="btn btn-primary" type="submit" value="Entrar">
            </form>
            <p>Ainda não criou uma conta? <a href="criarConta.php">Criar conta</a></p>
        </div>
    </section>
</body>



</html>
<?php
session_destroy();
if (isset($_GET['Erro'])) {
    echo "<script> document.getElementById('login').style.height = '480px' </script>";
}
?>
<?php if (isset($_GET['Sucesso'])) {
    echo "<script> document.getElementById('login').style.height = '480px' </script>";
}
?>

<?php
if (isset($_POST["Usuario"]) && isset($_POST["Senha"])) {
    require_once("modules/dbauth/Conexao.php");
    require_once("modules/dbauth/Constants.php");
    include("modules/classes/Login.php");
    try {
        $Conexao = Conexao::getConnection();
        $usuario = $_POST["Usuario"];
        $senha = $_POST["Senha"];
        $usuario_credenciais = new Login($Conexao, $usuario, $senha);
        if ($usuario_credenciais->Autenticar()) {
            $usuario_id = $usuario_credenciais->BuscarIdUsuario();
            session_start();
            $_SESSION["UsuarioID"] = $usuario_id;
            header("Location: app/Principal.php");
            exit;

        } else {
            header("Location: index.php?Erro=1");
        }



    } catch (Exception $ex) {
        print_r($ex);
    }
}
?>