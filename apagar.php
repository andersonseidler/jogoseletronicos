<?php
include_once "conexao.php";

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $query_jogo = "DELETE FROM jogos WHERE id=:id";
    $result_jogo = $conn->prepare($query_jogo);
    $result_jogo->bindParam(':id', $id);

    if($result_jogo->execute()){
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Jogo excluído com sucesso!</div>"];
    }else{
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Jogo não foi excluído!</div>"];
    }    
} else {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Nenhum jogo encontrado!</div>"];
}

echo json_encode($retorna);
