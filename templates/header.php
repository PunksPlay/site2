<?php
// templates/header.php
// Динамическая шапка сайта с меню, подтягивающим категории из БД

require_once __DIR__ . '/../includes/db.php';

// Заголовок страницы (если не задан, используется дефолт)
$pageTitle = $pageTitle ?? 'CYBER RIFT PROJECT';

// Получаем категории из БД
$gameCategories  = $pdo
    ->query("SELECT category_id, name FROM categories WHERE type='games' ORDER BY name ASC")
    ->fetchAll(PDO::FETCH_ASSOC);
$movieCategories = $pdo
    ->query("SELECT category_id, name FROM categories WHERE type='movies' ORDER BY name ASC")
    ->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru" class="min-h-screen flex flex-col bg-neutral-900 text-neutral-200">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <!-- Подключение стилей и favicon -->
    <link rel="stylesheet" href="/assets/css/output.css" />
    <link rel="icon" href="/assets/uploads/favicon.png" />
</head>
<body class="flex flex-col flex-1">

<header class="bg-[#141414] border-b border-neutral-800 text-neutral-200">
    <div class="max-w-[912px] w-full mx-auto px-4 py-4 flex items-center justify-between">
        <a href="index.php" class="text-2xl font-bold">CYBER RIFT PROJECT</a>

        <!-- Кнопка для мобильного меню -->
        <button id="mobile-menu-button" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Десктопное меню -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="index.php" class="hover:text-sky-600">Главная</a>

            <!-- Пункт Видеоигры -->
            <div class="relative group">
                <button class="submenu-button flex items-center space-x-1 focus:outline-none">
                    <span>Видеоигры</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden group-hover:block absolute right-0 mt-2 w-44 bg-neutral-800 shadow-lg rounded py-2 z-20">
                    <?php foreach ($gameCategories as $cat): ?>
                        <li>
                            <a href="category.php?id=<?= $cat['category_id'] ?>&type=games" class="block px-4 py-2 hover:bg-neutral-700">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Пункт Синематограф -->
            <div class="relative group">
                <button class="submenu-button flex items-center space-x-1 focus:outline-none">
                    <span>Синематограф</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden group-hover:block absolute right-0 mt-2 w-44 bg-neutral-800 shadow-lg rounded py-2 z-20">
                    <?php foreach ($movieCategories as $cat): ?>
                        <li>
                            <a href="category.php?id=<?= $cat['category_id'] ?>&type=movies" class="block px-4 py-2 hover:bg-neutral-700">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <a href="contact.php" class="hover:text-sky-600">Контакты</a>
            <a href="about.php" class="hover:text-sky-600">О нас</a>
        </nav>
    </div>

    <!-- Мобильное меню -->
    <nav id="mobile-menu" class="hidden bg-neutral-900 border-t border-neutral-800 md:hidden">
        <ul class="flex flex-col space-y-2 p-4">
            <li><a href="index.php" class="block px-4 py-2 hover:bg-neutral-700 rounded">Главная</a></li>

            <!-- Мобильный пункт Видеоигры -->
            <li>
                <button class="submenu-button w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                    <span>Видеоигры</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden flex flex-col pl-4 mt-2 space-y-1">
                    <?php foreach ($gameCategories as $cat): ?>
                        <li>
                            <a href="category.php?id=<?= $cat['category_id'] ?>&type=games" class="block px-2 py-1 hover:bg-neutral-700 rounded">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>

            <!-- Мобильный пункт Синематограф -->
            <li>
                <button class="submenu-button w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                    <span>Синематограф</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden flex flex-col pl-4 mt-2 space-y-1">
                    <?php foreach ($movieCategories as $cat): ?>
                        <li>
                            <a href="category.php?id=<?= $cat['category_id'] ?>&type=movies" class="block px-2 py-1 hover:bg-neutral-700 rounded">
                                <?= htmlspecialchars($cat['name']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>

            <li><a href="contact.php" class="block px-4 py-2 hover:bg-neutral-700 rounded">Контакты</a></li>
            <li><a href="about.php" class="block px-4 py-2 hover:bg-neutral-700 rounded">О нас</a></li>
        </ul>
    </nav>
</header>

<main class="flex-1 flex flex-col md:flex-row max-w-[912px] w-full mx-auto px-4 py-8 md:space-x-8">
    <!-- Контент страницы -->
