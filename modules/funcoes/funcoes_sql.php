<?php 
function BuscarPorID(PDO $Conexao, $IDSessao){
    $query = "SELECT * FROM usuarios where usuario_id = ?";
    $stmt = $Conexao->prepare($query);
    $stmt->bindParam(1, $IDSessao,PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado;
}

function BuscarIDPorUser(PDO $Conexao, $Usuario){
    $query = "SELECT usuario_id FROM usuarios where email = ? or usuario = ?";
    $stmt = $Conexao->prepare($query);
    $stmt->bindParam(1, $Usuario,PDO::PARAM_STR);
    $stmt->bindParam(2, $Usuario,PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['usuario_id'];
}
?>