<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "db_jogos";
$port = 3306;

try{
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

}  catch(PDOException $err){
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso. Erro gerado " . $err->getMessage();
}