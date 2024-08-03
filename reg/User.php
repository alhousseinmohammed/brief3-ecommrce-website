<?php
class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $email;
    public $password;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login() {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($this->password, $user['password'])) {
            $this->id = $user['user_id'];
            return true;
        }

        return false;
    }
}
?>
