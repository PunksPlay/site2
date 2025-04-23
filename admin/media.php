<?php
// admin/media.php
require_once '../includes/db.php'; // Подключение к базе данных
require_once '../includes/functions.php'; // Подключение общих функций
session_start(); // Запуск сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Перенаправление на страницу входа
    exit();
}

// Получение списка статей с изображениями
$query = "SELECT article_id, title, image_path FROM articles ORDER BY publication_date DESC";
$articles = executeQuery($pdo, $query);

// Удаление изображения
if (isset($_GET['delete'])) {
    $articleId = intval($_GET['delete']);
    $imageQuery = "SELECT image_path FROM articles WHERE article_id = :article_id";
    $imageData = executeQuery($pdo, $imageQuery, ['article_id' => $articleId]);

    if ($imageData && file_exists('../assets/images/' . $imageData[0]['image_path'])) {
        unlink('../assets/images/' . $imageData[0]['image_path']); // Удаляем файл изображения
    }

    $updateQuery = "UPDATE articles SET image_path = NULL WHERE article_id = :article_id";
    executeQuery($pdo, $updateQuery, ['article_id' => $articleId]);

    header('Location: media.php');
    exit();
}

// Замена изображения
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $articleId = intval($_POST['article_id']);
    $newImage = sanitizeInput($_FILES['new_image']['name']);
    $uploadDir = '../assets/images/';
    $uploadFile = $uploadDir . basename($newImage);

    if (move_uploaded_file($_FILES['new_image']['tmp_name'], $uploadFile)) {
        $updateQuery = "UPDATE articles SET image_path = :image_path WHERE article_id = :article_id";
        executeQuery($pdo, $updateQuery, [
            'image_path' => $newImage,
            'article_id' => $articleId,
        ]);
    }

    header('Location: media.php');
    exit();
}
?>

<?php include '../templates/admin_header.php'; ?>

<h1>Управление изображениями</h1>
<table>
    <thead>
    <tr>
        <th>Название статьи</th>
        <th>Текущее изображение</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= sanitizeInput($article['title']); ?></td>
            <td>
                <?php if (!empty($article['image_path'])): ?>
                    <img src="../assets/images/<?= sanitizeInput($article['image_path']); ?>" alt="Изображение статьи" width="100">
                <?php else: ?>
                    Нет изображения
                <?php endif; ?>
            </td>
            <td>
                <!-- Удаление изображения -->
                <a href="media.php?delete=<?= $article['article_id']; ?>" onclick="return confirm('Удалить изображение?');">Удалить</a>
                <!-- Замена изображения -->
                <form method="POST" enctype="multipart/form-data" style="display:inline;">
                    <input type="hidden" name="article_id" value="<?= $article['article_id']; ?>">
                    <input type="file" name="new_image" required>
                    <button type="submit">Заменить</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
</body>
</html>