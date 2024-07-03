<?php

include_once "conexao.php";

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (empty($dados['nome'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher o campo nome!</div>"];
} elseif (empty($dados['categoria'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Necessário preencher a categoria!</div>"];
} else {
    $query_jogo = "INSERT INTO jogos (nome, categoria) VALUES (:nome, :categoria)";
    $cad_jogo = $conn->prepare($query_jogo);
    $cad_jogo->bindParam(':nome', $dados['nome']);
    $cad_jogo->bindParam(':categoria', $dados['categoria']);
    $cad_jogo->execute();

    if ($cad_jogo->rowCount()) {
        $retorna = ['erro' => false, 'msg' => "<div class='alert alert-success' role='alert'>Jogo cadastrado com sucesso!</div>"];
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger' role='alert'>Erro: Jogo não foi cadastrado!</div>"];
    }
}

echo json_encode($retorna);
