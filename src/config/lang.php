<?php
require_once __DIR__ . '/../src/config/translations.php';

// Langue par défaut
const DEFAULT_LANGUAGE = 'en';

// choix de langue avec url
if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $translations)) {
    setcookie('language', $_GET['lang'], time() + (30 * 24 * 60 * 60));
    $_COOKIE['language'] = $_GET['lang'];
}

$language = DEFAULT_LANGUAGE;
if (isset($_COOKIE['language']) && array_key_exists($_COOKIE['language'], $translations)) {
    $language = $_COOKIE['language'];
}

// fonction trad
function t($key) {
    global $translations, $language;
    return (isset($translations[$language][$key]) && $translations[$language][$key] !== '')
        ? $translations[$language][$key]
        : $key;
}
?>
