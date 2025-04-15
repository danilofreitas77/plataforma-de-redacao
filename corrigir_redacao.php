<?php
include ('../raniely_redacao/controller/conexao.php');

// Obtém o id da redação pela URL
$id_redacao = intval($_GET['id_redacao']);

// Consulta para obter os dados da redação
$sql = "SELECT * FROM redacoes WHERE id_redacao = '$id_redacao'";
$result = $conn->query($sql);

// Verifica se a redação foi encontrada
if ($result->num_rows > 0) {
    $redacao = $result->fetch_object();
} else {
    die("Redação não encontrada.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="corrigir_redacao.css">
    <title>Corrigir Redação</title>
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
        <div class="redacao-container">
            <h2>Correção de Redação</h2>

            <h3>Arquivo da Redação</h3>
            <a href="<?php echo $redacao->arquivo_redacao; ?>" download="redacao_aluno.png" class="btn-download">Baixar Redação</a>

            <h3>Comentário do Aluno</h3>
            <p><?php echo nl2br(htmlspecialchars($redacao->comentario_aluno)); ?></p>

            <form action="salvar_correcao.php">
                <input type="hidden" name="id_redacao" value="<?php echo $id_redacao; ?>">

                <h3>Notas</h3>
                <label>Competência 1:</label>
                <input type="number" name="c1" class="nota" min="0" max="200" required>
                
                <label>Competência 2:</label>
                <input type="number" name="c2" class="nota" min="0" max="200" required>

                <label>Competência 3:</label>
                <input type="number" name="c3" class="nota" min="0" max="200" required>

                <label>Competência 4:</label>
                <input type="number" name="c4" class="nota" min="0" max="200" required>

                <label>Competência 5:</label>
                <input type="number" name="c5" class="nota" min="0" max="200" required>

                <h3>Nota Final: <span id="nota-final">0</span></h3>

                <h3>Comentário da Professora</h3>

                <input class="comentario" name="comentario" type="text">
        

                <input class="btn-enviar" value="Salvar Correção" type="submit">
            </form>
        </div>
    </main>

    <script>
        // Atualiza automaticamente a nota final
        const inputs = document.querySelectorAll('.nota');
        const notaFinal = document.getElementById('nota-final');

        function calcularNota() {
            let total = 0;
            inputs.forEach(input => {
                total += parseInt(input.value) || 0;
            });
            notaFinal.textContent = total;
        }

        inputs.forEach(input => {
            input.addEventListener('input', calcularNota);
        });
    </script>
</body>
</html>
