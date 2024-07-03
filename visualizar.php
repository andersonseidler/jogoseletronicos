<?php
include_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_jogo = "SELECT id, nome, categoria FROM jogos WHERE id =:id LIMIT 1";
    $result_jogo = $conn->prepare($query_jogo);
    $result_jogo->bindParam(':id', $id);
    $result_jogo->execute();

    $row_jogo = $result_jogo->fetch(PDO::FETCH_ASSOC);

    $retorna = ['erro' => false, 'dados' => $row_jogo];    
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum jogo encontrado!</div>"];
}

echo json_encode($retorna);
