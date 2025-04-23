<?php
// header.php — открывает <html>, <head>, шапку и <main>
?>
<!DOCTYPE html>
<html lang="ru" class="min-h-screen flex flex-col bg-neutral-900 text-neutral-200">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $pageTitle ?? 'CYBER RIFT PROJECT'; ?></title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="icon" type="image/x-icon" href="../assets/uploads/favicon.png">
</head>
<body class="flex flex-col flex-1">
<header class="bg-[#141414] text-neutral-200 border-b border-neutral-800">
    <div class="max-w-[912px] w-full mx-auto px-4 py-4 flex items-center justify-between">
        <div class="text-2xl font-bold c-log">CYBER RIFT PROJECT</div>
        <button id="mobile-menu-button" class="md:hidden focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        <nav class="hidden md:flex items-center space-x-6">
            <a href="index.php" class="hover:text-sky-600">Главная</a>
            <div class="relative">
                <button class="submenu-button flex items-center space-x-1 focus:outline-none">
                    <span>Видеоигры</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden absolute right-0 mt-2 w-40 bg-neutral-800 shadow-lg rounded py-2">
                    <li><a href="categories.php?type=games&genre=action" class="block px-4 py-2 hover:bg-neutral-700">Action</a></li>
                    <li><a href="categories.php?type=games&genre=rpg"    class="block px-4 py-2 hover:bg-neutral-700">RPG</a></li>
                    <li><a href="categories.php?type=games&genre=strategy" class="block px-4 py-2 hover:bg-neutral-700">Strategy</a></li>
                </ul>
            </div>
            <div class="relative">
                <button class="submenu-button flex items-center space-x-1 focus:outline-none">
                    <span>Синематограф</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden absolute right-0 mt-2 w-40 bg-neutral-800 shadow-lg rounded py-2">
                    <li><a href="categories.php?type=movies&genre=drama"  class="block px-4 py-2 hover:bg-neutral-700">Drama</a></li>
                    <li><a href="categories.php?type=movies&genre=comedy" class="block px-4 py-2 hover:bg-neutral-700">Comedy</a></li>
                    <li><a href="categories.php?type=movies&genre=horror" class="block px-4 py-2 hover:bg-neutral-700">Horror</a></li>
                </ul>
            </div>
            <a href="contact.php" class="hover:text-sky-600">Контакты</a>
            <a href="about.php" class="hover:text-sky-600">О нас</a>
        </nav>
    </div>
    <nav id="mobile-menu" class="hidden md:hidden bg-neutral-900 text-neutral-200 border-t border-neutral-800">
        <ul class="flex flex-col space-y-2">
            <li><a href="index.php" class="block px-4 py-2 hover:bg-neutral-700 rounded">Главная</a></li>
            <li>
                <button class="submenu-button w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                    <span>Видеоигры</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden pl-4 mt-2 space-y-1">
                    <li><a href="categories.php?type=games&genre=action"  class="block px-2 py-1 hover:bg-neutral-700 rounded">Action</a></li>
                    <li><a href="categories.php?type=games&genre=rpg"     class="block px-2 py-1 hover:bg-neutral-700 rounded">RPG</a></li>
                    <li><a href="categories.php?type=games&genre=strategy"class="block px-2 py-1 hover:bg-neutral-700 rounded">Strategy</a></li>
                </ul>
            </li>
            <li>
                <button class="submenu-button w-full flex justify-between items-center px-4 py-2 focus:outline-none">
                    <span>Синематограф</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <ul class="submenu hidden pl-4 mt-2 space-y-1">
                    <li><a href="categories.php?type=movies&genre=drama" class="block px-2 py-1 hover:bg-neutral-700 rounded">Drama</a></li>
                    <li><a href="categories.php?type=movies&genre=comedy"class="block px-2 py-1 hover:bg-neutral-700 rounded">Comedy</a></li>
                    <li><a href="categories.php?type=movies&genre=horror"class="block px-2 py-1 hover:bg-neutral-700 rounded">Horror</a></li>
                </ul>
            </li>
            <li><a href="contact.php" class="block px-4 py-2 hover:bg-neutral-700 rounded">Контакты</a></li>
            <li><a href="about.php"   class="block px-4 py-2 hover:bg-neutral-700 rounded">О нас</a></li>
        </ul>
    </nav>
</header>

<main class="flex-1 flex flex-col md:flex-row max-w-[912px] w-full mx-auto px-4 py-8 space-y-8 md:space-y-0 md:space-x-8">
