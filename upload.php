<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $uploadDir = 'uploads/'; // Folder tujuan untuk menyimpan file yang di-upload
        $files = $_FILES['files'];

        // Buat folder 'uploads' jika belum ada
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $uploadedFiles = [];
        $totalFiles = count($files['name']);

        // Loop untuk memproses semua file yang di-upload
        // for ($i = 0; $i < $totalFiles; $i++) {
        //     $fileName = basename($files['name'][$i]);
        //     $fileTmpName = $files['tmp_name'][$i];
        //     $fileSize = $files['size'][$i];
        //     $fileError = $files['error'][$i];

        //     // Cek jika ada error saat upload file
        //     if ($fileError === UPLOAD_ERR_OK) {
        //         // Set path untuk menyimpan file
        //         $fileDestination = $uploadDir . $fileName;

        //         // Pindahkan file yang di-upload ke folder tujuan
        //         if (move_uploaded_file($fileTmpName, $fileDestination)) {
        //             $uploadedFiles[] = $fileName; // Tambahkan nama file ke daftar file yang berhasil di-upload
        //         } else {
        //             echo json_encode(['error' => 'Failed to upload file: ' . $fileName]);
        //             exit;
        //         }
        //     } else {
        //         echo json_encode(['error' => 'Error uploading file: ' . $fileName]);
        //         exit;
        //     }
        // }

        // Jika semua file berhasil di-upload, kirimkan respons sukses
        echo json_encode(['success' => true, 'uploadedFiles' => $uploadedFiles]);
    } else {
        echo json_encode(['error' => 'No files uploaded.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
