<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?? 'Админпанель'; ?></title>
    <link rel="stylesheet" href="../assets/css/admin.css">
<!--    <link rel="stylesheet" href="../assets/css/output.css">-->
    <script src="https://cdn.tiny.cloud/1/ffr2p8qybp4euxorx4oqmr5v90v2gan5gfeogo13v4og0fao/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="../assets/js/tinymce_init.js"></script>
</head>
<body>
<header>
    <h1>Административная панель</h1>
    <nav>
        <a href="articles.php">Статьи</a>
        <a href="categories.php">Рубрики</a>
        <a href="logout.php">Выйти</a>
    </nav>
</header>
<main class="container">