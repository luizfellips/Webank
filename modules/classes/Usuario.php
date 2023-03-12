<?php

class Usuario
{

    public $pdo;
    public $UsuarioID;
    public $Usuario;
    public $Senha;
    public $Email;

    public function __construct(PDO $pdo, $informacoesArray = null, $usuario = null, $senha = null, $email = null)
    {
        $this->pdo = $pdo;
        $this->Usuario = $usuario;
        $this->Senha = $this->SetHash($senha);
        $this->Email = $email;
        if ($informacoesArray != null) {

            $this->UsuarioID = $informacoesArray['usuario_id'];
            $this->Usuario = $informacoesArray['usuario'];
            $this->Senha = $informacoesArray['senha'];
            $this->Email = $informacoesArray['email'];
        }

    }

    public function __constructID($UsuarioID)
    {
        $this->UsuarioID = $UsuarioID;
    }

    public function SetHash($senha)
    {
        return $this->Senha = sha1($senha);
    }

    public function RegistrarConta()
    {
        $sql = "CALL RegistrarNovaConta(?,?,?);";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $this->Usuario, PDO::PARAM_STR);
        $stmt->bindParam(2, $this->Senha, PDO::PARAM_STR);
        $stmt->bindParam(3, $this->Email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function BuscarInformacoesPorID()
    {
        $query = "SELECT * FROM usuarios where usuario_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $this->Usuario, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function BuscarIDConta($valor)
    {
        $query = "SELECT id_conta FROM contas where usuario_id = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(1, $valor, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['id_conta'];
    }

    public function Depositar($numero_conta, $quantia)
    {
        $IDConta = $this->BuscarIDConta($this->UsuarioID);
        $query = "CALL Depositar(:id_conta,:usuario_id,:numero_conta,:quantia)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_conta', $IDConta);
        $stmt->bindValue(':usuario_id', $this->UsuarioID);
        $stmt->bindValue(':numero_conta', $numero_conta);
        $stmt->bindValue(':quantia', $quantia);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function Sacar($numero_conta, $quantia)
    {
        $IDConta = $this->BuscarIDConta($this->UsuarioID);
        $query = "CALL Sacar(:id_conta,:usuario_id,:numero_conta,:quantia)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_conta', $IDConta);
        $stmt->bindValue(':usuario_id', $this->UsuarioID);
        $stmt->bindValue(':numero_conta', $numero_conta);
        $stmt->bindValue(':quantia', $quantia);
        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }

    public function Transferir($numero_conta_originaria,$usuario_id_a_transferir,$numero_conta_a_transferir, $quantia)
    {   

        $IDConta_Usuario_Originario = $this->BuscarIDConta($this->UsuarioID);
        $IDConta_Usuario_A_Transferir = $this->BuscarIDConta($usuario_id_a_transferir);
        $query = "CALL Transferir(
            :id_conta_1,
            :usuario_id_1,
            :id_conta_2,
            :usuario_id_2,
            :numero_conta_1,
            :numero_conta_2,
            :quantia
            )";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id_conta_1', $IDConta_Usuario_Originario);
        $stmt->bindValue(':usuario_id_1', $this->UsuarioID);

        $stmt->bindValue(':id_conta_2', $IDConta_Usuario_A_Transferir);
        $stmt->bindValue(':usuario_id_2', $usuario_id_a_transferir);

        $stmt->bindValue(':numero_conta_1', $numero_conta_originaria);
        $stmt->bindValue(':numero_conta_2', $numero_conta_a_transferir);
        
        $stmt->bindValue(':quantia', $quantia);

        $stmt->execute();
        if ($stmt) {
            return true;
        } else {
            return false;
        }
    }


}

?>