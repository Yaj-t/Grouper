<?php
require_once('config.php');

class User
{
    private $conn;

    public function __construct()
    {
        $config = new Config(); 
        $this->conn = $config->getConnection();
    }

    public function getUserByEmail($email)
    {
        $query =    "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $name, $email, $hash);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables and redirect to dashboard
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                // Password is incorrect, return an error message
                return "Incorrect email or password.";
            }
        } else {
            // User not found, return an error message
            return 0;
        }
    }
}
