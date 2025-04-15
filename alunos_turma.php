<?php
include ('../raniely_redacao/controller/conexao.php');

// Verifica se o parâmetro 'turma' foi passado pela URL
if (isset($_GET['turma'])) {
    $turma = mysqli_real_escape_string($conn, $_GET['turma']);

    // Consulta para pegar os alunos da turma específica
    $sql = "SELECT id_usuario, nome FROM usuarios WHERE turma = '$turma'";

    // Executa a consulta e verifica se há alunos na turma
    $result = $conn->query($sql);
} else {
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="alunos_turma.css">
    <title>Lista de Alunos</title>
</head>
<body>
    <header>
        <img src="assets/logo-removebg-preview.png" alt="Logo">

        <nav>
            <a href="temasprof.php">Temas de Redação</a>
            <a href="pendentes.php">Correções Pendentes</a>
            <a href="lista_alunos.php">Lista de Alunos</a>
        </nav>
    </header>

    <main>
        <?php if (isset($turma)): ?>
            <h2>Lista de Alunos da Turma: <?php echo htmlspecialchars($turma); ?></h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_object()): ?>
                        <li>
                            <a href="redacoes_do_aluno.php?id_usuario=<?php echo $row->id_usuario; ?>">
                                <?php echo htmlspecialchars($row->nome); ?>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Não há alunos cadastrados nesta turma.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Parâmetro de turma não informado.</p>
        <?php endif; ?>
    </main>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
