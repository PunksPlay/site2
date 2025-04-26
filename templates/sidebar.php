<?php
// sidebar.php — боковая панель
?>
<aside class="w-full md:w-80 space-y-6">
    <div class="bg-[#141414] p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-2 text-neutral-100">Поиск по сайту</h3>
        <form action="search.php" method="GET">
            <input
                    type="text"
                    name="query"
                    placeholder="Введите запрос..."
                    class="w-full px-3 py-2 border border-neutral-700 rounded bg-neutral-900 text-neutral-100 placeholder-neutral-400 focus:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-sky-600"
                    required
            />
            <button
                    type="submit"
                    class="w-full mt-2 bg-[#141414] border border-neutral-700 py-2 rounded hover:bg-neutral-900 hover:border-sky-600"
            >Найти</button>
        </form>
    </div>

    <div class="bg-[#141414] p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-4 text-neutral-100">Реклама</h3>
        <img src="https://i.playground.ru/p/OzomQ9kA7AyRWR7Iq3Nq7g.png.webp?760xauto" width="100%">
    </div>

    <div class="bg-[#141414] p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-4 text-neutral-100">Дни рождения игр</h3>
        <ul class="space-y-3">
            <li class="flex justify-between"><span>The Witcher 3</span><span>5 лет</span></li>
            <li class="flex justify-between"><span>Metro 2033</span><span>3 года</span></li>
            <li class="flex justify-between"><span>Painkiller</span><span>10 лет</span></li>
            <li class="flex justify-between"><span>Sims 4</span><span>4 года</span></li>
            <li class="flex justify-between"><span>Lords of the Fallen</span><span>2 года</span></li>
            <li class="flex justify-between"><span>Need for Speed: Underground 2</span><span>7 лет</span></li>
        </ul>
        <button
                class="w-full mt-4 bg-[#141414] border border-neutral-700 py-2 rounded hover:bg-neutral-900 hover:border-sky-600"
        >Посмотреть все</button>
    </div>

    <div class="bg-[#141414] p-4 rounded-lg shadow">
        <h3 class="font-semibold mb-4 text-neutral-100">Способы поддержать сайт</h3>
        <p>
            Самый лучший способ поддержать сайт это отключить блокировщик рекламы. Но также вы можете поддержать меня по реквизитам:
        </p>
        <ul class="space-y-3">
            <li class="flex justify-between">4486441729154030</li>
            <li class="flex justify-between">5569191777864116</li>
            <li class="flex justify-between">5569191777864116</li>
        </ul>
    </div>
</aside>
