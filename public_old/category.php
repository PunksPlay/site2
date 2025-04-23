<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$categoryId = intval($_GET['id'] ?? 0);
$type = $_GET['type'] ?? '';

if (!in_array($type, ['games', 'movies'])) {
    die('Некорректный тип категории.');
}

// Получение категории
$categoryQuery = "SELECT * FROM categories WHERE category_id = :category_id AND type = :type";
$category = executeQuery($pdo, $categoryQuery, ['category_id' => $categoryId, 'type' => $type])[0];

if (!$category) {
    die('Категория не найдена.');
}

// Получение статей по категории
$articlesQuery = "SELECT a.* 
                  FROM articles a 
                  JOIN article_categories ac ON a.article_id = ac.article_id 
                  WHERE ac.category_id = :category_id 
                  ORDER BY a.publication_date DESC";
$articles = executeQuery($pdo, $articlesQuery, ['category_id' => $categoryId]);

$pageTitle = 'Категория: ' . htmlspecialchars($category['name'], ENT_QUOTES);
include '../templates/header.php';
?>

    <h1>Категория: <?= htmlspecialchars($category['name'], ENT_QUOTES); ?> (<?= $category['type']; ?>)</h1>

<?php if ($articles): ?>
    <div class="articles-list">
        <?php foreach ($articles as $article): ?>
            <div class="article-item">
                <h3><a href="article.php?id=<?= $article['article_id']; ?>"><?= htmlspecialchars($article['title'], ENT_QUOTES); ?></a></h3>
                <p><?= htmlspecialchars($article['summary'], ENT_QUOTES); ?></p>
                <div class="article-date"><?= date('d F Y H:i', strtotime($article['publication_date'])); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Статьи для данной категории отсутствуют.</p>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>