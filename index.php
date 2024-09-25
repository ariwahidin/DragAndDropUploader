<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload with Drag and Drop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        .upload-area {
            border: 2px dashed #007bff;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            background-color: #f8f9fa;
        }
        .upload-area.dragover {
            background-color: #e9ecef;
            border-color: #0056b3;
        }
        .file-list {
            margin-top: 20px;
        }
        .file-item {
            background-color: #f1f1f1;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-item:hover {
            background-color: #e9ecef;
        }
        .file-item .btn {
            margin-left: 10px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2 class="text-center mb-4">Drag and Drop File Upload</h2>
            
            <div id="uploadArea" class="upload-area">
                <p>Drag & Drop your files here or click to select</p>
                <input type="file" id="fileInput" multiple hidden>
                <button class="btn btn-primary" id="selectFilesBtn">Select Files</button>
            </div>

            <div id="fileList" class="file-list"></div>

            <div class="mt-4 text-center">
                <button id="uploadBtn" class="btn btn-success">Upload Files</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        var $uploadArea = $('#uploadArea');
        var $fileInput = $('#fileInput');
        var $fileList = $('#fileList');
        var selectedFiles = [];

        // Highlight drop area when file is dragged over it
        $uploadArea.on('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $uploadArea.addClass('dragover');
        });

        // Remove highlight when file is dragged away
        $uploadArea.on('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $uploadArea.removeClass('dragover');
        });

        // Handle file drop
        $uploadArea.on('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $uploadArea.removeClass('dragover');
            var files = e.originalEvent.dataTransfer.files;
            handleFiles(files);
        });

        // Handle file select via button
        $('#selectFilesBtn').on('click', function() {
            $fileInput.click();
        });

        $fileInput.on('change', function() {
            var files = this.files;
            handleFiles(files);
        });

        // Handle files
        function handleFiles(files) {
            for (var i = 0; i < files.length; i++) {
                selectedFiles.push(files[i]);
                renderFileList();
            }
        }

        // Render file list
        function renderFileList() {
            $fileList.empty();
            selectedFiles.forEach(function(file, index) {
                var fileItem = `
                    <div class="file-item" data-index="${index}">
                        <span>${file.name} (${Math.round(file.size / 1024)} KB)</span>
                        <button class="btn btn-danger btn-sm remove-file-btn">Remove</button>
                    </div>`;
                $fileList.append(fileItem);
            });
        }

        // Remove file from list
        $fileList.on('click', '.remove-file-btn', function() {
            var index = $(this).closest('.file-item').data('index');
            selectedFiles.splice(index, 1);
            renderFileList();
        });

        // Handle file upload
        $('#uploadBtn').on('click', function() {
            if (selectedFiles.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No files selected',
                    text: 'Please select files to upload.',
                    timer: 2000,
                    showConfirmButton: false
                });
                return;
            }

            var formData = new FormData();
            selectedFiles.forEach(function(file) {
                formData.append('files[]', file);
            });

            $.ajax({
                url: 'upload.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upload successful',
                        text: 'Files have been uploaded successfully!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    selectedFiles = [];
                    renderFileList();
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload failed',
                        text: 'There was an error uploading the files.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>

</body>
</html>
