<?php
// public/contact.php

require_once __DIR__ . '/../includes/functions.php';

// Заголовок и мета-описание
$pageTitle       = 'Контакты';
$metaDescription = 'Свяжитесь с командой Cyber Rift Project';

// Подключаем шапку
include __DIR__ . '/../templates/header.php';
?>

    <div class="flex-1 space-y-8">
        <h1 class="text-3xl font-bold">Свяжитесь с нами</h1>

        <p class="text-neutral-400">
            Если у вас есть вопросы, предложения или вы просто хотите сказать «привет» — пишите!
        </p>

        <div class="space-y-4 bg-neutral-800 p-6 rounded">
            <p><strong>📧 E-mail:</strong> example@example.com</p>
            <p><strong>📞 Телефон:</strong> +7 123 456-78-90</p>
            <p><strong>📍 Адрес:</strong> г. Москва, ул. Примерная, д. 1</p>
        </div>

        <div class="mt-6">
            <h2 class="text-2xl font-semibold mb-4">Форма обратной связи</h2>
            <form action="#" method="post" class="space-y-4">
                <div>
                    <label for="name" class="block mb-1">Ваше имя</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Иван Иванов"
                        class="w-full border border-neutral-700 rounded px-3 py-2 bg-neutral-900 text-neutral-100"
                    >
                </div>
                <div>
                    <label for="email" class="block mb-1">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@example.com"
                        class="w-full border border-neutral-700 rounded px-3 py-2 bg-neutral-900 text-neutral-100"
                    >
                </div>
                <div>
                    <label for="message" class="block mb-1">Сообщение</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        placeholder="Напишите ваше сообщение…"
                        class="w-full border border-neutral-700 rounded px-3 py-2 bg-neutral-900 text-neutral-100"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded"
                >
                    Отправить
                </button>
            </form>
        </div>
    </div>

<?php
// Подключаем сайдбар и футер
include __DIR__ . '/../templates/sidebar.php';
include __DIR__ . '/../templates/footer.php';