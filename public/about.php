<?php
// public/about.php

require_once __DIR__ . '/../includes/functions.php';

// Заголовок и мета-описание
$pageTitle       = 'О проекте';
$metaDescription = 'Узнайте больше о Cyber Rift Project';

// Подключаем шапку
include __DIR__ . '/../templates/header.php';
?>

    <div class="flex-1 space-y-8">
        <h1 class="text-3xl font-bold">О проекте</h1>

        <p class="text-neutral-400">
            Cyber Rift Project — это независимый проект, посвящённый миру видеоигр и кино.
            Мы публикуем новости, обзоры, рецензии и размышления на актуальные темы индустрии.
        </p>

        <div class="space-y-4 bg-neutral-800 p-6 rounded">
            <h2 class="text-2xl font-semibold">Наша миссия</h2>
            <p>
                Мы стремимся создать пространство для обмена мнениями, идейного роста и поиска
                вдохновения среди всех, кто интересуется искусством интерактивных и визуальных медиа.
            </p>
        </div>

        <div class="space-y-4 bg-neutral-800 p-6 rounded">
            <h2 class="text-2xl font-semibold">История проекта</h2>
            <p>
                Cyber Rift Project был запущен в 2025 году как личная инициатива группы энтузиастов.
                С тех пор мы продолжаем развиваться, расширяя тематику и совершенствуя подачу материалов.
            </p>
        </div>
    </div>

<?php
// Подключаем сайдбар и футер
include __DIR__ . '/../templates/sidebar.php';
include __DIR__ . '/../templates/footer.php';
