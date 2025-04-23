<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$searchQuery = trim($_GET['query'] ?? '');

$pageTitle = "Результаты поиска: " . htmlspecialchars($searchQuery, ENT_QUOTES);

include '../templates/header.php';
?>

<div class="flex-1 space-y-6">
    <h1 class="text-2xl font-bold mb-4">Результаты поиска</h1>

    <?php if ($searchQuery): ?>
        <p class="mb-4">Вы искали: <strong><?= htmlspecialchars($searchQuery, ENT_QUOTES); ?></strong></p>
        <?php
        $sql     = "SELECT * FROM articles
                  WHERE title LIKE :s OR summary LIKE :s OR full_text LIKE :s
                  ORDER BY publication_date DESC";
        $results = executeQuery($pdo, $sql, ['s' => "%{$searchQuery}%"]);
        ?>
    <?php else: ?>
        <p class="mb-4">Введите запрос для поиска.</p>
        <?php $results = []; ?>
    <?php endif; ?>

    <?php if ($results): ?>
        <?php foreach ($results as $art): ?>
            <article class="border-b border-neutral-800 pb-4 mb-4">
                <h2 class="text-xl font-semibold">
                    <a href="article.php?slug=<?= $art['slug']; ?>" class="hover:underline text-sky-600">
                        <?= htmlspecialchars($art['title'], ENT_QUOTES); ?>
                    </a>
                </h2>
                <p class="text-neutral-300"><?= htmlspecialchars($art['summary'], ENT_QUOTES); ?></p>
                <p class="text-sm text-neutral-400 mt-1">
                    <?= date('d F Y H:i', strtotime($art['publication_date'])); ?>
                </p>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Ничего не найдено. Попробуйте изменить запрос.</p>
    <?php endif; ?>
</div>

<?php include '../templates/sidebar.php'; ?>
<?php include '../templates/footer.php'; ?>
