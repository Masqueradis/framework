<?php

declare(strict_types=1);

$dbh = new PDO('pgsql:host=FrameworkTask_db;dbname=app_db', 'user', 'root');

$conditions = [];
$params = [];

if (isset($_GET['country'])) {
    $conditions[] = 'country = ?';
    $params[] = $_GET['country']; 
}

if (isset($_GET['city'])) {
    $conditions[] = 'city = ?';
    $params[] = $_GET['city']; 
}

if (isset($_GET['gender'])) {
    $conditions[] = 'gender = ?';
    $params[] = $_GET['gender']; 
}

if (isset($_GET['family_status'])) {
    $conditions[] = 'family_status = ?';
    $params[] = $_GET['family_status']; 
}

if (isset($_GET['is_active']) && $_GET['is_active'] !== '') {
    $conditions[] = 'is_active = ?';
    $params[] = ($_GET['is_active'] == '1' || strtoupper($_GET['is_active']) == 'TRUE') ? 1 : 0;
}

if (isset($_GET['has_children']) && $_GET['has_children'] !== '') {
    $conditions[] = 'has_children = ?';
    $params[] = ($_GET['has_children'] == '1' || strtoupper($_GET['has_children']) == 'TRUE') ? 1 : 0;
}

if (isset($_GET['birth_date_from'])) {
    $conditions[] = 'birth_date >= ?';
    $params[] = $_GET['birth_date_from'];
}

if (isset($_GET['birth_date_to'])) {
    $conditions[] = 'birth_date <= ?';
    $params[] = $_GET['birth_date_to'];
}

if (isset($_GET['registration_date_from'])) {
    $conditions[] = 'registration_date >= ?';
    $params[] = $_GET['registration_date_from'];
}

if (isset($_GET['registration_date_to'])) {
    $conditions[] = 'registration_date <= ?';
    $params[] = $_GET['registration_date_to'];
}

if (isset($_GET['salary_from'])) {
    $conditions[] = 'salary >= ?';
    $params[] = $_GET['salary_from'];
}

if (isset($_GET['salary_to'])) {
    $conditions[] = 'salary <= ?';
    $params[] = $_GET['salary_to'];
}

$sql = 'SELECT * FROM users';

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$stmt = $dbh->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<form method="GET">';
echo '<div>Страна: <input type="text" name="country"></div>';
echo '<div>Город: <input type="text" name="city"></div>';
echo '<div>Пол: <input type="text" name="gender"></div>';
echo '<div>Активен: <input type="text" name="is_active"></div>';
echo '<div>Дети: <input type="text" name="has_children"></div>';
echo '<div>Семейный статус: <input type="text" name="family_status"></div>';
echo '<div>Дата рождения от: <input type="date" name="birth_date_from"></div>';
echo '<div>Дата рождения до: <input type="date" name="birth_date_to"></div>';
echo '<div>Дата регистрации от: <input type="date" name="registration_date_from"></div>';
echo '<div>Дата регистрации до: <input type="date" name="registration_date_to"></div>';
echo '<div>Зарплата от: <input type="number" name="salary_from"></div>';
echo '<div>Зарплата до: <input type="number" name="salary_to"></div>';
echo '<input type="submit" value="Фильтровать">';
echo '</form>';

if ($results) {
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>Страна</th>';
    echo '<th>Город</th>';
    echo '<th>Активен</th>';
    echo '<th>Пол</th>';
    echo '<th>Дата рождения</th>';
    echo '<th>Зарплата</th>';
    echo '<th>Дети</th>';
    echo '<th>Семейный статус</th>';
    echo '<th>Дата регистрации</th>';
    echo '</tr>';
    
    foreach ($results as $row) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['country'] . '</td>';
        echo '<td>' . $row['city'] . '</td>';
        echo '<td>' . $row['is_active'] . '</td>';
        echo '<td>' . $row['gender'] . '</td>';
        echo '<td>' . $row['birth_date'] . '</td>';
        echo '<td>' . $row['salary'] . '</td>';
        echo '<td>' . $row['has_children'] . '</td>';
        echo '<td>' . $row['family_status'] . '</td>';
        echo '<td>' . $row['registration_date'] . '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
}

?>