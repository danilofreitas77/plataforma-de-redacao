<?php

session_start();
include ('../raniely_redacao/controller/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['id_usuario'])) {
        die("Erro: Usuário não autenticado.");
    }

    $id_usuario = $_SESSION['id_usuario']; // Obtém o ID do usuário autenticado
    $id_tema = $_POST['id_tema'];
    $data_envio = $_POST['data_envio'];
    $comentario = $_POST['comentario_aluno'];

    if (isset($_FILES['foto_redacao']) && $_FILES['foto_redacao']['error'] == 0) {
        $arquivo = $_FILES['foto_redacao'];
        $diretorio = "uploads_redacao/";

        $nome_arquivo = uniqid() . "_" . basename($arquivo["name"]);
        $caminho_final = $diretorio . $nome_arquivo;

        if (move_uploaded_file($arquivo["tmp_name"], $caminho_final)) {
            $sql = "INSERT INTO redacoes (id_usuario, id_tema, arquivo_redacao, comentario_aluno, data_envio, status) 
                    VALUES ('$id_usuario', '$id_tema', '$caminho_final', '$comentario', '$data_envio', 'Pendente')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Redação enviada com sucesso!'); window.location.href='temas.php';</script>";
            } else {
                echo "Erro ao salvar no banco: " . $conn->error;
            }
        } else {
            echo "Erro ao mover o arquivo.";
        }
    } else {
        echo "Nenhum arquivo enviado.";
    }
}

$conn->close();
