<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Arquivos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        .drop-section {
            border: 5px dashed #ccc;
            padding: 50px;
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
            transition: border-color 0.3s;
        }

        .drag-over-effect {
            border-color: #007bff;
            animation-delay: 3s;
            animation-delay: 0s;
            animation-delay: -1500ms;

        }

        .file-selector-button, .upload-all-button, .upload-single-button {
            cursor: pointer;
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 5px;
            transition: background-color 0.3s;
        }

        .file-selector-button:hover, .upload-all-button:hover, .upload-single-button:hover {
            background-color: #0056b3;
        }

        .list-section {
            width: 80%;
            max-width: 600px;
            margin-top: 20px;
        }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }

        .list li.in-prog {
            background-color: #f0f8ff;
        }

        .list li.complete {
            background-color: #e6ffed;
        }

        .list .col {
            display: flex;
            align-items: center;
        }

        .list .col img {
            width: 40px;
            margin-right: 15px;
        }

        .list .file-name {
            font-size: 16px;
            margin-right: 15px;
        }

        .list .file-progress span {
            display: block;
            height: 5px;
            background-color: #007bff;
            width: 0;
            transition: width 0.3s;
        }

        .list .file-size {
            margin-left: auto;
            margin-right: 15px;
            font-size: 14px;
            color: #666;
        }

        .list .cross, .list .upload-single-button {
            margin-left: 10px;
            fill: #ff5b5b;
            cursor: pointer;
            transition: fill 0.3s;
        }

        .list .cross:hover {
            fill: #ff0000;
        }

        .list .upload-single-button {
            background-color: transparent;
            color: #007bff;
            padding: 5px 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
        }

        .list .upload-single-button:hover {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="drop-section">Solte seus arquivos aqui</div>
    <button class="file-selector-button">Buscar arquivos</button>
    <input type="file" class="file-selector-input" multiple style="display: none;">
    <button class="upload-all-button" id="uploadButton" >Enviar Todos</button>
    <div class="list-section">
        <ul class="list"></ul>
    </div>
    
    <script>
        const dropArea = document.querySelector('.drop-section');
        const listSection = document.querySelector('.list-section');
        const listContainer = document.querySelector('.list');
        const fileSelectorButton = document.querySelector('.file-selector-button');
        const fileSelectorInput = document.querySelector('.file-selector-input');
        const uploadButton = document.getElementById('uploadButton');
        let filesToUpload = [];

        fileSelectorButton.onclick = () => fileSelectorInput.click();

        fileSelectorInput.onchange = () => {
            [...fileSelectorInput.files].forEach((file) => {
                if (typeValidation(file.type)) {
                    addFileToList(file);
                }
            });
        };

        dropArea.ondragover = (e) => {
            e.preventDefault();
            [...e.dataTransfer.items].forEach((item) => {
                if (typeValidation(item.type)) {
                    dropArea.classList.add('drag-over-effect');
                }
            });
        };

        dropArea.ondragleave = () => {
            dropArea.classList.remove('drag-over-effect');
        };

        dropArea.ondrop = (e) => {
            e.preventDefault();
            dropArea.classList.remove('drag-over-effect');
            if (e.dataTransfer.items) {
                [...e.dataTransfer.items].forEach((item) => {
                    if (item.kind === 'file') {
                        const file = item.getAsFile();
                        if (typeValidation(file.type)) {
                            addFileToList(file);
                        }
                    }
                });
            } else {
                [...e.dataTransfer.files].forEach((file) => {
                    if (typeValidation(file.type)) {
                        addFileToList(file);
                    }
                });
            }
        };

        function typeValidation(type) {
            var splitType = type.split('/')[0];
            return type === 'application/pdf' || splitType === 'image' || splitType === 'video';
        }

        function addFileToList(file) {
            listSection.style.display = 'block';
            var li = document.createElement('li');
            li.classList.add('in-prog');
            li.innerHTML = `
                <div class="col">
                    <img src="imagens/${iconSelector(file.type)}" alt="">
                </div>
                <div class="col">
                    <div class="file-name">
                        <div class="name">${file.name}</div>
                        <span>0%</span>
                    </div>
                    <div class="file-progress">
                        <span></span>
                    </div>
                    <div class="file-size">${(file.size / (1024 * 1024)).toFixed(5)} MB</div>
                </div>
                <div class="col">
                    <svg xmlns="http://www.w3.org/2000/svg" class="cross" height="20" width="20">
                        <path d="m5.979 14.917-.854-.896 4-4.021-4-4.062.854-.896 4.042 4.062 4-4.062.854.896-4 4.062 4 4.021-.854.896-4-4.063Z"/>
                    </svg>
                    <button class="upload-single-button">Enviar</button>
                </div>`;
            listContainer.prepend(li);

            // Adiciona o arquivo e o elemento li à lista de arquivos para upload
            filesToUpload.push({ file, li });

            // Adiciona o evento de clique ao botão de exclusão
            li.querySelector('.cross').onclick = () => removeFileFromList(file, li);

            // Adiciona o evento de clique ao botão de envio individual
            li.querySelector('.upload-single-button').onclick = () => uploadFile(file, li);
        }

        function removeFileFromList(file, li) {
            // Remove o arquivo da lista de arquivos para upload
            filesToUpload = filesToUpload.filter(item => item.file !== file);
            // Remove o elemento li do DOM
            li.remove();
            // Se a lista estiver vazia, esconde a seção da lista
            if (filesToUpload.length === 0) {
                listSection.style.display = 'none';
            }
        }

        uploadButton.onclick = () => {
            filesToUpload.forEach(({ file, li }) => {
                uploadFile(file, li);
            });
            filesToUpload = [];
        };

        function uploadFile(file, li) {
            var http = new XMLHttpRequest();
            var data = new FormData();
            data.append('file', file);
            http.onload = () => {
                li.classList.add('complete');
                li.classList.remove('in-prog');
            };
            http.upload.onprogress = (e) => {
                var percent_complete = (e.loaded / e.total) * 100;
                li.querySelectorAll('span')[0].innerHTML = Math.round(percent_complete) + '%';
                li.querySelectorAll('span')[1].style.width = percent_complete + '%';
            };
            http.open('POST', 'extract_text.php', true);
            http.send(data);
        }

        function iconSelector(type) {
            var splitType = (type.split('/')[0] == 'application') ? type.split('/')[1] : type.split('/')[0];
            return splitType + '.png';
        }
    </script>
</body>
</html>