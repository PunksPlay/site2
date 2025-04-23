<!DOCTYPE html>
<html lang="ru" class="bg-[#1c1c1c] text-white">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'CYBER RIFT PROJECT'; ?></title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="../assets/uploads/favicon.png">
</head>
<body class="flex flex-col">

<!-- Wrapper с ограничением ширины -->
<div class="max-w-6xl min-h-screen mx-auto bg-[#121212] px-30">

    <!-- Header -->
    <header class="flex items-center justify-between py-6 border-b border-neutral-800">
        <div class="text-xl font-semibold cursor-default">CYBER RIFT PROJECT</div>
        <nav class="flex items-center space-x-4">
            <a href="index.php" class="hover:text-sky-500">Главная</a>
            <a href="categories.php?type=games" class="hover:text-sky-500">Видеоигры</a>
            <a href="categories.php?type=movies" class="hover:text-sky-500">Синематограф</a>
            <a href="contact.php" class="hover:text-sky-500">Контакты</a>
            <a href="about.php" class="hover:text-sky-500">О нас</a>
        </nav>
    </header>

    <!-- Main -->
    <main class="flex flex-col md:flex-row py-8 space-y-8 md:space-y-0 md:space-x-8">