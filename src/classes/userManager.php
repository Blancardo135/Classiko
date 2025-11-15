<?php
require_once __DIR__ . '/Database.php';

class UserManager {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    /**
     * Crée un nouvel utilisateur
     */
    public function createUser(string $firstname, string $lastname, string $email, string $password, string $role = 'user'): bool {
        try {
            // Vérifier si l'email existe déjà
            if ($this->emailExists($email)) {
                throw new Exception('Cet email est déjà utilisé.');
            }

            // Valider l'email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Email invalide.');
            }

            // Hacher le mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            
            $sql = "INSERT INTO users (firstname, lastname, email, password, role) 
                    VALUES (:firstname, :lastname, :email, :password, :role)";
            $stmt = $this->db->getPdo()->prepare($sql);
            return $stmt->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':role' => $role
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Vérifie les identifiants de connexion
     */
    public function verifyUser(string $email, string $password): ?array {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Ne pas retourner le mot de passe
            return $user;
        }
        return null;
    }

    /**
     * Récupère un utilisateur par son email
     */
    public function getUserByEmail(string $email): ?array {
        $sql = "SELECT id, firstname, lastname, email, role, created_at FROM users WHERE email = :email";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Récupère un utilisateur par son ID
     */
    public function getUserById(int $id): ?array {
        $sql = "SELECT id, firstname, lastname, email, role, created_at FROM users WHERE id = :id";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Vérifie si un email existe
     */
    public function emailExists(string $email): bool {
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() !== false;
    }

    /**
     * Met à jour les informations d'un utilisateur
     */
    public function updateUser(int $id, array $data): bool {
        $allowedFields = ['firstname', 'lastname', 'email', 'role'];
        $fields = [];
        $params = [':id' => $id];

        foreach ($data as $key => $value) {
            if (in_array($key, $allowedFields)) {
                $fields[] = "$key = :$key";
                $params[":$key"] = $value;
            }
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->db->getPdo()->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Change le mot de passe d'un utilisateur
     */
    public function changePassword(int $id, string $currentPassword, string $newPassword): bool {
        // Récupérer le mot de passe actuel
        $sql = "SELECT password FROM users WHERE id = :id";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            throw new Exception('Mot de passe actuel incorrect.');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $stmt = $this->db->getPdo()->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':password' => $hashedPassword
        ]);
    }

    /**
     * Récupère tous les utilisateurs
     */
    public function getAllUsers(): array {
        $sql = "SELECT id, firstname, lastname, email, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->getPdo()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Supprime un utilisateur
     */
    public function deleteUser(int $id): bool {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->getPdo()->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
