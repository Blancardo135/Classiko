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
    <title>Mon Profil | Classiko</title>
</head>

<body>
    <main class="container">
        <h1>Mon Profil</h1>

        <p>Page privée — Vos informations personnelles.</p>

        <section>
            <h2>Informations du Compte</h2>
            <table>
                <tbody>
                    <tr>
                        <td><strong>ID :</strong></td>
                        <td><?= htmlspecialchars($userId) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Prénom :</strong></td>
                        <td><?= htmlspecialchars($firstname) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Nom :</strong></td>
                        <td><?= htmlspecialchars($lastname) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Email :</strong></td>
                        <td><?= htmlspecialchars($email) ?></td>
                    </tr>
                    <tr>
                        <td><strong>Rôle :</strong></td>
                        <td><strong><?= htmlspecialchars($role) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Actions</h2>
            <p>
                <a href="private.php"><button>Page Privée</button></a>
                <a href="dashboard.php"><button>Tableau de Bord</button></a>
                <a href="index.php"><button>Accueil</button></a>
                <a href="auth/logout.php"><button>Se déconnecter</button></a>
            </p>
        </section>
    </main>
</body>

</html>
