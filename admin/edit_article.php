<?php
// admin/edit_article.php
require_once '../includes/db.php';
require_once '../includes/functions.php';
session_start();

$articleId = intval($_GET['id']);
$errors = [];

// Получение данных статьи
$query = "SELECT * FROM articles WHERE article_id = :article_id";
$article = executeQuery($pdo, $query, ['article_id' => $articleId])[0];

// Получение всех категорий
$categoriesQuery = "SELECT * FROM categories";
$categories = executeQuery($pdo, $categoriesQuery);

// Текущие категории статьи
$currentCategoriesQuery = "SELECT category_id FROM article_categories WHERE article_id = :article_id";
$currentCategories = executeQuery($pdo, $currentCategoriesQuery, ['article_id' => $articleId]);
$currentCategoryIds = array_column($currentCategories, 'category_id');

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title']);
    $summary = $_POST['summary']; // Сохраняем HTML-разметку
    $full_text = $_POST['full_text']; // Сохраняем HTML-разметку
    $selectedCategories = $_POST['categories'] ?? [];
    $errors = [];

    // Валидация
    if (empty($title)) {
        $errors[] = "Заголовок обязателен для заполнения.";
    }
    if (empty($summary)) {
        $errors[] = "Краткое содержание обязательно для заполнения.";
    }
    if (empty($full_text)) {
        $errors[] = "Полный текст обязателен для заполнения.";
    }
    if (empty($selectedCategories)) {
        $errors[] = "Выберите хотя бы одну категорию.";
    }

    // Если ошибок нет, обновляем статью
    if (empty($errors)) {
        $query = "UPDATE articles SET title = :title, summary = :summary, full_text = :full_text WHERE article_id = :article_id";
        executeQuery($pdo, $query, [
            'title' => $title,
            'summary' => $summary,
            'full_text' => $full_text,
            'article_id' => $articleId,
        ]);

        // Обновляем категории статьи
        $deleteQuery = "DELETE FROM article_categories WHERE article_id = :article_id";
        executeQuery($pdo, $deleteQuery, ['article_id' => $articleId]);

        foreach ($selectedCategories as $categoryId) {
            $insertQuery = "INSERT INTO article_categories (article_id, category_id) VALUES (:article_id, :category_id)";
            executeQuery($pdo, $insertQuery, [
                'article_id' => $articleId,
                'category_id' => $categoryId,
            ]);
        }

        header('Location: articles.php');
        exit();
    }
}

$pageTitle = "Редактировать статью";
include '../templates/admin_header.php';
?>

    <div class="min-h-screen bg-neutral-900 flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl w-full bg-neutral-800 shadow-lg rounded-lg p-8">
            <h1 class="text-4xl font-bold text-center text-white mb-8">Редактировать статью</h1>

            <?php if (!empty($errors)): ?>
                <div class="mb-6">
                    <ul class="bg-red-600 text-white p-4 rounded">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error, ENT_QUOTES); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <!-- Заголовок -->
                <div>
                    <label for="title" class="block text-lg text-neutral-300 mb-2">Заголовок</label>
                    <input type="text" name="title" id="title" required
                           value="<?= htmlspecialchars($article['title'], ENT_QUOTES); ?>"
                           class="w-full px-4 py-3 rounded bg-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Краткое содержание -->
                <div>
                    <label for="summary" class="block text-lg text-neutral-300 mb-2">Краткое содержание</label>
                    <textarea name="summary" id="summary" required
                              class="w-full px-4 py-3 rounded bg-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars_decode($article['summary'], ENT_QUOTES); ?></textarea>
                </div>

                <!-- Полный текст -->
                <div>
                    <label for="full_text" class="block text-lg text-neutral-300 mb-2">Полный текст</label>
                    <textarea name="full_text" id="full_text" required
                              class="w-full px-4 py-3 rounded bg-neutral-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars_decode($article['full_text'], ENT_QUOTES); ?></textarea>
                </div>

                <!-- Категории -->
                <div>
                    <label class="block text-lg text-neutral-300 mb-2">Категории</label>

                    <!-- Группа категорий: Фильмы -->
                    <fieldset class="mb-4 p-4 border border-neutral-600 rounded">
                        <legend class="text-xl text-gray-200 font-bold mb-2">Фильмы</legend>
                        <div class="grid grid-cols-2 gap-4">
                            <?php foreach ($categories as $category): ?>
                                <?php if (isset($category['type']) && $category['type'] === 'movies'): ?>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="category-<?= $category['category_id']; ?>" name="categories[]" value="<?= $category['category_id']; ?>"
                                            <?= in_array($category['category_id'], $currentCategoryIds) ? 'checked' : ''; ?>
                                               class="h-5 w-5 text-green-400 focus:ring-green-500 rounded border-gray-500">
                                        <label for="category-<?= $category['category_id']; ?>" class="ml-2 text-gray-200">
                                            <?= htmlspecialchars($category['name'], ENT_QUOTES); ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>

                    <!-- Группа категорий: Игры -->
                    <fieldset class="p-4 border border-neutral-600 rounded">
                        <legend class="text-xl text-neutral-200 font-bold mb-2">Игры</legend>
                        <div class="grid grid-cols-2 gap-4">
                            <?php foreach ($categories as $category): ?>
                                <?php if (isset($category['type']) && $category['type'] === 'games'): ?>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="category-<?= $category['category_id']; ?>" name="categories[]" value="<?= $category['category_id']; ?>"
                                            <?= in_array($category['category_id'], $currentCategoryIds) ? 'checked' : ''; ?>
                                               class="h-5 w-5 text-blue-400 focus:ring-blue-500 rounded border-gray-500">
                                        <label for="category-<?= $category['category_id']; ?>" class="ml-2 text-gray-200">
                                            <?= htmlspecialchars($category['name'], ENT_QUOTES); ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>
                </div>

                <div class="text-center">
                    <button type="submit" class="px-6 py-3 bg-neutral-600 hover:bg-blue-700 text-white font-semibold rounded transition">
                        Сохранить изменения
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php include '../templates/admin_footer.php'; ?>