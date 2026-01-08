<?php

declare(strict_types=1);

$host = 'db';
$dbname = 'app_db';
$port = 5432;

$dbh = new PDO('pgsql:host=localhost;dbname=test', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

$filename = 'Example.csv';
$data = [];

$handle = fopen($filename, 'r');
$headers = fgetcsv($handle, 1000, ',', '"', '\\');

while (($row = fgetcsv($handle, 1000, ',', '"', '\\')) !== FALSE) {
    $rowData = array_combine($headers, $row);

    $data[] = [
        'country' => $rowData['country'],
        'city' => $rowData['city'],
        'isActive' => filter_var($rowData['isActive'], FILTER_VALIDATE_BOOLEAN),
        'gender' => $rowData['gender'],
        'birthDate' => DateTime::createFromFormat('Y-m-d', $rowData['birthDate']),
        'salary' => $rowData['salary'],
        'hasChildren' => filter_var($rowData['hasChildren'], FILTER_VALIDATE_BOOLEAN),
        'familyStatus' => $rowData['familyStatus'],
        'registrationDate' => DateTime::createFromFormat('Y-m-d', $rowData['birthDate'])
    ];
}

fclose($handle);

print_r($data);
