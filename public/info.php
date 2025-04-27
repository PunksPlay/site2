<?php
// public/info.php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

// Title страницы
$pageTitle = 'Информация';

// Подключаем шапку
include __DIR__ . '/../templates/header.php';
?>

    <div class="flex-1 space-y-6">
        <article class="pb-6">
            <!-- Заголовок -->
            <h1 class="text-3xl font-bold mb-4 text-neutral-100 text-center">
                <?= htmlspecialchars($pageTitle, ENT_QUOTES) ?>
            </h1>

            <!-- Разделитель -->
            <div class="block border-b border-neutral-800 mt-5 mb-7"></div>

            <!-- Основной контент -->
            <div class="article-content leading-relaxed text-neutral-100 mb-4 mx-20">

                <!-- Секция «О проекте» -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-3">О проекте</h2>
                    <p>
                        Cyber Rift Project — это независимый медиапроект о мире видеоигр и кино.
                        Здесь вы найдёте новости индустрии, рецензии, обзоры, аналитические статьи и
                        авторские колонки. Наша цель — делиться качественным контентом и формировать
                        сообщество единомышленников.
                    </p>
                </section>

                <!-- Секция «Контакты» -->
                <section class="mb-8">
                    <h2 class="text-2xl font-semibold mb-3">Контакты</h2>
                    <p>
                        Если у вас есть вопросы или предложения, вы всегда можете связаться с нами:
                    </p>
                    <ul class="list-disc list-inside space-y-1 mt-2">
                        <li><strong>E-mail:</strong> example@example.com</li>
                        <li><strong>Телефон:</strong> +7 (123) 456-78-90</li>
                        <li><strong>Адрес:</strong> г. Москва, ул. Примерная, д. 1</li>
                    </ul>
                </section>

                <!-- Секция «О социальной активности» -->
                <section>
                    <h2 class="text-2xl font-semibold mb-3">Социальные сети</h2>
                    <p>Подписывайтесь на нас, чтобы не пропускать новые материалы:</p>
                    <ul class="flex space-x-4 mt-2">
                        <li><a href="#" class="hover:underline text-sky-600">Twitter</a></li>
                        <li><a href="#" class="hover:underline text-sky-600">Facebook</a></li>
                        <li><a href="#" class="hover:underline text-sky-600">Instagram</a></li>
                    </ul>
                </section>

            </div>
        </article>
    </div>

<?php
// Подключаем футер
include __DIR__ . '/../templates/footer.php';