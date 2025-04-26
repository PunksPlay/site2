<?php

// includes/functions.php

/**
 * Функция для безопасного выполнения SQL-запросов
 * @param PDO   $pdo   Объект PDO
 * @param string $query SQL-запрос
 * @param array  $params Параметры запроса
 * @return array
 */
function executeQuery(PDO $pdo, string $query, array $params = []): array
{
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die('Ошибка выполнения запроса: ' . $e->getMessage());
    }
}

/**
 * Экранирование пользовательского ввода для безопасности
 */
function sanitizeInput(string $data): string
{
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Генерация SEO-метатегов
 */
function generateMetaTags(string $title, string $description): void
{
    echo '<title>' . sanitizeInput($title) . '</title>\n';
    echo '<meta name="description" content="' . sanitizeInput($description) . '">\n';
}

/**
 * Кэширование данных в файл
 */
function cacheData(string $key, $data, int $ttl = 3600): void
{
    $cacheFile = __DIR__ . '/cache/' . md5($key) . '.cache';
    file_put_contents($cacheFile, serialize(['data' => $data, 'expires' => time() + $ttl]));
}

/**
 * Получение кэшированных данных или false
 */
function getCache(string $key)
{
    $cacheFile = __DIR__ . '/cache/' . md5($key) . '.cache';
    if (!file_exists($cacheFile)) {
        return false;
    }
    $cache = unserialize(file_get_contents($cacheFile));
    if ($cache['expires'] > time()) {
        return $cache['data'];
    }
    unlink($cacheFile);
    return false;
}

/**
 * Генерация SEO-френдли slug
 */
function generateSlug(string $string): string
{
    $map = [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo',
        'ж'=>'zh','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m',
        'н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u',
        'ф'=>'f','х'=>'kh','ц'=>'ts','ч'=>'ch','ш'=>'sh','щ'=>'shch','ъ'=>'',
        'ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya'
    ];
    $s = mb_strtolower($string, 'UTF-8');
    $s = strtr($s, $map);
    return preg_replace('/[^a-z0-9\-]+/u', '-', $s);
}

/**
 * Форматирование даты-времени на русском: "28 марта 2025 19:19"
 */
function formatDateRu(string $datetime): string
{
    $ts = strtotime($datetime);
    if (!$ts) {
        return '';
    }
    static $months = [
        1=>'января',2=>'февраля',3=>'марта',4=>'апреля',
        5=>'мая',6=>'июня',7=>'июля',8=>'августа',
        9=>'сентября',10=>'октября',11=>'ноября',12=>'декабря'
    ];
    $day   = date('d', $ts);
    $month = $months[(int)date('n', $ts)];
    $year  = date('Y', $ts);
    $time  = date('H:i', $ts);
    return "$day $month $year $time";
}