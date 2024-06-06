<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = 'uploads/' . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "Arquivo $file excluído com sucesso!";
    } else {
        echo "Arquivo não encontrado.";
    }
}
?>
<br>
<a href="gerenciador.php">Voltar</a>
