<?php

require_once __DIR__ . '/MailInterface.php';

use PHPMailer\PHPMailer\PHPMailer;

class Mail implements MailInterface
{
    private string $firstname;
    private string $lastname;
    private string $email;
    private array $config = [];

    public function __construct(string $firstname, string $lastname, string $email)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;

        $configPath = __DIR__ . '/../config/mail.ini';
        if (file_exists($configPath)) {
            $this->config = parse_ini_file($configPath);
        }
    }

    public function sendMail(): void
    {
        $this->sendConfirmationEmail();
    }

    public function sendConfirmationEmail(): void
    {
        $host = $this->config['host'] ?? 'localhost';
        $port = (int)($this->config['port'] ?? 25);
        $auth = isset($this->config['authentication']) ? filter_var($this->config['authentication'], FILTER_VALIDATE_BOOLEAN) : false;
        $username = $this->config['username'] ?? '';
        $password = $this->config['password'] ?? '';
        $fromEmail = $this->config['from_email'] ?? 'no-reply@example.com';
        $fromName = $this->config['from_name'] ?? 'No Reply';

        $mail = new PHPMailer(true);

        try {
            
            if ($auth) {
                $mail->isSMTP();
                $mail->Host = $host;
                $mail->Port = $port;
                $mail->SMTPAuth = true;
                $mail->Username = $username;
                $mail->Password = $password;

                if (!empty($this->config['encryption'])) {
                    $mail->SMTPSecure = $this->config['encryption'];
                } else {
                    if ($port === 465) {
                        $mail->SMTPSecure = 'ssl';
                    } elseif ($port === 587) {
                        $mail->SMTPSecure = 'tls';
                    }
                }
            }

            $mail->setFrom($fromEmail, $fromName);
            $mail->addAddress($this->email, trim($this->firstname . ' ' . $this->lastname));

            $mail->isHTML(true);
            $mail->Subject = 'Bienvenue sur Classiko — Confirmation d\'inscription';

            $body = '<p>Bonjour ' . htmlspecialchars($this->firstname, ENT_QUOTES, 'UTF-8') . ' ' . htmlspecialchars($this->lastname, ENT_QUOTES, 'UTF-8') . ',</p>' .
                '<p>Merci pour votre inscription sur <strong>Classiko</strong> !</p>' .
                '<p>Votre compte a bien été créé avec l\'adresse : ' . htmlspecialchars($this->email, ENT_QUOTES, 'UTF-8') . '.</p>' .
                '<p>Vous pouvez maintenant vous connecter en utilisant votre adresse email et votre mot de passe.</p>' .
                '<p>Cordialement,<br>Équipe Classiko</p>';

            $mail->Body = $body;
            $mail->AltBody = 'Bonjour ' . $this->firstname . ' ' . $this->lastname . "\n\n" .
                'Merci pour votre inscription sur Classiko !\n' .
                'Votre compte a bien été créé avec l\'adresse : ' . $this->email . "\n\n" .
                'Cordialement,\nÉquipe Classiko';

            if (!$mail->send()) {
                throw new \Exception('Erreur lors de l\'envoi de l\'email : ' . $mail->ErrorInfo);
            }
        } catch (\Exception $e) {
            
            throw $e;
        }
    }
}
