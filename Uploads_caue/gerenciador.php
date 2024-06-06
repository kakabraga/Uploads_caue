<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Arquivos</title>
    <style>
        #teste{position:relative}
        #teste:hover{top:-1px;box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1)}

        body{
            background-color: #F2F2F2;
        }

    .texto{
        padding: 5px;
        text-align: center;
        font-family:'Times New Roman', Times, serif, sans-serif;
        padding: 10px;
    }

    .pdf{
        background-color: #F2F2F2;
        border: solid gray 1px;
        width: 250px;
        height: 15px;
        border-radius: 3px;
        box-shadow: 2px 2px 4px 2px rgba(0, 0, 0, 0.1);
        padding: 1px;
        
    }

    .pdf2{
        background-color: #81DAF5;
        border-top: 5px solid #2E9AFE ;
        width: 293px;
        height: relative;
        border-radius: 4px;
        padding: 4px;
    }

    .opcoes{
        float: right;
        font-size: 13px;
        font-family: Arial, Helvetica, sans-serif;
        padding: 2px;
        text-decoration: none;
        border-radius: 2px;
        box-shadow: 0px 2px 3px  0px rgba(0, 0, 0, 0.1);
        padding: 2px;
    }
    </style>
    <script>
    function deleteFile(fileName, listItem) {
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "deletar.php?file=" + fileName, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log("Arquivo deletado");
                listItem.remove();
            }
        };
        xhr.send();
    }
    </script>
</head>
<body>
    <h1 class="texto">Arquivos Carregados</h1>
    <ul>
        <?php
        $uploadDir = 'uploads/';
        $files = array_diff(scandir($uploadDir), array('.', '..'));

        foreach ($files as $file) {
            echo "<li id='file-$file'>
                    $file
                    <a  href='javascript:void(0);' onclick=\"deleteFile('$file', this.parentNode)\">Excluir</a>
                  </li>";
        }
        ?>
    </ul>
</body>
</html>