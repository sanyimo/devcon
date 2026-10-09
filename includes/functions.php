<?php

$translations = require __DIR__ . '/translations.php';

function debug(mixed $variable): void {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s(string $html): string {
    $s = htmlspecialchars($html);
    return $s;
}

function current_page(string $path): bool
{
    $currentUrl = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

    return str_contains($currentUrl, '/admin' . $path);
}

function is_auth() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['name']) && !empty($_SESSION);
}

function is_admin() : bool {
    if(!isset($_SESSION)) {
        session_start();
    }
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function aos_animation() : void {
    $effects = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $effect = array_rand($effects, 1);
    echo ' data-aos="' . $effects[$effect] . '" ';
}

function currentLanguage(): string {
    $language = $_COOKIE['language'] ?? 'es';

    return in_array($language, ['es', 'en'], true) ? $language : 'es';
}

function t(string $text): string {
    global $translations;

    if (currentLanguage() === 'es') {
        return $text;
    }

    return $translations[$text] ?? $text;
}

function translationsForJs(): string {
    global $translations;

    return json_encode(
        currentLanguage() === 'en' ? $translations : [],
        JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_THROW_ON_ERROR
    );
}
