<?php
// admin/categories.php
require_once '../includes/db.php'; // Подключение к базе данных
require_once '../includes/functions.php'; // Подключение общих функций
session_start(); // Запуск сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Перенаправление на страницу входа
    exit();
}

// Получение списка рубрик
$query = "SELECT * FROM categories ORDER BY name ASC";
$categories = executeQuery($pdo, $query);

// Добавление новой рубрики
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $categoryName = sanitizeInput($_POST['category_name']);
    if (!empty($categoryName)) {
        $addQuery = "INSERT INTO categories (name) VALUES (:name)";
        executeQuery($pdo, $addQuery, ['name' => $categoryName]);
    }
    header('Location: categories.php');
    exit();
}

// Редактирование рубрики
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $categoryId = intval($_POST['category_id']);
    $categoryName = sanitizeInput($_POST['category_name']);
    if (!empty($categoryName)) {
        $editQuery = "UPDATE categories SET name = :name WHERE category_id = :category_id";
        executeQuery($pdo, $editQuery, ['name' => $categoryName, 'category_id' => $categoryId]);
    }
    header('Location: categories.php');
    exit();
}

// Удаление рубрики
if (isset($_GET['delete'])) {
    $categoryId = intval($_GET['delete']);
    $deleteQuery = "DELETE FROM categories WHERE category_id = :category_id";
    executeQuery($pdo, $deleteQuery, ['category_id' => $categoryId]);
    header('Location: categories.php');
    exit();
}
?>

<?php include '../templates/admin_header.php'; ?>

<main class="container mx-auto py-8">
    <h1 class="text-3xl font-semibold text-center mb-8">Управление рубриками</h1>
    <section class="mb-6">
        <h2 class="text-xl font-bold mb-4">Добавить новую рубрику</h2>
        <form method="POST" class="bg-neutral-800 p-4 rounded">
            <input type="hidden" name="action" value="add">
            <div class="mb-4">
                <label for="category_name" class="block text-neutral-200 mb-2">Название рубрики:</label>
                <input type="text" name="category_name" id="category_name" required
                       class="bg-neutral-700 text-neutral-100 border border-neutral-600 rounded py-2 px-3 focus:outline-none focus:ring focus:ring-neutral-500 w-full">
            </div>
            <button type="submit"
                    class="bg-neutral-700 hover:bg-neutral-600 text-white py-2 px-4 rounded">
                Добавить
            </button>
        </form>
    </section>
    <section>
        <h2 class="text-xl font-bold mb-4">Список рубрик</h2>
        <table class="w-full bg-neutral-800 rounded">
            <thead>
            <tr>
                <th class="text-neutral-300 py-3 px-4 border-b border-neutral-700">Название</th>
                <th class="text-neutral-300 py-3 px-4 border-b border-neutral-700">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td class="py-3 px-4 border-b border-neutral-700"><?= sanitizeInput($category['name']); ?></td>
                    <td class="py-3 px-4 border-b border-neutral-700">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="category_id" value="<?= $category['category_id']; ?>">
                            <input type="text" name="category_name" value="<?= sanitizeInput($category['name']); ?>" required
                                   class="bg-neutral-700 text-neutral-100 border border-neutral-600 rounded py-2 px-3 focus:outline-none focus:ring focus:ring-neutral-500 w-auto">
                            <button type="submit"
                                    class="bg-neutral-700 hover:bg-neutral-600 text-white py-2 px-4 rounded">
                                Сохранить
                            </button>
                        </form>
                        <a href="categories.php?delete=<?= $category['category_id']; ?>"
                           class="text-neutral-400 hover:text-neutral-200 ml-2"
                           onclick="return confirm('Удалить рубрику?');">
                            Удалить
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
