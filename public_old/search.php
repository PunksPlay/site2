<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

$searchQuery = $_GET['query'] ?? ''; // Получение поискового запроса
$searchQuery = trim($searchQuery); // Удаление лишних пробелов

$pageTitle = "Результаты поиска: " . htmlspecialchars($searchQuery, ENT_QUOTES);

include '../templates/header.php';

if (!empty($searchQuery)) {
    // Поиск в базе данных
    $query = "SELECT * FROM articles WHERE 
              title LIKE :search OR 
              summary LIKE :search OR 
              full_text LIKE :search 
              ORDER BY publication_date DESC";
    $results = executeQuery($pdo, $query, ['search' => '%' . $searchQuery . '%']);
} else {
    $results = [];
}
?>

    <h1>Результаты поиска</h1>

<?php if (!empty($searchQuery)): ?>
    <p>Вы искали: <strong><?= htmlspecialchars($searchQuery, ENT_QUOTES); ?></strong></p>
<?php endif; ?>

<?php if ($results): ?>
    <div class="articles-list">
        <?php foreach ($results as $article): ?>
            <div class="article-item">
                <h3><a href="article.php?id=<?= $article['article_id']; ?>"><?= htmlspecialchars($article['title'], ENT_QUOTES); ?></a></h3>
                <p><?= htmlspecialchars($article['summary'], ENT_QUOTES); ?></p>
                <div class="article-date"><?= date('d F Y H:i', strtotime($article['publication_date'])); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Ничего не найдено. Попробуйте изменить запрос.</p>
<?php endif; ?>

<?php include '../templates/footer.php'; ?>