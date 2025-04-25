<?php
/**
 * admin/categories.php
 * Управление рубриками (категориями) в админке
 */

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
session_start();

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Обработка добавления/редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id   = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
    $name = trim($_POST['name'] ?? '');
    $type = $_POST['type'] ?? '';

    if ($name !== '' && in_array($type, ['games', 'movies'], true)) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE categories SET name = :name, type = :type WHERE category_id = :id");
            $stmt->execute([':name' => $name, ':type' => $type, ':id' => $id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO categories (name, type) VALUES (:name, :type)");
            $stmt->execute([':name' => $name, ':type' => $type]);
        }
    }
    header('Location: ' . basename(__FILE__));
    exit;
}

// Загружаем рубрики и разделяем по типам
$all = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$games  = array_filter($all, fn($c) => $c['type'] === 'games');
$movies = array_filter($all, fn($c) => $c['type'] === 'movies');

// Подключаем шапку админки
include __DIR__ . '/../templates/admin_header.php';
?>

<main class="max-w-2xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold">Рубрики</h1>

    <!-- Вкладки и кнопка добавления -->
    <div class="flex items-center space-x-4">
        <button id="games-tab" class="px-4 py-2 border-b-2 border-transparent hover:border-gray-400 active:border-sky-400">Игры</button>
        <button id="movies-tab" class="px-4 py-2 border-b-2 border-transparent hover:border-gray-400">Фильмы</button>
        <button id="add-category-btn" class="ml-auto bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded">Добавить рубрику</button>
    </div>

    <!-- Списки рубрик -->
    <div id="games-list" class="space-y-2">
        <?php foreach ($games as $cat): ?>
            <div class="flex justify-between bg-neutral-800 p-3 rounded">
                <span><?= htmlspecialchars($cat['name']) ?></span>
                <button class="text-sky-400 hover:underline" onclick="editCategory('<?= $cat['category_id'] ?>','<?= addslashes($cat['name']) ?>','games')">Редактировать</button>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="movies-list" class="hidden space-y-2">
        <?php foreach ($movies as $cat): ?>
            <div class="flex justify-between bg-neutral-800 p-3 rounded">
                <span><?= htmlspecialchars($cat['name']) ?></span>
                <button class="text-sky-400 hover:underline" onclick="editCategory('<?= $cat['category_id'] ?>','<?= addslashes($cat['name']) ?>','movies')">Редактировать</button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<!-- Модальное окно -->
<div id="category-modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
    <div class="bg-neutral-800 text-neutral-100 p-6 rounded-lg w-80">
        <h2 id="modal-title" class="text-xl font-semibold mb-4 text-center"></h2>
        <form id="category-form" method="POST" class="space-y-4">
            <input type="hidden" name="category_id" id="category-id">
            <div>
                <label class="block mb-1">Название рубрики</label>
                <input type="text" name="name" id="category-name" class="w-full px-3 py-2 bg-neutral-700 rounded focus:outline-none" required>
            </div>
            <div>
                <label class="block mb-1">Тип</label>
                <select name="type" id="category-type" class="w-full px-3 py-2 bg-neutral-700 rounded">
                    <option value="games">Игры</option>
                    <option value="movies">Фильмы</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2 pt-2">
                <button type="button" id="cancel-btn" class="px-4 py-2 bg-gray-600 rounded">Отмена</button>
                <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-700 rounded">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<script>
    const gamesTab = document.getElementById('games-tab');
    const moviesTab = document.getElementById('movies-tab');
    const gamesList = document.getElementById('games-list');
    const moviesList = document.getElementById('movies-list');
    const modal = document.getElementById('category-modal');
    const cancelBtn = document.getElementById('cancel-btn');

    // Переключение табов
    gamesTab.addEventListener('click', () => {
        gamesTab.classList.add('active');
        moviesTab.classList.remove('active');
        gamesList.classList.remove('hidden');
        moviesList.classList.add('hidden');
    });
    moviesTab.addEventListener('click', () => {
        moviesTab.classList.add('active');
        gamesTab.classList.remove('active');
        moviesList.classList.remove('hidden');
        gamesList.classList.add('hidden');
    });

    // Открытие модалки
    document.getElementById('add-category-btn').addEventListener('click', () => openModal('Добавить рубрику'));
    function editCategory(id, name, type) {
        openModal('Редактировать рубрику', id, name, type);
    }
    function openModal(title, id = '', name = '', type = 'games') {
        document.getElementById('modal-title').textContent = title;
        document.getElementById('category-id').value = id;
        document.getElementById('category-name').value = name;
        document.getElementById('category-type').value = type;
        modal.classList.remove('hidden');
    }

    // Закрытие модалки
    cancelBtn.addEventListener('click', () => modal.classList.add('hidden'));
</script>

<?php include __DIR__ . '/../templates/admin_footer.php'; ?>
