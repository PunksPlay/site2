<?php
// includes/db.php

// Параметры подключения к базе данных
$host = 'localhost';
$db_name = 'crp-db';
$username = 'root';
$password = 'Va8Gs2yOf2vSgX9!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}
