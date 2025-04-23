<?php

// includes/functions.php

/**
 * Функция для безопасного выполнения SQL-запросов
 * @param PDO $pdo Объект PDO
 * @param string $query SQL-запрос
 * @param array $params Массив параметров для запроса
 * @return mixed Результат выполнения запроса
 */
function executeQuery($pdo, $query, $params = [])
{
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Ошибка выполнения запроса: " . $e->getMessage());
    }
}

/**
 * Функция для защиты от SQL-инъекций
 * @param string $data Входные данные
 * @return string Очищенные данные
 */
function sanitizeInput($data)
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Функция для генерации SEO-метатегов
 * @param string $title Заголовок страницы
 * @param string $description Описание страницы
 */
function generateMetaTags($title, $description)
{
    echo "<title>" . sanitizeInput($title) . "</title>\n";
    echo "<meta name='description' content='" . sanitizeInput($description) . "'>\n";
}

/**
 * Функция для кэширования данных
 * @param string $key Ключ кэширования
 * @param mixed $data Данные для кэширования
 * @param int $ttl Время жизни кэша в секундах
 */
function cacheData($key, $data, $ttl = 3600)
{
    $cacheFile = 'cache/' . $key . '.cache';
    file_put_contents($cacheFile, serialize(['data' => $data, 'expires' => time() + $ttl]));
}

/**
 * Функция для проверки кэша
 * @param string $key Ключ кэширования
 * @return mixed Кэшированные данные или false, если кэш истек
 */
function getCache($key)
{
    $cacheFile = 'cache/' . $key . '.cache';
    if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
        if ($cache['expires'] > time()) {
            return $cache['data'];
        }
    }
    return false;
}

// Функция для создания кэша
function cachePage($key, $content, $ttl = 3600)
{
    $cacheFile = 'cache/' . md5($key) . '.cache';
    $data = [
        'content' => $content,
        'expires' => time() + $ttl,
    ];
    file_put_contents($cacheFile, serialize($data));
}

// Функция для получения кэша
function getPageCache($key)
{
    $cacheFile = 'cache/' . md5($key) . '.cache';
    if (file_exists($cacheFile)) {
        $data = unserialize(file_get_contents($cacheFile));
        if ($data['expires'] > time()) {
            return $data['content'];
        }
        unlink($cacheFile); // Удаляем устаревший кэш
    }
    return false;
}

function generateSlug($string) {
    // Транслитерация кириллицы в латиницу
    $cyrillicToLatinMap = [
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm',
        'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '',
        'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
    ];

    // Преобразуем кириллицу в латиницу
    $transliterated = strtr(mb_strtolower($string, 'UTF-8'), $cyrillicToLatinMap);

    // Удаляем все ненужные символы и заменяем пробелы на дефисы
    return preg_replace('/[^a-z0-9\-]+/u', '-', $transliterated);
}
