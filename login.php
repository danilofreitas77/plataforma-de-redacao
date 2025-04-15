<?php
session_start(); // Inicia a sessão
include ('../raniely_redacao/controller/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Definição do login da professora
    $email_professora = "julianaraniely@gmail.com";
    $senha_professora = "juliana2025"; // Substitua pela senha real

    // Preparação da consulta SQL para evitar SQL Injection
    $sql = "SELECT id_usuario, nome, email, senha FROM usuarios WHERE email = ? AND senha = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        
        // Armazena o ID do usuário e o nome na sessão
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];

        // Verifica se o login corresponde ao da professora
        if ($email === $email_professora && $senha === $senha_professora) {
            header("Location: paginainicialprof.html");
        } else {
            header("Location: paginainicial.html");
        }
        exit();
    } else {
        echo "Email ou senha incorretos!";
    }

    $stmt->close();
}

$conn->close();
?>
