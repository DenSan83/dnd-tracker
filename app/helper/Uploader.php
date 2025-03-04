<?php

namespace app\helper;

class Uploader {
    private array $allowedExtensions = ['png', 'jpg', 'jpeg'];
    private int $maxMegasSize = 5; // 5MB

    public function send(array $image, string $filename, string $folder = '') {
        // Folder
        $targetDir = 'uploads/' . $folder . '/';
        if (!file_exists($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                return [
                    'success' => false,
                    'message' => 'Unable to create target directory'
                ];
            }
        }

        // Extension
        $fileExtension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $this->allowedExtensions)) {
            return [
                'success' => false,
                'message' => 'File extension not allowed'
            ];
        }

        // Size
        $maxSize = $this->maxMegasSize * 1024 * 1024;
        if ($image['size']['img'] > $maxSize) {
            return [
                'success' => false,
                'message' => 'File too large'
            ];
        }

        // Check if file already exists
        $baseFilename = pathinfo($filename, PATHINFO_FILENAME);
        $newFilename = $filename;
        $counter = 1;
        while (file_exists($targetDir . $newFilename)) {
            $newFilename = $baseFilename . $counter . '.' . $fileExtension;
            $counter++;
        }

        // Upload
        $targetFile = $targetDir . $newFilename;
        if (!move_uploaded_file($image['tmp_name']['img'], $targetFile)) {
            return [
                'success' => false,
                'message' => 'Failed to upload file'
            ];
        }

        // Success
        return [
            'success' => true,
            'filename' => $newFilename,
        ];
    }
}