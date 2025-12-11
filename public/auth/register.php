<?php

session_start();

require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

session_start();


if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';


    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = t('error_required_fields');
    } elseif (strlen($firstname) < 2) {
        $error = t('error_firstname_min');
    } elseif (strlen($lastname) < 2) {
        $error = t('error_lastname_min');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = t('error_invalid_email');
    } elseif (strlen($password) < 8) {
        $error = t('error_password_min');
    } elseif ($password !== $confirmPassword) {
        $error = t('error_password_mismatch');
    } else {
        try {
            
            $userManager = new userManager();

           
            $userManager->createUser($firstname, $lastname, $email, $password, 'user');
            
          
            try {
                $mailer = new Mail($firstname, $lastname, $email);
                $mailer->sendConfirmationEmail();
            } catch (Exception $mailError) {
                
                error_log('Erreur lors de l\'envoi du mail de confirmation : ' . $mailError->getMessage());
            }
            
            $success = t('registration_success');
            
         //Romain pour raul et pierre sa c juste un truc qui fait un chargement avant de rediriger vers la page de co après 3s
            header('Refresh: 3; url=login.php');
        } catch (Exception $e) {
            $msg = $e->getMessage();
            //Pierre pour romain et le R, chaine de caractères pour pas que ca ecrive erreur: erreur pr le mail (standard)
            $msg = preg_replace('/^\s*Erreur\s*[:\-–]?\s*/i', '', $msg);
            $error = $msg;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <title><?= t('create_account_title') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('create_account_heading') ?></h1>

        <?php if ($error): ?>
            <article style="background-color: #ffdddd; border: 1px solid #ff6b6b; padding: 1rem; border-radius: 0.5rem;">
                <p><strong><?= t('error_occurred') ?> :</strong> <?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <?php if ($success): ?>
            <article style="background-color: #ddffdd; border: 1px solid #51cf66; padding: 1rem; border-radius: 0.5rem;">
                <p><strong><?= t('form_submit') ?></strong> <?= htmlspecialchars($success) ?></p>
                <p><?= t('redirecting_login') ?></p>
                <p><a href="login.php"><?= t('click_here_redirect') ?></a></p>
            </article>
        <?php else: ?>
            <form method="post">
                <label for="firstname"><?= t('register_firstname_label') ?>
                    <input type="text" id="firstname" name="firstname" required autofocus minlength="2">
                </label>

                <label for="lastname"><?= t('register_lastname_label') ?>
                    <input type="text" id="lastname" name="lastname" required minlength="2">
                </label>

                <label for="email"><?= t('email_label') ?>
                    <input type="email" id="email" name="email" required>
                </label>

                <label for="password"><?= t('password_help') ?>
                    <input type="password" id="password" name="password" required minlength="8">
                </label>

                <label for="confirm_password"><?= t('confirm_password_label') ?>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </label>

                <button type="submit"><?= t('create_account_submit') ?></button>
            </form>

            <p><?= t('already_have_account') ?> <a href="login.php"><?= t('login') ?></a></p>
            <p><a href="../index.php"><?= t('back_home') ?></a></p>
        <?php endif; ?>
    </main>
</body>

</html>