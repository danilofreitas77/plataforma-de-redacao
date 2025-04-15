<?php

include ('../raniely_redacao/controller/conexao.php');

$id = intval($_GET['id_tema']);

$sql = "SELECT * FROM temas WHERE id_tema = '$id'";

$result = $conn->query($sql);

$temas = $result->fetch_object();

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de Linguagens e Redação - O curso que te aprova</title>
    <link rel="stylesheet" href="escrever.css">
</head>
<body>

<header>
    <img src="assets/logo-removebg-preview.png" alt="Logo">

    <nav>
        <a href="#">Temas de Redação</a>
        <a href="#">Redações corrigidas</a>
    </nav>
</header>

<main>

<div class="tema-container">
        <h2>Escreva um texto dissertativo argumentativo com o tema escolhido e, ao finalizar, realize o upload para a plataforma.</h2>

        <?php
            if ($temas) {
                echo "<h3>".$temas->tema."</h3>";
                // Certifique-se de que o caminho do arquivo de apoio esteja correto
                echo "<a href='".$temas->arquivo_apoio."' download='Material_de_apoio.pdf'>Fazer o Download do Material de Apoio</a>";
            } else {
                echo "<p>Nenhum tema encontrado.</p>";
            }
        ?>

        <a href="upload_redacao.php?id_tema=<?php echo $id; ?>" class="btn-upload">Fazer Upload</a>
    </div>

</main>

</body>
</html>
