<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Текстовый запрос
$searchQuery = trim($_GET['query'] ?? '');
// Заголовок для <title> и мета
$pageTitle = "Результаты поиска: " . ($searchQuery !== '' ? htmlspecialchars($searchQuery, ENT_QUOTES) : '');
$metaDescription = $searchQuery !== ''
    ? "Результаты поиска по запросу «{$searchQuery}»"
    : "Введите запрос для поиска на сайте Cyber Rift Project";
include '../templates/header.php';
?>

<div class="flex-1 space-y-8">
    <h1 class="text-3xl font-bold mb-2">Результаты поиска</h1>

    <?php if ($searchQuery !== ''): ?>
        <p class="mb-6 text-neutral-400">
            Вы искали: <strong class="text-neutral-100"><?= htmlspecialchars($searchQuery, ENT_QUOTES) ?></strong>
        </p>

        <?php
        // Ищем по названию, аннотации и полному тексту
        $sql = "
        SELECT *
        FROM articles
        WHERE title LIKE :s
          OR summary LIKE :s
          OR full_text LIKE :s
        ORDER BY publication_date DESC
      ";
        $results = executeQuery($pdo, $sql, ['s' => "%{$searchQuery}%"]);
        ?>

    <?php else: ?>
        <p class="mb-6 text-neutral-400">Введите запрос для поиска.</p>
        <?php $results = []; ?>
    <?php endif; ?>

    <?php if (!empty($results)): ?>
        <?php foreach ($results as $article): ?>
            <article class="pb-6">
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
        <p class="text-neutral-400">Ничего не найдено. Попробуйте изменить запрос.</p>
    <?php endif; ?>
</div>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/footer.php'; ?>