<?php

require_once('process/database.php');
$PDO = Database::connect();
$sql = "SELECT wid, dob FROM userdata WHERE sno >= 65000 AND sno <= 70000";
$stmt = $PDO->prepare($sql);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $candidateId = $row['wid'];
    $dob = $row['dob'];

    $dobDateTime = new DateTime($dob);
    $currentDate = new DateTime("2023-08-01");
    $ageInterval = $dobDateTime->diff($currentDate);

    $ageYear = $ageInterval->y;
    $ageMonths = $ageInterval->m;
    $ageDays = $ageInterval->d;

    $updateSql = "UPDATE userdata SET age_year = $ageYear, age_month = $ageMonths, age_day = $ageDays WHERE wid = '$candidateId'";
    $stmtup = $PDO->prepare($updateSql);
    $stmtup->execute();
    // echo "Age Updated Of User " . $candidateId . "</br>";
}