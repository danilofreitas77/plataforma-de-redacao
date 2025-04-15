<?php
include ('../raniely_redacao/controller/conexao.php');

// Verifica se todas as notas e o ID da redação foram passados na URL
if(isset($_GET['id_redacao'], $_GET['c1'], $_GET['c2'], $_GET['c3'], $_GET['c4'], $_GET['c5'], $_GET['comentario'])) {
    
    // Pega os valores enviados pela URL
    $id_redacao = intval($_GET['id_redacao']);
    $c1 = intval($_GET['c1']);
    $c2 = intval($_GET['c2']);
    $c3 = intval($_GET['c3']);
    $c4 = intval($_GET['c4']);
    $c5 = intval($_GET['c5']);
    $comentario = mysqli_real_escape_string($conn, $_GET['comentario']);
    
    // Calcula a nota final (soma das c1, c2, c3, c4, c5)
    $nota_final = $c1 + $c2 + $c3 + $c4 + $c5;

    // Atualiza a redação na tabela
    $sql = "UPDATE redacoes SET 
            c1 = $c1, 
            c2 = $c2, 
            c3 = $c3, 
            c4 = $c4, 
            c5 = $c5, 
            nota = $nota_final, 
            comentario_professor = '$comentario', 
            status = 'Corrigida' 
            WHERE id_redacao = $id_redacao";

    if ($conn->query($sql) === TRUE) {
        // Correção salva com sucesso, agora redireciona para a página pendentes.php
        header('Location: pendentes.php');
        exit();  // Importante para garantir que o código após o redirecionamento não será executado
    } else {
        echo "Erro ao salvar a correção: " . $conn->error;
    }

} else {
    echo "Dados incompletos!";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
