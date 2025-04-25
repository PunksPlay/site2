<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$pageTitle = 'Главная';
$metaDescription = 'Читайте актуальные статьи о видеоиграх и кино.';

// Получение закрепленной статьи
$pinnedQuery   = "SELECT * FROM articles WHERE pinned = 1 ORDER BY publication_date DESC LIMIT 1";
$pinnedArticle = executeQuery($pdo, $pinnedQuery);

// Получение списка статей
$query    = "SELECT * FROM articles WHERE pinned = 0 ORDER BY publication_date DESC LIMIT 10";
$articles = executeQuery($pdo, $query);
?>

<?php include '../templates/header.php'; ?>

<div class="flex-1 space-y-8">
    <?php if ($pinnedArticle): ?>
        <article class="border-b border-neutral-800 pb-6">
            <div class="text-sm text-neutral-400 mb-1">
                <?= formatDateRu($pinnedArticle[0]['publication_date']); ?>
            </div>
            <h2 class="text-lg font-semibold">
                <?= htmlspecialchars_decode($pinnedArticle[0]['title'], ENT_QUOTES); ?>
                <img class="h-4 inline-flex mr-3" src="/assets/uploads/_pin.svg" alt="Закрепленная новость">
            </h2>
            <div class="text-neutral-300 mt-2">
                <?= htmlspecialchars_decode($pinnedArticle[0]['summary'], ENT_QUOTES); ?>
            </div>
            <a href="article.php?slug=<?= $pinnedArticle[0]['slug']; ?>"
               class="inline-block text-sky-600 hover:underline">Читать далее →</a>
        </article>
    <?php endif; ?>

    <?php foreach ($articles as $article): ?>
        <article class="pb-6">
            <div class="text-sm text-neutral-400 mb-1">
                <?= formatDateRu($article['publication_date']); ?>
            </div>
            <h2 class="text-lg font-semibold">
                <?= htmlspecialchars_decode($article['title'], ENT_QUOTES); ?>
            </h2>
            <div class="text-neutral-400 mt-2">
                <?= htmlspecialchars_decode($article['summary'], ENT_QUOTES); ?>
            </div>
            <a href="article.php?slug=<?= $article['slug']; ?>"
               class="inline-block text-sky-600 hover:underline">Читать далее →</a>
        </article>
    <?php endforeach; ?>
</div>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/footer.php'; ?>
