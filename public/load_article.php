<?php
require_once '../includes/db.php';

$offset = intval($_GET['offset'] ?? 0);

$query = "SELECT * FROM articles WHERE pinned = 0 ORDER BY publication_date DESC LIMIT 10 OFFSET :offset";
$articles = executeQuery($pdo, $query, ['offset' => $offset]);

foreach ($articles as $article): ?>
    <div class="article-item">
        <h3><?= htmlspecialchars($article['title'], ENT_QUOTES); ?></h3>
        <p><?= htmlspecialchars($article['summary'], ENT_QUOTES); ?></p>
        <img src="assets/uploads/<?= htmlspecialchars($article['image_path'], ENT_QUOTES); ?>" alt="Миниатюра">
        <a href="article.php?id=<?= $article['article_id']; ?>">Читать далее</a>
    </div>
    <hr>
<?php endforeach; ?>