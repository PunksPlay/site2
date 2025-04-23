<?php
// admin/search_articles.php
require_once '../includes/db.php'; // Подключение к базе данных
require_once '../includes/functions.php'; // Подключение общих функций
session_start(); // Запуск сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Перенаправление на страницу входа
    exit();
}

$rubric = '';
$articles = [];

// Если форма отправлена
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rubric = sanitizeInput($_POST['rubric']);

    // Поиск статей по выбранной рубрике
    $query = "
        SELECT a.article_id, a.title, a.publication_date 
        FROM articles AS a
        JOIN article_categories AS ac ON a.article_id = ac.article_id
        JOIN categories AS c ON ac.category_id = c.category_id
        WHERE c.name = :rubric
        ORDER BY a.publication_date DESC";
    $articles = executeQuery($pdo, $query, ['rubric' => $rubric]);
}
?>

<?php include '../templates/admin_header.php'; ?>

<h1>Поиск статей по рубрике</h1>

<!-- Форма поиска -->
<form method="POST">
    <label for="rubric">Выберите рубрику:</label>
    <input type="text" name="rubric" id="rubric" value="<?= $rubric; ?>" required>
    <button type="submit">Искать</button>
</form>

<?php if ($articles): ?>
    <h2>Результаты поиска</h2>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Дата публикации</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $article['article_id']; ?></td>
                <td><?= sanitizeInput($article['title']); ?></td>
                <td><?= date("d F Y", strtotime($article['publication_date'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>Ни одной статьи не найдено для рубрики "<?= $rubric; ?>".</p>
<?php endif; ?>
</div>
</body>
</html>