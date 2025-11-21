<?php

require_once __DIR__ . '/../utils/autoloader.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
const MAIL_CONFIGURATION_FILE = __DIR__ . '/../../config/mail.ini';
 
class Mail implements MailInterface
{
    private string $firstname;
    private string $lastname;
    private string $email;
 
    public function __construct(string $firstname, string $lastname, string $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }
 
    public function sendMail(): void
    {
        $config = parse_ini_file(MAIL_CONFIGURATION_FILE, true);
 
        if (!$config) {
            throw new Exception("Erreur lors de la lecture du fichier de configuration : " . MAIL_CONFIGURATION_FILE);
        }
 
        $host = $config['host'];
        $port = filter_var($config['port'], FILTER_VALIDATE_INT);
        $authentication = filter_var($config['authentication'], FILTER_VALIDATE_BOOLEAN);
        $username = $config['username'];
        $password = $config['password'];
        $from_email = $config['from_email'];
        $from_name = $config['from_name'];
 
        $mail = new PHPMailer(true);
 
        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPAuth = $authentication;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
 
            $mail->setFrom($from_email, $from_name);
            $mail->addAddress($this->email, $this->firstname . ' ' . $this->lastname);
 
            $mail->isHTML(true);
            $mail->Subject = 'Test de Mail depuis la classe Mail';
            $mail->Body    = 'Bonjour <b>' . htmlspecialchars($this->firstname) . '</b>, ceci est un test d’envoi HTML.';
            $mail->AltBody = 'Bonjour ' . $this->firstname . ', ceci est un test en texte brut.';
 
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
 
    // Getters
    public function getFirstname(): string
    {
        return $this->firstname;
    }
 
    public function getLastname(): string
    {
        return $this->lastname;
    }
 
    public function getEmail(): string
    {
        return $this->email;
    }

    public function sendConfirmationEmail(): void
    {
        $config = parse_ini_file(MAIL_CONFIGURATION_FILE, true);

        if (!$config) {
            throw new Exception("Erreur lors de la lecture du fichier de configuration : " . MAIL_CONFIGURATION_FILE);
        }

        $host = $config['host'];
        $port = filter_var($config['port'], FILTER_VALIDATE_INT);
        $authentication = filter_var($config['authentication'], FILTER_VALIDATE_BOOLEAN);
        $username = $config['username'];
        $password = $config['password'];
        $from_email = $config['from_email'];
        $from_name = $config['from_name'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $host;
            $mail->Port = $port;
            $mail->SMTPAuth = $authentication;
            $mail->Username = $username;
            $mail->Password = $password;
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";

            $mail->setFrom($from_email, $from_name);
            $mail->addAddress($this->email, $this->firstname . ' ' . $this->lastname);

            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue sur Classiko - Confirmation de votre compte';
            $mail->Body = $this->getConfirmationEmailBody();
            $mail->AltBody = $this->getConfirmationEmailAltBody();

            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'envoi du mail de confirmation : {$mail->ErrorInfo}");
        }
    }

    private function getConfirmationEmailBody(): string
    {
        $fullname = htmlspecialchars($this->firstname . ' ' . $this->lastname);
        return <<<HTML
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur Classiko</title>
    <!--css de IA!-->
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #007bff;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin-top: 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue sur Classiko!</h1>
        </div>
        <div class="content">
            <p>Bonjour <strong>{$fullname}</strong>,</p>
            <p>Merci d'avoir créé un compte sur <strong>Classiko</strong>! Votre inscription a été confirmée avec succès.</p>
            <p>Vous pouvez maintenant accéder à tous les services de notre plateforme :</p>
            <ul>
                <li>Gérer vos équipes</li>
                <li>Gérer vos joueurs</li>
                <li>Accéder aux ressources</li>
            </ul>
            <p>Votre adresse email : <strong>{$this->email}</strong></p>
            <p>Si vous avez des questions ou besoin d'aide, n'hésitez pas à nous contacter.</p>
            <p>À bientôt sur Classiko!</p>
        </div>
        <div class="footer">
            <p>&copy; 2025 Classiko. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
HTML;
    }

    private function getConfirmationEmailAltBody(): string
    {
        $fullname = $this->firstname . ' ' . $this->lastname;
        return <<<TEXT
Bienvenue sur Classiko!

Bonjour {$fullname},

Merci d'avoir créé un compte sur Classiko! Votre inscription a été confirmée avec succès.

Vous pouvez maintenant accéder à tous les services de notre plateforme :

Votre adresse email : {$this->email}

Si vous avez des questions ou besoin d'aide, n'hésitez pas à nous contacter.

À bientôt sur Classiko!

© 2025 Classiko. Tous droits réservés.
TEXT;
    }

    }
