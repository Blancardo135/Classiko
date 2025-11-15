<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';

session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Tous les champs sont obligatoires.';
    } else {
        try {
            $userManager = new userManager();
            $user = $userManager->verifyUser($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'] ?? '';
                $_SESSION['lastname'] = $user['lastname'] ?? '';
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                header('Location: ../index.php');
                exit();
            } else {
                $error = 'Email ou mot de passe incorrect.';
            }
        } catch (Exception $e) {
            $error = 'Erreur lors de la connexion: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title>Se connecter | Gestion des sessions</title>
</head>

<body>
    <main class="container">
        <h1>Se connecter</h1>

        <?php if ($error): ?>
            <article style="background-color: var(--pico-del-color);">
                <p><strong>Erreur :</strong> <?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <form method="post">
            <label for="email">
                Email
                <input type="email" id="email" name="email" required autofocus>
            </label>

            <label for="password">
                Mot de passe
                <input type="password" id="password" name="password" required>
            </label>

            <button type="submit">Se connecter</button>
        </form>

        <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>

        <p><a href="../index.php">Retour à l'accueil</a></p>
    </main>
</body>

</html>