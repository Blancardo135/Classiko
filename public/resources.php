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
    <title>Mes Ressources | Classiko</title>
</head>

<body>
    <main class="container">
        <h1>Mes Ressources</h1>

        <p>Consultez vos créations, mais aussi celles des autres utilisateurs.</p>
        <!-- Ici on met les équipes du joueur + tout!-->

        <section>
            <h2>Équipes</h2>
            <p>Gérez vos équipes :</p>
            <!-- Mettre ici en plus"Mes équipes"-->
            <p>
                <a href="team/index.php"><button>Voir toutes les Équipes</button></a>
                <a href="team/createTeam.php"><button> Créer une Équipe</button></a>
            </p>
        </section>

        <section>
            <h2>Joueurs</h2>
            <!-- Mettre ici en plus"Mes joueurs"-->
            <p>Gérez vos joueurs :</p>
            <p>
                <a href="player/index.php"><button>Voir tous les Joueurs</button></a>
                <a href="player/createPlayer.php"><button> Créer un Joueur</button></a>
            </p>
        </section>

        <section>
            <h2>Navigation</h2>
            <p>
                <a href="index.php"><button>Accueil</button></a>
                <a href="auth/logout.php"><button>Se déconnecter</button></a>
            </p>
        </section>
    </main>
</body>

</html>
