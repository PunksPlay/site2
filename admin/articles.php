<?php
/**
 * admin/articles.php
 * Управление статьями: список, фильтрация, действия (редактирование, удаление, закрепление)
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); exit;
}

// Обработка действий: удаление, закрепление, открепление
if (isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM articles WHERE article_id = :id")->execute([':id'=>(int)$_GET['delete']]);
    header('Location: articles.php'); exit;
}
if (isset($_GET['pin'])) {
    $pdo->prepare("UPDATE articles SET pinned = 1 WHERE article_id = :id")->execute([':id'=>(int)$_GET['pin']]);
    header('Location: articles.php'); exit;
}
if (isset($_GET['unpin'])) {
    $pdo->prepare("UPDATE articles SET pinned = 0 WHERE article_id = :id")->execute([':id'=>(int)$_GET['unpin']]);
    header('Location: articles.php'); exit;
}

// Фильтры
$filterSql = '1=1';
$params    = [];

// По рубрике
if (!empty($_GET['category'])) {
    $filterSql .= ' AND ac.category_id = :category';
    $params[':category'] = (int)$_GET['category'];
}
// По автору
if (!empty($_GET['author'])) {
    $filterSql .= ' AND a.author_id = :author';
    $params[':author'] = (int)$_GET['author'];
}
// По дате
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $filterSql .= ' AND DATE(a.publication_date) BETWEEN :start AND :end';
    $params[':start'] = $_GET['start_date'];
    $params[':end']   = $_GET['end_date'];
}

// Данные для фильтров
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$authors    = $pdo->query("SELECT user_id, public_name FROM users ORDER BY public_name")->fetchAll(PDO::FETCH_ASSOC);

// Запрос статей
$sql = "
    SELECT DISTINCT
        a.article_id,
        a.title,
        COALESCE(u.public_name, '—') AS author,
        a.publication_date,
        a.pinned
    FROM articles a
    LEFT JOIN users u ON a.author_id = u.user_id
    LEFT JOIN article_categories ac ON a.article_id = ac.article_id
    WHERE $filterSql
    ORDER BY a.publication_date DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

include __DIR__ . '/../templates/admin_header.php';
?>
<main class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-neutral-100">Список статей</h1>
        <a href="add_article.php" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">Добавить статью</a>
    </div>

    <!-- Фильтрация -->
    <form method="GET" class="bg-neutral-800 p-4 rounded grid gap-4 sm:grid-cols-5">
        <div>
            <label for="category" class="block text-neutral-300 mb-1">Рубрика</label>
            <select name="category" id="category" class="w-full bg-neutral-700 text-neutral-100 px-3 py-2 rounded">
                <option value="">Все</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= (isset($_GET['category']) && $_GET['category']==$cat['category_id'])?'selected':'' ?>>
                        <?= htmlspecialchars($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="author" class="block text-neutral-300 mb-1">Автор</label>
            <select name="author" id="author" class="w-full bg-neutral-700 text-neutral-100 px-3 py-2 rounded">
                <option value="">Все</option>
                <?php foreach ($authors as $au): ?>
                    <option value="<?= $au['user_id'] ?>" <?= (isset($_GET['author']) && $_GET['author']==$au['user_id'])?'selected':'' ?>>
                        <?= htmlspecialchars($au['public_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label for="start_date" class="block text-neutral-300 mb-1">Дата с</label>
            <input type="date" name="start_date" id="start_date" value="<?= $_GET['start_date'] ?? '' ?>" class="w-full bg-neutral-700 text-neutral-100 px-3 py-2 rounded">
        </div>
        <div>
            <label for="end_date" class="block text-neutral-300 mb-1">Дата по</label>
            <input type="date" name="end_date" id="end_date" value="<?= $_GET['end_date'] ?? '' ?>" class="w-full bg-neutral-700 text-neutral-100 px-3 py-2 rounded">
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-sky-600 hover:bg-sky-700 text-white px-3 py-2 rounded">Применить</button>
        </div>
    </form>

    <!-- Таблица -->
    <div class="overflow-x-auto bg-neutral-800 rounded">
        <table class="min-w-full divide-y divide-neutral-700">
            <thead class="bg-neutral-900">
            <tr>
                <th class="text-neutral-300 px-4 py-2 text-left">Заголовок</th>
                <th class="text-neutral-300 px-4 py-2 text-left">Автор</th>
                <th class="text-neutral-300 px-4 py-2 text-left">Дата</th>
                <th class="text-neutral-300 px-4 py-2 text-center">Закрепл.</th>
                <th class="text-neutral-300 px-4 py-2 text-center">Действия</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-neutral-700">
            <?php if (!$articles): ?>
                <tr><td colspan="5" class="px-4 py-6 text-center text-neutral-400">Нет статей по критериям</td></tr>
            <?php endif; ?>
            <?php foreach ($articles as $art): ?>
                <tr class="hover:bg-neutral-700">
                    <td class="px-4 py-3 text-neutral-100"><?= htmlspecialchars($art['title']) ?></td>
                    <td class="px-4 py-3 text-neutral-100"><?= htmlspecialchars($art['author']) ?></td>
                    <td class="px-4 py-3 text-neutral-100"><?= htmlspecialchars($art['publication_date']) ?></td>
                    <td class="px-4 py-3 text-center text-neutral-100"><?= $art['pinned']? '✔':''?></td>
                    <td class="px-4 py-3 text-center space-x-2">
                        <a href="edit_article.php?id=<?= $art['article_id'] ?>" class="text-sky-400 hover:text-sky-200">Ред.</a>
                        <a href="?delete=<?= $art['article_id'] ?>" class="text-red-500 hover:text-red-300" onclick="return confirm('Удалить статью?')">Удал.</a>
                        <?php if ($art['pinned']): ?>
                            <a href="?unpin=<?= $art['article_id'] ?>" class="text-yellow-400 hover:text-yellow-300">Откр.</a>
                        <?php else: ?>
                            <a href="?pin=<?= $art['article_id'] ?>" class="text-green-400 hover:text-green-300">Закр.</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
<?php include __DIR__ . '/../templates/admin_footer.php'; ?>
