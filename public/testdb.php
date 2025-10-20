<?php
require_once __DIR__ . '/../src/Database.php';

// On crée une instance => ça exécute ton constructeur + la création de tables
$db = new Database();

echo "<h2>✅ Base et tables créées (teams + players)</h2>";
?>