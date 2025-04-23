<?php
// admin/index.php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

$error = '';

// Проверяем отправку формы входа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    // Проверяем, существует ли пользователь
    $query = "SELECT user_id, hash_pass FROM users WHERE login_name = :username";
    $user = executeQuery($pdo, $query, ['username' => $username]);

    if ($user && password_verify($password, $user[0]['hash_pass'])) {
        $_SESSION['user_id'] = $user[0]['user_id'];
        header('Location: articles.php');
        exit();
    } else {
        $error = "Неверное имя пользователя или пароль.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в админпанель</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div class="bg-white p-8 rounded shadow-md w-96">
    <h1 class="text-2xl font-semibold text-center text-gray-800">Вход в админпанель</h1>
    <?php if (!empty($error)): ?>
        <p class="text-red-500 text-center mt-4"><?= $error; ?></p>
    <?php endif; ?>
    <form method="POST" class="mt-6">
        <div class="mb-4">
            <label for="username" class="block text-gray-700 font-medium">Имя пользователя:</label>
            <input type="text" name="username" id="username" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-medium">Пароль:</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:ring-blue-300">
        </div>
        <button type="submit"
                class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition duration-200">
            Войти
        </button>
    </form>
</div>
</body>
</html>