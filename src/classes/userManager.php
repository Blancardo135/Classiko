<?php
//require_once __DIR__ . '/Database.php';

class UserManager
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getPdo();
    }

    public function createUser(string $firstname, string $lastname, string $email, string $password, string $role = 'user')
    {
        if ($this->emailExists($email)) {
            throw new \Exception('Un compte existe déjà avec cette adresse e-mail.');
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare('INSERT INTO users (firstname, lastname, email, password, role) VALUES (:firstname, :lastname, :email, :password, :role)');
        $result = $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':password' => $hash,
            ':role' => $role,
        ]);

        if (!$result) {
            throw new \Exception('Impossible de créer l\'utilisateur, veuillez réessayer.');
        }

        return true;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function verifyUser(string $email, string $password)
    {
        $stmt = $this->pdo->prepare('SELECT id, firstname, lastname, email, password, role FROM users WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }

        return false;
    }

    public function getUserById(int $id)
    {
        $stmt = $this->pdo->prepare('SELECT id, firstname, lastname, email, role, created_at FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}


