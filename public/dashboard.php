<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'] ?? '';
$lastname = $_SESSION['lastname'] ?? '';
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>Mon Tableau de Bord | Classiko</title>
</head>

<body>
    <main class="container">
        <h1>Mon Tableau de Bord</h1>

        <p>Page privée — Espace personnel.</p>

        <section>
            <h2>Bienvenue <?= htmlspecialchars($firstname) ?> !</h2>
            <p>Vous êtes connecté en tant que <strong><?= htmlspecialchars($role) ?></strong>.</p>
        </section>

        <section>
            <h2>Consultez uniquement vos créations :</h2>
            <!-- Ici on met que les équipes du joueur!-->
            <p>
                <a href="team/index.php"><button>Voir les Équipes</button></a>
                <a href="player/index.php"><button>Voir les Joueurs</button></a>
            </p>
        </section>

        <section>
            <h2>Actions</h2>
            <p>
                <a href="index.php"><button>Accueil</button></a>
                <a href="auth/logout.php"><button>Se déconnecter</button></a>
            </p>
        </section>
    </main>
</body>

</html>
