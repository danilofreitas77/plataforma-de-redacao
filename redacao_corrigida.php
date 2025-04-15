<?php
session_start();
include ('../raniely_redacao/controller/conexao.php');

// Definindo valores padrão para evitar warnings
$c1 = $c2 = $c3 = $c4 = $c5 = $nota = $comentario_prof = "Não disponível";

// Pegando o 'tema' da URL
$tema = $_GET['tema']; 
$id_usuario = $_SESSION['id_usuario']; 

// 1. Acessando a tabela "temas" para obter o id_tema
$sql_tema = "SELECT id_tema FROM temas WHERE tema = ?";
$stmt_tema = $conn->prepare($sql_tema);
$stmt_tema->bind_param("s", $tema);
$stmt_tema->execute();
$result_tema = $stmt_tema->get_result();

// Verifica se o tema existe
if ($result_tema->num_rows > 0) {
    $row_tema = $result_tema->fetch_assoc();
    $id_tema = $row_tema['id_tema'];

    // 2. Acessando a tabela "redacoes"
    $sql_redacao = "SELECT c1, c2, c3, c4, c5, nota, comentario_professor 
                    FROM redacoes 
                    WHERE id_usuario = ? AND id_tema = ? AND status = 'Corrigida'";
    $stmt_redacao = $conn->prepare($sql_redacao);
    $stmt_redacao->bind_param("ii", $id_usuario, $id_tema);
    $stmt_redacao->execute();
    $result_redacao = $stmt_redacao->get_result();

    // Verifica se encontrou a redação
    if ($result_redacao->num_rows > 0) {
        $row_redacao = $result_redacao->fetch_assoc();
        $c1 = $row_redacao['c1'] ?? "Não disponível";
        $c2 = $row_redacao['c2'] ?? "Não disponível";
        $c3 = $row_redacao['c3'] ?? "Não disponível";
        $c4 = $row_redacao['c4'] ?? "Não disponível";
        $c5 = $row_redacao['c5'] ?? "Não disponível";
        $nota = $row_redacao['nota'] ?? "Não disponível";
        $comentario_prof = $row_redacao['comentario_professor'] ?? "Não disponível";
    } else {
        echo "<p>Nenhuma redação encontrada para este tema.</p>";
    }
} else {
    echo "<p>Tema não encontrado.</p>";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="redacao_corrigida.css">
    <link rel="shortcut icon" href="../raniely_redacao/assets/logo-removebg-preview.png" type="image/x-icon">
    <title>Redação Corrigida</title>
</head>
<body>
    <header>
        <img src="assets/logo-removebg-preview.png" alt="Logo">
        <nav>
            <a href="temas.php">Temas de Redação</a>
            <a href="redacoes_corrigidas.php">Redações corrigidas</a>
        </nav>
    </header>

    <main>
        <h2>Redação Corrigida - <?php echo htmlspecialchars($tema); ?></h2>

        <div class="redacao-container">
            <p><strong>C1:</strong> <?php echo htmlspecialchars($c1); ?></p>
            <p><strong>C2:</strong> <?php echo htmlspecialchars($c2); ?></p>
            <p><strong>C3:</strong> <?php echo htmlspecialchars($c3); ?></p>
            <p><strong>C4:</strong> <?php echo htmlspecialchars($c4); ?></p>
            <p><strong>C5:</strong> <?php echo htmlspecialchars($c5); ?></p>
            <p><strong>Nota:</strong> <?php echo htmlspecialchars($nota); ?></p>
            <p><strong>Comentário do Professor:</strong> <?php echo nl2br(htmlspecialchars($comentario_prof)); ?></p>
        </div>
    </main>
</body>
</html>
