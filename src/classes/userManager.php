<?php
require_once __DIR__ . '/Database.php';

class UserManager {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    // Ajouter un utilisateur
    public function addUser(string $username, string $password, string $role = 'user'): bool {
        $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
        $stmt = $this->db->getPdo()->prepare($sql);
        return $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':role' => $role
        ]);
    }

    // Vérifier un utilisateur (login)
    public function verifyUser(string $username, string $password): ?array {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user; 
        }
        return null;
    }
}
