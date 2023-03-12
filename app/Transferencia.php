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
    <link rel="stylesheet" href="../source/css/app/Transferencia.css">

    <title>Janela de transferência</title>
</head>

<body>
    <section class="area-transferencia">
        <div class="transferencia" id="transferencia">
            <div>
                <img src="../source/img/toppng.com-gear-icon-white-white-cogs-icon-384x369.png" alt="">
            </div>
            <form action="Transferencia.php" method="post">
                <?php if (isset($_GET['Erro'])) {
                    if($_GET['Erro'] == 1){
                        echo "<p style=color:red> Um erro ocorreu na transferência.</p>";
                    } 
                    else if($_GET['Erro'] == 2){
                        echo "<p style=color:red> Você não pode transferir para si mesmo!</p>";
                    } 
                }
                ?>
                <?php if (isset($_GET['Sucesso'])) {
                    echo "<p style=color:blue> Sucesso na transferência! </p>";
                }
                ?>
                <p>Janela de Transferência</p>

                <div class="form-block">
                    <input type="text" name="NumeroConta_Originario" placeholder="Número da sua conta" required
                        autofocus>
                    <input type="text" name="Usuario_A_Transferir" placeholder="Usuário ou e-mail do usuário a transferir" required>
                    <input type="text" name="NumeroConta_Transferir" placeholder="Número da conta a transferir"
                        required>
                    <input type="number" name="Quantia" step="any" placeholder="Quantia a transferir" required>
                </div>

                <div class="buttons">
                    <input type="submit" value="Transferir">
                    <a href="Principal.php">Voltar</a>
                </div>

            </form>

        </div>
    </section>
</body>
<?php
if (isset($_GET['Erro'])) {
    echo "<script> document.getElementById('transferencia').style.height = '500px' </script>";
}
?>

<?php if (isset($_GET['Sucesso'])) {
    echo "<script> document.getElementById('transferencia').style.height = '500px' </script>";
}
?>


<?php
session_start();
if (
    isset($_SESSION["UsuarioID"]) && isset($_POST["NumeroConta_Originario"])
    && isset($_POST["Usuario_A_Transferir"]) && isset($_POST["NumeroConta_Transferir"])
    && isset($_POST["Quantia"])
) {


    require_once("../modules/dbauth/Conexao.php");
    require_once("../modules/dbauth/Constants.php");
    include("../modules/classes/Usuario.php");
    include("../modules/funcoes/funcoes_sql.php");


    $IDSessao = $_SESSION["UsuarioID"];
    $NumeroContaOriginario = $_POST["NumeroConta_Originario"];
    $UsuarioATransferir = $_POST["Usuario_A_Transferir"];
    $NumeroContaATransferir = $_POST["NumeroConta_Transferir"];
    $Quantia = $_POST["Quantia"];


    try {
        $Conexao = Conexao::getConnection();

        $resultado = BuscarPorID($Conexao, $IDSessao);

        $UsuarioAtual = new Usuario($Conexao, informacoesArray: $resultado);

        $UsuarioATransferirID = BuscarIDPorUser($Conexao, $UsuarioATransferir);
        echo $UsuarioATransferirID;
         if ($UsuarioAtual->UsuarioID == $UsuarioATransferirID) {
            header("Location: Transferencia.php?Erro=2");
        }
        else {
            if ($UsuarioAtual->Transferir($NumeroContaOriginario, $UsuarioATransferirID, $NumeroContaATransferir, $Quantia)) {
                header("Location: Transferencia.php?Sucesso=1");
            }
             else {
                header("Location: Transferencia.php?Erro=1");
            }
        }
        



    } catch (Exception $err) {
        header("Location: Transferencia.php?Erro=1");

    }
}



?>


</html>