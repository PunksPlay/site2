<?php
// admin/articles.php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$filterQuery = "1 = 1"; // Базовый фильтр, чтобы добавлять условия
$params = [];

// Фильтр по рубрике
if (!empty($_GET['category'])) {
    $filterQuery .= " AND ac.category_id = :category_id";
    $params['category_id'] = intval($_GET['category']);
}

// Фильтр по диапазону дат
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $filterQuery .= " AND a.publication_date BETWEEN :start_date AND :end_date";
    $params['start_date'] = $_GET['start_date'];
    $params['end_date'] = $_GET['end_date'];
}

// Запрос для получения отфильтрованных статей
$query = "
    SELECT a.article_id, a.title, a.publication_date, a.pinned
    FROM articles AS a
    LEFT JOIN article_categories AS ac ON a.article_id = ac.article_id
    WHERE $filterQuery
    ORDER BY a.publication_date DESC";
$articles = executeQuery($pdo, $query, $params);

// Получение рубрик для фильтра
$categories = executeQuery($pdo, "SELECT * FROM categories ORDER BY name ASC");

// Получение списка статей
$query = "SELECT article_id, title, publication_date, pinned FROM articles ORDER BY publication_date DESC";
$articles = executeQuery($pdo, $query);

// Удаление статьи
if (isset($_GET['delete'])) {
    $articleId = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM articles WHERE article_id = :article_id";
    executeQuery($pdo, $deleteQuery, ['article_id' => $articleId]);
    header('Location: articles.php');
    exit();
}

// Закрепление статьи
if (isset($_GET['pin'])) {
    $articleId = intval($_GET['pin']);
    $pinQuery = "UPDATE articles SET pinned = 1 WHERE article_id = :article_id";
    executeQuery($pdo, $pinQuery, ['article_id' => $articleId]);
    header('Location: articles.php');
    exit();
}

// Открепление статьи
if (isset($_GET['unpin'])) {
    $articleId = intval($_GET['unpin']);
    $unpinQuery = "UPDATE articles SET pinned = 0 WHERE article_id = :article_id";
    executeQuery($pdo, $unpinQuery, ['article_id' => $articleId]);
    header('Location: articles.php');
    exit();
}
?>

<?php include('../templates/admin_header.php') ?>
<main class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold text-center mb-8">Управление статьями</h1>
    <form method="GET" class="bg-neutral-800 p-4 rounded mb-6">
        <div class="flex flex-wrap gap-4">
            <div>
                <label for="category" class="block text-neutral-200">Рубрика:</label>
                <select name="category" id="category"
                        class="bg-neutral-700 text-neutral-100 border border-neutral-600 rounded py-2 px-3 focus:outline-none focus:ring focus:ring-neutral-500">
                    <option value="">Все</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['category_id']; ?>" <?= (isset($_GET['category']) && $_GET['category'] == $category['category_id']) ? 'selected' : ''; ?>>
                            <?= sanitizeInput($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label for="start_date" class="block text-neutral-200">Дата с:</label>
                <input type="date" name="start_date" id="start_date" value="<?= $_GET['start_date'] ?? ''; ?>"
                       class="bg-neutral-700 text-neutral-100 border border-neutral-600 rounded py-2 px-3 focus:outline-none focus:ring focus:ring-neutral-500">
            </div>
            <div>
                <label for="end_date" class="block text-neutral-200">по:</label>
                <input type="date" name="end_date" id="end_date" value="<?= $_GET['end_date'] ?? ''; ?>"
                       class="bg-neutral-700 text-neutral-100 border border-neutral-600 rounded py-2 px-3 focus:outline-none focus:ring focus:ring-neutral-500">
            </div>
            <button type="submit"
                    class="bg-neutral-700 hover:bg-neutral-600 text-white py-2 px-4 rounded">
                Фильтровать
            </button>
        </div>
    </form>
    <table class="w-full bg-neutral-800 rounded">
        <thead>
        <tr>
            <th class="text-neutral-300 py-3 px-4 border-b border-neutral-700">Заголовок</th>
            <th class="text-neutral-300 py-3 px-4 border-b border-neutral-700">Дата публикации</th>
            <th class="text-neutral-300 py-3 px-4 border-b border-neutral-700">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td class="py-3 px-4 border-b border-neutral-700"><?= sanitizeInput($article['title']); ?></td>
                <td class="py-3 px-4 border-b border-neutral-700"><?= sanitizeInput($article['publication_date']); ?></td>
                <td class="py-3 px-4 border-b border-neutral-700">
                    <a href="edit_article.php?id=<?= $article['article_id']; ?>"
                       class="text-neutral-400 hover:text-neutral-200">Редактировать</a>
                    <a href="articles.php?delete=<?= $article['article_id']; ?>"
                       class="text-neutral-400 hover:text-neutral-200" onclick="return confirm('Удалить статью?');">Удалить</a>
                    <?php if (isset($article['pinned']) && $article['pinned']): ?>
                        <a href="articles.php?unpin=<?= $article['article_id']; ?>"
                           class="text-neutral-400 hover:text-neutral-200">Открепить</a>
                    <?php else: ?>
                        <a href="articles.php?pin=<?= $article['article_id']; ?>"
                           class="text-neutral-400 hover:text-neutral-200">Закрепить</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</main>
</body>
</html>