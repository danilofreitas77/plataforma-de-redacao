<?php
include ('../raniely_redacao/controller/conexao.php');

$id_tema = $_GET['id_tema'];

$sql = "SELECT * FROM temas WHERE id_tema = '$id_tema'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="upload.css">
    <title>Enviar Redação</title>
</head>
<body>
    <header>
        <img src="assets/logo-removebg-preview.png" alt="">
        <nav>
            <a href="temas.php">Temas de Redação</a>
            <a href="redacoes_corrigidas.php">Redações Corrigidas</a>
        </nav>
    </header>

    <div class="container">
        <form action="upload_redacao2.php" method="POST" enctype="multipart/form-data">
            <!-- Corrigido: id_tema agora tem name -->
            <input type="hidden" name="id_tema" value="<?php echo $id_tema; ?>">
            
            <!-- Corrigido: O input hidden para data de envio -->
            <input type="hidden" id="data_envio" name="data_envio">

            <input type="file" class="file-input" id="foto_redacao" name="foto_redacao" required>
            <p class="file-info">Formatos Suportados: JPG, PDF e PNG.</p>

            <label for="comentario_aluno">Ficou com alguma dúvida?</label>
            <textarea id="comentario_aluno" name="comentario_aluno" placeholder="Digite seu comentário..." required></textarea>

            <input type="submit" class="submit-btn" value="Enviar Redação">
        </form>
    </div>

<script>
    // Preenche automaticamente a data no formato YYYY-MM-DD
    document.getElementById('data_envio').value = new Date().toISOString().split('T')[0];
</script>

</body>
</html>
