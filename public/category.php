<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Получаем параметры
$categoryId = intval($_GET['id'] ?? 0);
$type       = $_GET['type'] ?? '';

// Проверяем корректность
if (!in_array($type, ['games', 'movies'], true) || $categoryId <= 0) {
    die('<h1>Некорректный запрос.</h1>');
}

// Берём данные самой категории
$sql = "SELECT name, type FROM categories WHERE category_id = :id AND type = :type";
$cat  = executeQuery($pdo, $sql, ['id' => $categoryId, 'type' => $type]);

if (empty($cat)) {
    die('<h1>Категория не найдена.</h1>');
}
$category = $cat[0];

// Заголовок страницы и мета
$pageTitle       = 'Категория: ' . htmlspecialchars($category['name'], ENT_QUOTES);
$metaDescription = 'Статьи из раздела «' . htmlspecialchars($category['name'], ENT_QUOTES) . '»';

// Подключаем шапку
include '../templates/header.php';
?>

    <div class="flex-1 space-y-8">

        <h1 class="text-3xl font-bold">
            Категория: <?= htmlspecialchars($category['name'], ENT_QUOTES) ?>
            <span class="text-sm text-neutral-400 ml-2">(<?= $category['type'] === 'games' ? 'Игры' : 'Фильмы' ?>)</span>
        </h1>

        <?php
        // Получаем статьи по категории
        $sql = "
      SELECT a.title, a.summary, a.slug, a.publication_date
      FROM articles a
      JOIN article_categories ac ON a.article_id = ac.article_id
      WHERE ac.category_id = :id
      ORDER BY a.publication_date DESC
    ";
        $articles = executeQuery($pdo, $sql, ['id' => $categoryId]);
        ?>

        <?php if (!empty($articles)): ?>
            <?php foreach ($articles as $article): ?>
                <article class="border-b border-neutral-800 pb-6">
                    <div class="text-sm text-neutral-400 mb-1">
                        <?= formatDateRu($article['publication_date']) ?>
                    </div>

                    <h2 class="text-lg font-semibold">
                        <?= htmlspecialchars_decode($article['title'], ENT_QUOTES) ?>
                    </h2>

                    <div class="text-neutral-300 mt-2">
                        <?= htmlspecialchars_decode($article['summary'], ENT_QUOTES) ?>
                    </div>

                    <a href="article.php?slug=<?= htmlspecialchars($article['slug'], ENT_QUOTES) ?>"
                       class="inline-block mt-2 text-sky-600 hover:underline">
                        Читать далее →
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-neutral-400">Для этой категории статей пока нет.</p>
        <?php endif; ?>

    </div>

<?php
include '../templates/sidebar.php';
include '../templates/footer.php';