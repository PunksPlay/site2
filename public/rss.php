<?php
require_once '../includes/db.php';

header("Content-Type: application/rss+xml; charset=UTF-8");

$query = "SELECT title, summary, publication_date FROM articles ORDER BY publication_date DESC LIMIT 10";
$articles = executeQuery($pdo, $query);

echo "<?xml version='1.0' encoding='UTF-8' ?>";
echo "<rss version='2.0'>";
echo "<channel>";
echo "<title>CYBER RIFT PROJECT</title>";
echo "<link>https://example.com</link>";
echo "<description>Последние статьи о видеоиграх и фильмах</description>";

foreach ($articles as $article) {
    echo "<item>";
    echo "<title>" . htmlspecialchars($article['title']) . "</title>";
    echo "<description>" . htmlspecialchars($article['summary']) . "</description>";
    echo "<pubDate>" . date(DATE_RSS, strtotime($article['publication_date'])) . "</pubDate>";
    echo "<link>https://example.com/article/" . $article['article_id'] . "</link>";
    echo "</item>";
}

echo "</channel>";
echo "</rss>";
?>