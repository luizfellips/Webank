<?php

class Conexao
{
    private static $conexao;

    private function __construct(){}

    public static function getConnection() {

        $dsn = 'mysql:host=localhost;dbname='.DB_NAME.';';

        try {
            if(!isset($conexao)){
                $conexao =  new PDO($dsn, DB_USER, DB_PASSWORD);
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return $conexao;
         } 
         catch (PDOException $e) {
            $mensagem = "Drivers disponiveis: " . implode(",", PDO::getAvailableDrivers());
            $mensagem .= "\nErro: " . $e->getMessage();
            throw new Exception($mensagem);
         }
     }
}
?>