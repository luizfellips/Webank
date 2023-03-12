<?php
session_start();
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: ../index.php");
}
session_abort();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../source/css/app/Deposito.css">

    <title>Janela de Saque</title>
</head>

<body>
    <section class="area-transferencia">
        <div class="transferencia" id="transferencia">
            <div>
                <img src="../source/img/toppng.com-gear-icon-white-white-cogs-icon-384x369.png" alt="">
            </div>
            <form action="Saque.php" method="post">
                <?php if (isset($_GET['Erro'])) {
                    if ($_GET['Erro'] == 1) {
                        echo "<p style=color:red> Um erro ocorreu no saque.</p>";
                    }
                    if ($_GET['Erro'] == 2) {
                        echo "<p style=color:red> Número de conta não encontrado.</p>";
                    }

                }
                ?>
                <?php if (isset($_GET['Sucesso'])) {
                    echo "<p style=color:blue> Sucesso no saque! </p>";
                }
                ?>
                <p>Janela de saque</p>

                <div class="form-block">
                    <input type="text" name="NumeroConta" placeholder="Número da sua conta" required autofocus>
                    <input type="number" name="Quantia" step="any" placeholder="Quantia a sacar" required>
                </div>

                <div class="buttons">
                    <input type="submit" value="Sacar">
                    <a href="Principal.php">Voltar</a>
                </div>

            </form>

        </div>
    </section>
</body>
<?php
if (isset($_GET['Erro'])) {
    echo "<script> document.getElementById('transferencia').style.height = '400px' </script>";
}
?>

<?php if (isset($_GET['Sucesso'])) {
    echo "<script> document.getElementById('transferencia').style.height = '400px' </script>";
}
?>

<?php
session_start();
if (isset($_SESSION["UsuarioID"]) && isset($_POST["NumeroConta"]) && isset($_POST["Quantia"])) {
    require_once("../modules/dbauth/Conexao.php");
    require_once("../modules/dbauth/Constants.php");
    include("../modules/classes/Usuario.php");
    include("../modules/funcoes/funcoes_sql.php");
    $IDSessao = $_SESSION["UsuarioID"];
    $NumeroConta = $_POST["NumeroConta"];
    $Quantia = $_POST["Quantia"];
    try {
        $Conexao = Conexao::getConnection();

        $resultado = BuscarPorID($Conexao, $IDSessao);
        $UsuarioAtual = new Usuario($Conexao, informacoesArray: $resultado);
        if ($UsuarioAtual->Sacar($NumeroConta, $Quantia)) {
            header("Location: Saque.php?Sucesso=1");
        } else {
            header("Location: Saque.php?Erro=1");
        }

    } catch (Exception $err) {
        header("Location: Saque.php?Erro=2");
    }
}



?>








</html>