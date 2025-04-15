<?php

    include ('../raniely_redacao/controller/conexao.php');

    $nome = $_GET['nome'];
    $email = $_GET['email'];
    $senha = $_GET['senha'];
    $turma = $_GET['turma'];

    $sql = "INSERT INTO usuarios VALUES ('','$nome','$email','$senha','$turma')";

    $result = $conn->query($sql);

    if ($result){
        echo "Usuário cadastrado com sucesso!";
        header('Location: teladelogin.html');
    } else {
        echo "Erro ao cadastrar usuário!";
    }


?>