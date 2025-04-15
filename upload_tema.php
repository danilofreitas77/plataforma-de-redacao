<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="stylesheet" href="upload_temas.css">
    <meta charset="UTF-8">
    <title>Criar Tema de Redação</title>
</head>
<body>

<header>
    <img src="assets/logo-removebg-preview.png" alt="Logo">
    <nav>
        <a href="#">Temas de Redação</a>
        <a href="#">Redações corrigidas</a>
    </nav>
</header>



<div class="form-container">
    <h2>Cadastro de Tema de Redação</h2>
    <form action="processa_upload.php" method="POST" enctype="multipart/form-data">
        <label for="tema">Proposta de Redação:</label>
        <input type="text" name="tema" required>

        <input type="date" name="data" id="data" hidden>

        <label for="arquivo">Arquivo de Apoio (Imagem ou PDF):</label>
        <input type="file" name="arquivo" required>

        <button type="submit">Cadastrar Tema</button>
    </form>
</div>

<script>
    // Preenche automaticamente o campo de data com a data de hoje
    document.addEventListener("DOMContentLoaded", function() {
        let today = new Date().toISOString().split('T')[0];
        document.getElementById("data").value = today;
    });
</script>

</body>
</html>
