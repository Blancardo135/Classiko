<?php
//testdb
require_once __DIR__ . '/../src/TeamsManager.php';
require_once __DIR__ . '/../src/PlayersManager.php';
// On crée une instance => ça exécute ton constructeur + la création de tables
$db = new Database();

echo "<h2>✅ Base et tables créées (teams + players)</h2>";
?>