<?php

session_start();

// Vérifie si l'utilisateur est authentifié
$userId = $_SESSION['user_id'] ?? null;

// L'utilisateur n'est pas authentifié
if (!$userId) {
    // Redirige vers la page de connexion si l'utilisateur n'est pas authentifié
    header('Location: auth/login.php');
    exit();
}

// Sinon, récupère les autres informations de l'utilisateur
$email = $_SESSION['email'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>Page privée | Gestionnaire d'équipes</title>
</head>

<body>
    <main class="container">
        <h1>🔒 Page Privée</h1>

        <p>Cette page est accessible uniquement aux personnes authentifiées.</p>

        <section>
            <h2>✅ Vous êtes connecté.e</h2>
            <ul>
                <li><strong>ID utilisateur :</strong> <?= htmlspecialchars($userId) ?></li>
                <li><strong>Prénom :</strong> <?= htmlspecialchars($_SESSION['firstname'] ?? '') ?></li>
                <li><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['lastname'] ?? '') ?></li>
                <li><strong>Email :</strong> <?= htmlspecialchars($email) ?></li>
                <li><strong>Rôle :</strong> <strong><?= htmlspecialchars($role) ?></strong></li>
            </ul>
        </section>

        <section>
            <h2>Navigation Privée</h2>
            <p>
                <a href="profile.php"><button>Mon Profil</button></a>
                <a href="dashboard.php"><button>Tableau de Bord</button></a>
                <a href="resources.php"><button>Mes Ressources</button></a>
                <a href="index.php"><button>Accueil</button></a>
                <a href="auth/logout.php"><button>🚪 Se déconnecter</button></a>
            </p>
        </section>
    </main>
</body>

</html>