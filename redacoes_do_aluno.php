<?php
include ('../raniely_redacao/controller/conexao.php');

// Verifica se o parâmetro 'id_usuario' foi passado pela URL
if (isset($_GET['id_usuario'])) {
    $id_usuario = intval($_GET['id_usuario']);

    // Consulta para pegar as redações do aluno, junto com o tema, a nota e o nome do aluno
    $sql = "SELECT r.id_redacao, r.nota, t.tema, t.data_publicacao, u.nome
            FROM redacoes r
            INNER JOIN temas t ON r.id_tema = t.id_tema
            INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
            WHERE r.id_usuario = $id_usuario
            ORDER BY t.data_publicacao DESC"; // Ordena pela data de publicação do tema

    $result = $conn->query($sql);

    // Verifica se o resultado não está vazio e pega o nome do aluno
    if ($result && $result->num_rows > 0) {
        // Recupera o nome do aluno (ele deve ser o mesmo para todas as redações desse aluno)
        $row = $result->fetch_object();
        $aluno_nome = $row->nome;
    } else {
        $aluno_nome = null; // Caso não tenha resultados
    }
} else {
    $result = null;
    $aluno_nome = null;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="redacoes_do_aluno.css">
    <title>Redações do Aluno</title>
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
        <?php if ($aluno_nome): ?>
            <h2>Redações de <?php echo htmlspecialchars($aluno_nome); ?></h2>
            <?php
                // Reposiciona o ponteiro do resultado para começar a iteração novamente
                $result->data_seek(0);
                
                if ($result->num_rows > 0): ?>
                <ul class="lista-redacoes">
                    <?php while ($row = $result->fetch_object()): ?>
                        <li class="redacao-item">
                            <strong>Tema:</strong> <?php echo htmlspecialchars($row->tema); ?><br>
                            <strong>Data de Publicação:</strong> <?php echo date('d/m/Y', strtotime($row->data_publicacao)); ?><br>
                            <strong>Nota:</strong> <?php echo ($row->nota != null) ? $row->nota : 'Não atribuída'; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>Este aluno ainda não fez nenhuma redação.</p>
            <?php endif; ?>
        <?php else: ?>
            <p>Parâmetro de ID do aluno não informado ou o aluno não existe.</p>
        <?php endif; ?>
    </main>

</body>
</html>

<?php
// Fecha a conexão com o banco de dados
$conn->close();
?>
