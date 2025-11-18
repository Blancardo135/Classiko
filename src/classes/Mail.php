<?php
 
namespace classes\Mail;
 
require_once __DIR__ . '/../../utils/autoloader.php';
 
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
}