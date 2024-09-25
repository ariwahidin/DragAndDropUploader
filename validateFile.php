<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];

        // File validation: You can adjust the allowed MIME types and max size as needed
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Adjust this as per your needs
        $maxFileSize = 5 * 1024 * 1024; // Maximum file size (5 MB in this example)

        // Get file MIME type and size
        $fileMimeType = mime_content_type($file['tmp_name']);
        $fileSize = $file['size'];

        // Validate MIME type
        if (in_array($fileMimeType, $allowedMimeTypes) && $fileSize <= $maxFileSize) {
            // File is valid
            echo 'true';
        } else {
            // File is invalid
            echo 'false';
        }
    } else {
        echo 'false'; // No file uploaded
    }
} else {
    echo 'false'; // Invalid request method
}
