<?php

include ('../raniely_redacao/controller/conexao.php');


$sql = "SELECT * FROM temas ORDER BY id_tema DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso de Linguagens e Redação - O curso que te aprova</title>
    <link rel="stylesheet" href="temas.css">
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
    <h2>Temas de Redação</h2>

    <div class="temas-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="tema-box">';
            echo '<h3>' . htmlspecialchars($row['tema']) . '</h3>';
            echo '<p class="data-tema">Publicado em: ' . date("d/m/Y", strtotime($row['data_publicacao'])) . '</p>';
            echo '<a href="escrever.php?tema=' . urlencode($row['tema']) . '&id_tema=' . urlencode($row['id_tema']) . '" class="btn-escrever">Escrever Redação</a>';
            echo '</div>';
        }
    } else {
        echo "<p>Nenhum tema cadastrado.</p>";
    }
    ?>
</div>

</main>

</body>
</html>