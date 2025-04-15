<?php
include ('../raniely_redacao/controller/conexao.php');

// Pega o valor da turma da URL
$turma = $_GET['turma'];

// Consulta para pegar os alunos da turma específica
$sqlAlunos = "SELECT id_usuario FROM usuarios WHERE turma = '$turma'";
$resultAlunos = $conn->query($sqlAlunos);

// Verifica se existem alunos na turma
if ($resultAlunos->num_rows > 0) {
    // Cria um array para armazenar os ids dos alunos
    $alunosIds = [];
    while ($row = $resultAlunos->fetch_object()) {
        $alunosIds[] = $row->id_usuario;
    }

    // Converte o array de ids em uma string separada por vírgulas
    $alunosIdsStr = implode(',', $alunosIds);

    // Consulta para pegar as redações pendentes desses alunos
    $sqlRedacoes = "
        SELECT 
            r.id_redacao, 
            r.id_usuario, 
            r.status, 
            t.tema AS titulo_tema, 
            u.nome AS nome_aluno
        FROM redacoes r
        INNER JOIN temas t ON r.id_tema = t.id_tema
        INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
        WHERE r.id_usuario IN ($alunosIdsStr) 
        AND r.status = 'Pendente'
    ";

    // Executa a consulta para pegar as redações pendentes
    $resultRedacoes = $conn->query($sqlRedacoes);

    // Exibe as redações pendentes
    

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lista_redacao.css">
    <title>Correções Pendentes</title>
</head>
<body>
    <header>
        <img src="assets/logo-removebg-preview.png" alt="Logo">

        <nav>
            <a href="temasprof.php">Temas de Redação</a>
            <a href="pendentes.php">Correções Pendentes</a>
            <a href="">Lista de Alunos</a>
        </nav>
    </header>

    <main>
        <div class="cards-container">
            <?php

                if ($resultRedacoes->num_rows > 0) {
                    while ($row = $resultRedacoes->fetch_object()) {
                        echo "<div class='card'>";
                        echo "<h3>" . $row->titulo_tema . "</h3>";
                        echo "<p>Aluno: " . $row->nome_aluno . "</p>";
                        echo "<a href='corrigir_redacao.php?id_redacao=" . $row->id_redacao . "' class='btn-corrigir'>Corrigir</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='no-redacoes'>Não há redações pendentes para essa turma.</p>";
                }
                } else {
                echo "<p class='no-alunos'>Não há alunos nesta turma.</p>";
                }






            ?>
        </div>
    </main>
</body>
</html>
