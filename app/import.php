<?php

declare(strict_types=1);

$host = 'db';
$dbname = 'app_db';
$port = 5432;

$dbh = new PDO('pgsql:host=FrameworkTask_db;dbname=app_db', 'user', 'root');

$filename = 'Example.csv';

$file = fopen($filename, 'r');
$headers = fgetcsv($file, 1000, ',', '"', '\\');

$sql = 'INSERT INTO users (country, city, is_active, gender, birth_date, salary, has_children, family_status, registration_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
$stmt = $dbh->prepare($sql);


while (($row = fgetcsv($file, 1000, ',', '"', '\\')) !== FALSE) {
    $params = [
        $row[0],
        $row[1],
        strtoupper($row[2]) === 'TRUE' ? 1 : 0,
        $row[3],
        $row[4],
        strtoupper($row[5]) === 'TRUE' ? 1 : 0,
        $row[6],
        $row[7],
        $row[8],
    ];
    $stmt->execute($params);

    echo 'Added record: '. $row[0] . ','. $row[1] . PHP_EOL;
}

fclose($file);
