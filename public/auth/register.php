<?php
// Inclure l'autoloader et la configuration
require_once __DIR__ . '/../../src/utils/autoloader.php';

use classes\Mail\Mail;

// Démarrer la session
session_start();

// Si l'utilisateur est déjà connecté, le rediriger
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error = '';
$success = '';

// Traiter le formulaire d'inscription
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Validation des données
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = 'Tous les champs sont obligatoires.';
    } elseif (strlen($firstname) < 2) {
        $error = 'Le prénom doit contenir au moins 2 caractères.';
    } elseif (strlen($lastname) < 2) {
        $error = 'Le nom doit contenir au moins 2 caractères.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'L\'adresse email est invalide.';
    } elseif (strlen($password) < 8) {
        $error = 'Le mot de passe doit contenir au moins 8 caractères.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Les mots de passe ne correspondent pas.';
    } else {
        try {
            
            $userManager = new userManager();

           
            $userManager->createUser($firstname, $lastname, $email, $password, 'user');
            
          
            try {
                $mailer = new classes\Mail\Mail($firstname, $lastname, $email);
                $mailer->sendConfirmationEmail();
            } catch (Exception $mailError) {
                
                error_log('Erreur lors de l\'envoi du mail de confirmation : ' . $mailError->getMessage());
            }
            
            $success = 'Compte créé avec succès ! Un email de confirmation a été envoyé. Vous pouvez maintenant vous connecter.';
            
         //Romain pour raul et pierre sa c juste un truc qui fait un chargement avant de rediriger vers la page de co après 3s
            header('Refresh: 3; url=login.php');
        } catch (Exception $e) {
            $error = 'Erreur : ' . $e->getMessage();
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
    <title>Créer un compte | Classiko</title>
</head>

<body>
    <main class="container">
        <h1>Créer un compte</h1>

        <?php if ($error): ?>
            <article style="background-color: #ffdddd; border: 1px solid #ff6b6b; padding: 1rem; border-radius: 0.5rem;">
                <p><strong>❌ Erreur :</strong> <?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <?php if ($success): ?>
            <article style="background-color: #ddffdd; border: 1px solid #51cf66; padding: 1rem; border-radius: 0.5rem;">
                <p><strong>✅ Succès :</strong> <?= htmlspecialchars($success) ?></p>
                <p>Redirection vers la page de connexion...</p>
                <p><a href="login.php">Cliquez ici si la redirection ne fonctionne pas</a></p>
            </article>
        <?php else: ?>
            <form method="post">
                <label for="firstname">
                    Prénom
                    <input type="text" id="firstname" name="firstname" required autofocus minlength="2">
                </label>

                <label for="lastname">
                    Nom
                    <input type="text" id="lastname" name="lastname" required minlength="2">
                </label>

                <label for="email">
                    Adresse email
                    <input type="email" id="email" name="email" required>
                </label>

                <label for="password">
                    Mot de passe (min. 8 caractères)
                    <input type="password" id="password" name="password" required minlength="8">
                </label>

                <label for="confirm_password">
                    Confirmer le mot de passe
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </label>

                <button type="submit">Créer mon compte</button>
            </form>

            <p>Vous avez déjà un compte ? <a href="login.php">Se connecter</a></p>
            <p><a href="../index.php">Retour à l'accueil</a></p>
        <?php endif; ?>
    </main>
</body>

</html>