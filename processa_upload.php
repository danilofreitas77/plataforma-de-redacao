<?php
// Conectar ao banco de dados
include('../raniely_redacao/controller/conexao.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebe os dados do formulário
    $tema = $_POST['tema'];
    $data = $_POST['data'];

    // Configuração para salvar o arquivo
    $diretorio = "uploads/";
    
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    // Recebe o arquivo de apoio
    $arquivo_nome = basename($_FILES["arquivo"]["name"]);
    $caminho_final = $diretorio . uniqid() . "_" . $arquivo_nome;

    // Move o arquivo para a pasta "uploads/"
    if (move_uploaded_file($_FILES["arquivo"]["tmp_name"], $caminho_final)) {

        // Preparar a consulta para inserir os dados no banco
        $sql = "INSERT INTO temas (tema, data_publicacao, arquivo_apoio) VALUES ('$tema','$data', '$caminho_final')";

        $result = $conn->query($sql);
        

    } else {
        echo "Erro ao fazer upload do arquivo.";
    }

    if ($result){
        echo "Tema cadastrado com sucesso!";
        header("Location: paginainicialprof.html");
    } else {
        echo "Erro ao cadastrar tema.";
    }
    
    // Fechar a conexão com o banco de dados
    $conn->close();
}
?>
