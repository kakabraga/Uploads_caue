<?php
require 'vendor/autoload.php';

use Smalot\PdfParser\Parser;

// Cria uma instância do Parser
$parser = new Parser();

if (!empty($_FILES['file'])) {
    $targetDir = 'uploads/';
    $filename = basename($_FILES['file']['name']);
    $targetFilePath = $targetDir . $filename;
    $outputFile = 'output.txt';

    // Verifica se o diretório de uploads existe, se não, cria
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
        echo 'Arquivo enviado';

        try {
            // Tenta analisar o arquivo PDF
            $pdf = $parser->parseFile($targetFilePath);
            
            // Obtém o texto do PDF
            $text = $pdf->getText();
            
            // Salva o texto em um arquivo
            file_put_contents($outputFile, $text);
            
            echo "Arquivo de texto criado com sucesso!";
        } catch (Exception $e) {
            echo "Erro ao processar o PDF: " . $e->getMessage();
        }
    } else {
        echo 'Erro ao mover o arquivo para o diretório de uploads.';
    }
} else {
    echo 'Nenhum arquivo enviado ou ocorreu um erro no envio.';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Selecionar Linhas</title>
</head>
<body>
    <h1>Selecione as linhas para exibir</h1>

    <form action="display.php" method="post">
        <?php
        // Verifica se o arquivo de texto existe antes de tentar lê-lo
        if (file_exists('output.txt')) {
            $lines = file('output.txt'); // Arquivo de texto convertido
            
            // Exibe cada linha com um checkbox
            foreach ($lines as $index => $line) {
                echo '<input type="checkbox" name="lines[]" value="' . $index . '"> Linha ' . ($index + 1) . ': ' . htmlspecialchars($line) . '<br>';
            }
        } else {
            echo 'Nenhum arquivo de texto encontrado.';
        }
        ?>
        <input type="submit" value="Exibir Selecionado">     
    </form>
</body>
</html>
