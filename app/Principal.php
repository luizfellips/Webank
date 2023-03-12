<?php
session_start();
if (!isset($_SESSION['UsuarioID'])) {
    header("Location: ../index.php");
}
session_abort();
?>


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
    <link rel="stylesheet" href="../source/css/app/header_layout.css">
    <link rel="stylesheet" href="../source/css/app/Principal.css">
    <title>Página Principal</title>
</head>

<body>
    <?php include("../templates/header_layout.php"); ?>
    <div class="row">
    <section class="Menu container col">
        <h1 class="display-4">Operações</h1>
        <ul>
            <li class="display-6"><a href="Transferencia.php">Transferência</a></li>
            <li class="display-6"><a href="Deposito.php">Depósito</a></li>
            <li class="display-6"><a href="Saque.php">Saque</a></li>
            <li class="display-6"><a href="FinalizarSessao.php">Sair</a></li>
        </ul>
    </section>
    <section class="Usuario container col">
        <h1 class="display-4">Usuário atual: </h1>
        <p class="display-6" id="UsuarioLogado">Nenhum</p>
    </section>    
    </div>
    
</body>
<?php
session_start();
if(isset($_SESSION["UsuarioID"])){
    require_once("../modules/dbauth/Conexao.php");
    require_once("../modules/dbauth/Constants.php");
    include("../modules/classes/Usuario.php");
    include("../modules/funcoes/funcoes_sql.php");
    
    try {
        $Conexao = Conexao::getConnection();
        $IDSessao = $_SESSION["UsuarioID"];
        $resultado = BuscarPorID($Conexao,$IDSessao);
        $Usuario = $resultado['usuario'];
        echo $Usuario;
        echo "<script>document.getElementById('UsuarioLogado').innerText = '$Usuario' </script>";
    
    } catch (Exception $err) {
        print_r($err);
    }
}
else {
    echo "usuario id não setado";
}
?>
</html>


