<?php
session_start();
include ('../raniely_redacao/controller/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    echo "<p>Você precisa estar logado para acessar esta página.</p>";
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Consulta para pegar as redações corrigidas do aluno logado
$sql = "SELECT t.tema, t.data_publicacao
        FROM redacoes r
        INNER JOIN temas t ON r.id_tema = t.id_tema
        WHERE r.id_usuario = $id_usuario AND r.status = 'Corrigida'
        ORDER BY t.data_publicacao DESC"; // Ordena pela data

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="redacoes_corrigidas.css">
    <title>Redações Corrigidas</title>
</head>
<body>
    <header>
        <img src="assets/logo-removebg-preview.png" alt="Logo">
        <nav>
            <a href="temas.php">Temas de Redação</a>
            <a href="redacoes_corrigidas.php">Redações Corrigidas</a>
        </nav>
    </header>

    <main>
    <h2>Redações Corrigidas</h2>
    <ul class="lista-redacoes">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="redacao-item">
                <strong><?php echo htmlspecialchars($row['tema']); ?></strong>
                <small>Data: <?php echo date('d/m/Y', strtotime($row['data_publicacao'])); ?></small>
                <br>
                <a href="redacao_corrigida.php?tema=<?php echo urlencode($row['tema']); ?>" class="btn-detalhes">Ver Detalhes</a>
            </li>
        <?php endwhile; ?>
    </ul>
</main>

</body>
</html>

<?php
$conn->close();
?>
