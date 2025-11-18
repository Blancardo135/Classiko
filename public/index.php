<?php
require_once __DIR__ . '/../src/utils/autoloader.php';
require_once __DIR__ . '/../src/config/translations.php';
require_once __DIR__ . '/../src/config/lang.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$userFirstname = $_SESSION['firstname'] ?? '';

// Test d'envoi de mail
$mailTestResult = '';
if (isset($_GET['test_mail'])) {
    try {
        $configFile = __DIR__ . '/../src/config/mail.ini';
        $config = parse_ini_file($configFile, true);

        if (!$config) {
            throw new Exception("Impossible de lire le fichier mail.ini");
        }

        $mail = new PHPMailer(true);
        
        // Configuration SMTP
        $mail->isSMTP();
        $mail->Host = $config['host'];
        $mail->Port = (int)$config['port'];
        $mail->SMTPAuth = (bool)$config['authentication'];
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];
        $mail->CharSet = "UTF-8";
        $mail->Encoding = "base64";

        // Expéditeur et destinataire
        $mail->setFrom($config['from_email'], $config['from_name']);
        $mail->addAddress('contact@classiko.ch', 'Contact Classiko');

        // Contenu du mail
        $mail->isHTML(true);
        $mail->Subject = 'Test depuis Classiko - ' . date('d/m/Y H:i:s');
        $mail->Body    = '<h1>🎉 Test d\'envoi de mail</h1>
                          <p>Ce mail a été envoyé depuis <b>Classiko</b></p>
                          <p>Date: ' . date('d/m/Y à H:i:s') . '</p>
                          <p>Configuration utilisée: <b>' . $config['host'] . ':' . $config['port'] . '</b></p>';
        $mail->AltBody = 'Test d\'envoi de mail depuis Classiko le ' . date('d/m/Y à H:i:s');

        $mail->send();
        $mailTestResult = 'success';
    } catch (Exception $e) {
        $mailTestResult = 'error: ' . $mail->ErrorInfo;
    }
}
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
    <style>
        .menu-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .menu-buttons a button {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            border-radius: 0.5rem;
        }

        .menu-section h2 {
            margin-bottom: 0.5rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #ddffdd;
            border: 2px solid #51cf66;
            color: #2f6e2f;
        }

        .alert-error {
            background-color: #ffdddd;
            border: 2px solid #ff6b6b;
            color: #8b2020;
        }
    </style>
</head>

<body>
    <main class="container">
        <h1><?= t('teams_management') ?></h1>

        <p><?= t('welcome') ?></p>

        <!-- Résultat du test mail -->
        <?php if ($mailTestResult === 'success'): ?>
            <div class="alert alert-success">
                <h3>✅ Mail envoyé avec succès !</h3>
                <p>Vérifiez votre boîte mail ou Mailpit (http://localhost:8025)</p>
            </div>
        <?php elseif (strpos($mailTestResult, 'error:') === 0): ?>
            <div class="alert alert-error">
                <h3>❌ Erreur lors de l'envoi</h3>
                <p><strong>Détails :</strong> <?= htmlspecialchars(substr($mailTestResult, 7)) ?></p>
            </div>
        <?php endif; ?>

        <!-- Bouton de test en évidence -->
        <section class="menu-section">
            <h2>🧪 Tester l'envoi de mail</h2>
            <p style="color: gray; font-size: 0.9rem;">Configuration actuelle : Mailpit (localhost:1025)</p>
            <a href="?test_mail=1">
                <button style="background-color: #4CAF50; font-size: 1.1rem; padding: 0.75rem 1.5rem;">
                    📧 Envoyer un mail de test
                </button>
            </a>
        </section>

        <hr>

        <p><a href="/public/team/index.php"><button>Voir les équipes</button></a></p>
        <p><a href="player/index.php"><button>Voir les joueurs</button></a></p>

        <!-- Pages Publiques -->
        <section class="menu-section">
            <h2>Pages Publiques</h2>
            <div class="menu-buttons">
                <a href="public.php"><button>Page Publique</button></a>
                <a href="team/index.php"><button>Voir les Équipes</button></a>
                <a href="player/index.php"><button>Voir les Joueurs</button></a>
            </div>
        </section>

        <!-- Authentification -->
        <section class="menu-section">
            <h2>Authentification</h2>
            <div class="menu-buttons">
                <?php if (!$isLoggedIn) { ?>
                    <a href="auth/login.php"><button>Se Connecter</button></a>
                    <a href="auth/register.php"><button>Créer un Compte</button></a>
                <?php } else { ?>
                    <a href="auth/logout.php"><button>Se Déconnecter</button></a>
                <?php } ?>
            </div>
        </section>

        <!-- Pages Privées (si connecté) -->
        <?php if ($isLoggedIn) { ?>
            <section class="menu-section">
                <h2>Mes différents espaces</h2>
                <div class="menu-buttons">
                    <a href="private.php"><button>Page Privée</button></a>
                    <a href="profile.php"><button>Mon Profil</button></a>
                    <a href="dashboard.php"><button>Mon Tableau de Bord</button></a>
                    <a href="resources.php"><button>Mes Ressources</button></a>
                </div>
            </section>
        <?php } ?>

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
    </main>
</body>