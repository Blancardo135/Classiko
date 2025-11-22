<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';

// Démarre la session
session_start();

// Vérifie si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: auth/login.php');
    exit();
}

// Refuser l'accès et afficher un message d'erreur avec un code 403 Forbidden
http_response_code(403);
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('access_denied_title') ?> | <?= t('teams_management') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('access_denied') ?></h1>

        <article style="background-color: var(--pico-del-color);">
            <p><strong><?= t('no_permission') ?></strong></p>
        </article>

        <p><?= t('page_reserved_authors') ?></p>

        <p><?= sprintf(t('you_are_logged_as_role'), htmlspecialchars($_SESSION['email']), htmlspecialchars($_SESSION['role'] === 'author' ? 'Auteur.trice' : 'Lecteur.trice')) ?></p>

        <h2><?= t('how_to_become_author') ?></h2>

        <p><?= t('become_author_paragraph') ?></p>

        <p><a href="index.php"><?= t('return_home') ?></a></p>
    </main>
</body>

</html>