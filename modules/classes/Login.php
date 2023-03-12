<?php

class Login
{

    public $pdo;
    public $Usuario;
    public $Senha;

    public function __construct(PDO $pdo, $usuario, $senha)
    {
        $this->pdo = $pdo;
        $this->Usuario = $usuario;
        $this->Senha = $this->SetHash($senha);
    }

    public function SetHash($senha)
    {
        return $this->Senha = sha1($senha);
    }

    public function Autenticar()
    {
        $query = "SELECT * FROM usuarios where (usuario = :usuario or email = :email) and senha = :senha;";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('usuario', $this->Usuario);
        $stmt->bindValue('email', $this->Usuario);
        $stmt->bindValue('senha', $this->Senha);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            return true;
        } else {
            return false;
        }
    }

    public function BuscarIdUsuario(){
        $query = "SELECT usuario_id FROM usuarios where (usuario = :usuario or email = :email) and senha = :senha;";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('usuario', $this->Usuario);
        $stmt->bindValue('email', $this->Usuario);
        $stmt->bindValue('senha', $this->Senha);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado["usuario_id"];
    }
}
?>