<?php
const DATABASE_FILE = __DIR__ . '/../../teamsmanager.db';
$pdo = new PDO('sqlite:' . DATABASE_FILE);

$pdo->exec('
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT "utilisateur"
        )
    ');

require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

echo '<a href="../index.php">' . t('back_home') . '</a>';