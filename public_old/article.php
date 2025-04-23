<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (isset($_GET['slug'])) {
    $slug = sanitizeInput($_GET['slug']);
} else {
    die('<h1>Ошибка: параметр slug не передан.</h1>');
}

$query = "SELECT a.*, u.public_name 
          FROM articles a 
          LEFT JOIN users u ON a.author_id = u.user_id 
          WHERE a.slug = :slug 
          LIMIT 1";
$articles = executeQuery($pdo, $query, ['slug' => $slug]);

if (empty($articles)) {
    die('<h1>Статья не найдена.</h1>');
}

$article = $articles[0];

$categoriesQuery = "SELECT c.name, c.type, c.category_id 
                    FROM article_categories ac 
                    JOIN categories c ON ac.category_id = c.category_id 
                    WHERE ac.article_id = :article_id";
$categories = executeQuery($pdo, $categoriesQuery, ['article_id' => $article['article_id']]);

$pageTitle = htmlspecialchars($article['title'], ENT_QUOTES);
$pageDescription = htmlspecialchars_decode($article['full_text'], ENT_QUOTES);

include '../templates/header.php';
?>

    <div class="columns-1 m-auto">
        <p class="text-sm text-gray-400 mb-5"><?= date('d F Y H:i', strtotime($article['publication_date'])); ?></p>
        <h1 class="font-bold text-3xl mb-5"><?= htmlspecialchars($article['title'], ENT_QUOTES); ?></h1>

        <!-- Оборачиваем содержимое статьи в специальный блок -->
        <div class="article-content leading-[1.75] text-gray-100">
            <?= htmlspecialchars_decode($article['full_text'], ENT_QUOTES); ?>
        </div>

        <p class="text-sm text-gray-400 mb-5">Автор: <?= htmlspecialchars($article['public_name'] ?? 'Неизвестно', ENT_QUOTES); ?></p>

        <!-- Вывод категорий -->
        <div class="article-categories">
            <h3>Категории:</h3>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="category.php?id=<?= $category['category_id']; ?>&type=<?= $category['type']; ?>" class="category-link mr-2">
                        <?= htmlspecialchars($category['name'], ENT_QUOTES); ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Категории отсутствуют.</p>
            <?php endif; ?>
        </div>
    </div>

<?php include '../templates/footer.php'; ?>