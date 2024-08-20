<?php
// Inicializa a variável para as linhas selecionadas
$selectedLines = [];

if (!empty($_POST['lines'])) {
    $selectedLines = $_POST['lines'];
}

// Função para processar o PDF e recuperar as linhas
function getLinesFromFile($filename) {
    $lines = [];
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    return $lines;
}

// Recupera as linhas do arquivo de texto
$lines = getLinesFromFile('output.txt');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Linhas Selecionadas</title>
</head>
<body>
    <h1>Linhas Selecionadas</h1>
    <?php if (!empty($selectedLines)): ?>
        <ul>
            <?php foreach ($selectedLines as $lineIndex): ?>
                <?php if (isset($lines[$lineIndex])): ?>
                    <li><?= htmlspecialchars($lines[$lineIndex]) ?></li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Nenhuma linha selecionada.</p>
    <?php endif; ?>
    <a href="index.php">Voltar</a>
</body>
</html>
