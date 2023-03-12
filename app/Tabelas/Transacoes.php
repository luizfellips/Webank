<?php
session_start();
if(!isset($_SESSION['UsuarioID'])){
    header("Location: /Documents/Webank/index.php");
}
session_abort();
?>

<?php 
require_once("../../modules/dbauth/Conexao.php");
require_once("../../modules/dbauth/Constants.php");

try {
    $Conexao = Conexao::getConnection();
    $query = "select * from transacoes";
    $stmt = $Conexao->prepare($query);
    $stmt->execute();
    $transacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $ex) {
    //throw $th;
}
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
    <link rel="stylesheet" href="../../source/css/tabelas/transacoes.css">
    <link rel="stylesheet" href="../../source/css/app/header_layout.css">
   
    <title>Transações</title>
</head>
<body>
    <?php include("../../templates/header_layout.php");?>
    <section class="container">
            <table class="table table-dark table-striped mt-3 fs-6" id="tabela-transacoes">
                <thead>
                    <tr>
                        <th>ID da transação</th>
                        <th>ID da conta</th>
                        <th>Tipo da transação</th>
                        <th>Quantia</th>
                        <th>Data e hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        foreach ($transacoes as $transacao)
                         {
                    ?>
                    <tr >
                        <td class="item"><?php echo $transacao['id_transacao']?></td>
                        <td class="item"><?php echo $transacao['id_conta']?></td>
                        <td class="item"><?php echo $transacao['tipo_transacao']?></td>
                        <td class="item"><?php echo $transacao['quantia']?></td>
                        <td class="item"><?php echo $transacao['registro_data_hora']?></td>
                    </tr>
                    <?php
                     }
                        ?>

                </tbody>
            </table>
        </section>
</body>
</html>