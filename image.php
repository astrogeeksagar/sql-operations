<?php
require_once('database.php');
$PDO = Database::connect();
$sql = "SELECT pfnum FROM newdata";
$stmt = $PDO->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$imagedir = "facephoto/";

$existingImages = scandir($imagedir);
$existingImages = array_diff($existingImages, ['.', '..']);
$pfnumWithoutImages = [];

foreach ($result as $row) {
    $pfnum = $row['pfnum'];
    $imageFileNames = [$pfnum . '.jpg', $pfnum . '.jpeg', $pfnum .'.png', $pfnum . '.PNG'];
    $imageExists = false;
    foreach ($imageFileNames as $imageName) {
        if (in_array($imageName, $existingImages)) {
            $imageExists = true;
            break;
        }
    }
    if (!$imageExists) {
        $pfnumWithoutImages[] = $pfnum;
    }
}
print_r($pfnumWithoutImages);
