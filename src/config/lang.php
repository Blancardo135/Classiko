<?php

const DEFAULT_LANGUAGE = 'en';


const SUPPORTED_LANGUAGES = ['fr', 'en'];


if (isset($_GET['lang']) && in_array($_GET['lang'], SUPPORTED_LANGUAGES)) {
    setcookie('language', $_GET['lang'], time() + (30 * 24 * 60 * 60), '/');
    $_COOKIE['language'] = $_GET['lang'];
}


$language = DEFAULT_LANGUAGE;
if (isset($_COOKIE['language']) && in_array($_COOKIE['language'], SUPPORTED_LANGUAGES)) {
    $language = $_COOKIE['language'];
}

// ça cest pour les traductions
function t($key)
{
    global $translations, $language;
    return (isset($translations[$language][$key]) && $translations[$language][$key] !== '')
        ? $translations[$language][$key]
        : $key;
}