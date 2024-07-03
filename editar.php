<?php

include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['id'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Tente mais tarde!</div>"];
} elseif (empty($dados['nome'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>"];
} elseif (empty($dados['categoria'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher a categoria!</div>"];
} else {
    $query_jogos= "UPDATE jogos SET nome=:nome, categoria=:categoria WHERE id=:id";
    
    $edit_jogos = $conn->prepare($query_jogos);
    $edit_jogos->bindParam(':nome', $dados['nome']);
    $edit_jogos->bindParam(':categoria', $dados['categoria']);
    $edit_jogos->bindParam(':id', $dados['id']);

    if ($edit_jogos->execute()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Jogo editado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Jogo não foi editado!</div>"];
    }
}

echo json_encode($retorna);
