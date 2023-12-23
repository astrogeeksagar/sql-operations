<?php
require_once('database.php');
$PDO = Database::connect();

$mainFolder = 'main/';
$sql = 'SELECT id FROM checkdc';
$stmt = $PDO->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    $id = $row['id'];
    $subfolder = $mainFolder . $id . '/';
    if (is_dir($subfolder)) {
        $allowedFiles = [];
        foreach (['face', 'sign', 'age', 'comm'] as $allowedWord) {
            $allowedFiles[$allowedWord] = null;
        }
        $files = scandir($subfolder);

        foreach ($files as $file) {
            if (is_file($subfolder . $file)) {
                $filenameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);

                foreach (['face', 'sign', 'age', 'comm'] as $allowedWord) {
                    if (stripos($filenameWithoutExtension, $allowedWord) !== false) {
                        if ($allowedFiles[$allowedWord] === null) {
                            $allowedFiles[$allowedWord] = $file;
                        } else {
                            unlink($subfolder . $file);
                        }
                        break;
                    }
                }
            }
        }
        // Delete all files that are not in $allowedFiles
        foreach ($files as $file) {
            if (is_file($subfolder . $file) && !in_array($file, $allowedFiles)) {
                unlink($subfolder . $file);
            }
        }
    }

    echo "Files in subfolder $id have been processed, and only one file with each specified word is retained. Other files are deleted.</br>";
}
