<?php
require_once('database.php');

$PDO = Database::connect();

$sql = "SELECT sno, ipass_no FROM rrcphoto WHERE sno >= 1 AND sno <= 2000 ORDER BY sno";
$result = $PDO->query($sql);

$updateqry = "UPDATE rrcphoto SET photo_name = :photo_name WHERE ipass_no = :ipass_no";
$stmt = $PDO->prepare($updateqry);

$photo_folder = "Ecacandidates/facephoto/";
$supported_extensions = ['jpg', 'jpeg', 'png'];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $ipass_no = $row["ipass_no"];

    foreach ($supported_extensions as $extension) {
        $file_path = $photo_folder . $ipass_no . '.' . $extension;

        if (file_exists($file_path)) {
            $filename = basename($file_path);

            $stmt->bindParam(':photo_name', $filename);
            $stmt->bindParam(':ipass_no', $ipass_no);
            $stmt->execute();
        }
    }
}
