<!-- Sidebar -->
<aside class="h-fit w-full md:w-80 space-y-6 border border-neutral-800 rounded-lg">
    <!-- Subscribe Box -->
    <div class="p-4 border-neutral-800">
        <h3 class="font-semibold mb-2">Поиск по сайту</h3>
        <form action="search.php" method="GET">
            <input type="text" name="query" id="search" placeholder="Введите запрос..." class="w-full mb-2 px-3 py-2 rounded bg-[#29292b] text-[#f5f4f4] placeholder-[#9f9fa9] focus:border-sky-700" required/>
            <button type="submit" class="w-full bg-[#121212] border border-neutral-800 py-2 rounded hover:bg-[#171717] hover:border-sky-700">Найти</button>
        </form>
    </div>

    <!-- Work History -->
    <div class="p-4">
        <h3 class="font-semibold mb-4">Дни рождения игр</h3>
        <ul class="space-y-3 list-disc">
            <li class="flex items-center justify-between">
                <span>The Witcher 3</span><span>5 лет</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Metro 2033</span><span>3 года</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Painkiller</span><span>10 лет</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Sims 4</span><span>4 года</span>
            </li>
        </ul>
        <button class="w-full mt-4 bg-[#121212] border border-neutral-800 py-2 rounded hover:bg-[#171717] hover:border-sky-700">Посмотреть все</button>
    </div>
</aside>
