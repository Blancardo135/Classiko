<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';
 
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light dark">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
<link rel="stylesheet" href="css/custom.css">
<title><?= t('home') ?> | <?= t('teams_management') ?></title>
</head>
 
<body>
<main class="container">
<h1><?= t('teams_management') ?></h1>
 
        <p><?= t('welcome') ?></p>
 
        <p><a href="team/index.php"><button><?= t('view_teams') ?></button></a></p>
<p><a href="player/index.php"><button><?= t('view_players') ?></button></a></p>
 
<!-- cookie langue -->
<hr>
<form method="get" style="margin-top: 1em;">
<label for="lang"><?= t('choose_language') ?> :</label>
<select name="lang" id="lang" onchange="this.form.submit()">
<option value="fr" <?= ($language === 'fr') ? 'selected' : '' ?>>Français</option>
<option value="en" <?= ($language === 'en') ? 'selected' : '' ?>>English</option>
</select>
</form>
 
        <p style="font-size: 0.9em; color: gray;"><?= t('current_language') ?> <?= strtoupper($language) ?></p>
<!-- cookie langue -->
</main>
</body>
</html>