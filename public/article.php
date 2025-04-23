<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (isset($_GET['slug'])) {
    $slug = sanitizeInput($_GET['slug']);
} else {
    die('<h1>Ошибка: параметр slug не передан.</h1>');
}

$query    = "SELECT a.*, u.public_name
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

$pageTitle       = htmlspecialchars($article['title'], ENT_QUOTES);
$pageDescription = htmlspecialchars_decode($article['full_text'], ENT_QUOTES);

include '../templates/header.php';
?>

<div class="flex-1 space-y-6">
    <article class="pb-6">
        <h1 class="text-3xl font-bold mb-4 text-neutral-100 text-center">
            <?= htmlspecialchars($article['title'], ENT_QUOTES); ?>
        </h1>

        <div class="text-sm text-neutral-400 text-center">
            Автор: <?= htmlspecialchars($article['public_name'] ?? 'Неизвестно', ENT_QUOTES); ?> <span class="mx-1">|</span> <?= date('d F Y H:i', strtotime($article['publication_date'])); ?>
        </div>

        <div class="block border-b border-neutral-800 mt-5 mb-7"></div>

        <div class="article-content leading-relaxed text-neutral-100 mb-4 mx-20">
            <?= htmlspecialchars_decode($article['full_text'], ENT_QUOTES); ?>
        </div>

        <div class="ml-20">
            <h3 class="font-semibold mb-2">Категории:</h3>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <a href="category.php?id=<?= $cat['category_id']; ?>&type=<?= $cat['type']; ?>"
                       class="inline-block mr-2 text-sky-600 hover:underline">
                        <?= htmlspecialchars($cat['name'], ENT_QUOTES); ?>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Категории отсутствуют.</p>
            <?php endif; ?>
        </div>
    </article>
</div>

<?php include '../templates/footer.php'; ?>