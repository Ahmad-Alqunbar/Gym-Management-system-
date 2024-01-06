<?php

class User
{
    protected $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
        //    session_start(); 
    }

    public function login($email, $password)
    {
        // Validate email and password (add more validation as needed)
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email and password are required.'];
        }

        // Query the database for the user with the provided email
        $stmt = $this->db->getConnection()->prepare("SELECT user_id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // Check if the user was found
        if ($result) {
            // Verify the password using password_verify
            if (password_verify($password, $result['password'])) {
                return ['success' => true, 'user_id' => $result['user_id']];
            } else {
                return ['success' => false, 'message' => 'Incorrect password.'];
            }
        }

        return ['success' => false, 'message' => 'User not found.'];
    }


    public function logout()
    {
        // Unset all session variables
        $_SESSION = [];

        // Destroy the session
        session_destroy();
    }


    public function getUsersWithRolesPaginated($page, $perPage)
    {
        // Calculate offset for pagination
        $offset = ($page - 1) * $perPage;

        // Fetch users with their associated roles for the given page
        $query = "SELECT users.*, roles.name AS role
              FROM users
              LEFT JOIN roles ON users.role_id = roles.role_id
              LIMIT ?, ?";

        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("ii", $offset, $perPage);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $result;
    }


    public function getTotalPages($perPage)
    {
        // Calculate total number of users
        $totalCountQuery = "SELECT COUNT(DISTINCT user_id) AS total FROM users";
        $totalCountResult = $this->db->getConnection()->query($totalCountQuery);
        $totalCount = $totalCountResult->fetch_assoc()['total'];

        // Calculate total pages
        $totalPages = ceil($totalCount / $perPage);

        return $totalPages;
    }
    // Inside your User class
    public function addUser($name, $email, $password, $phone, $address, $role_id)
    {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the database
        $mysqli = $this->db->getConnection();

        $stmt = $mysqli->prepare("INSERT INTO users (name, email, password, phone, address, role_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $name, $email, $hashedPassword, $phone, $address, $role_id);
        $stmt->execute();

        // Get the user_id of the newly inserted user
        $user_id = $stmt->insert_id;

        $settingsController = new Setting($this->db);
        $settingsController->resetSettings($user_id);
    }


    // Inside your User class
    public function getUserDetails($user_id)
    {
        $mysqli = $this->db->getConnection();
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }
    public function updateUser($user_id, $name, $email, $phone, $address, $role_id, $password)
    {
        $mysqli = $this->db->getConnection();
    
        if ($password !== null && $password !== "") {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use "ssssiss" for the bind_param to match the types of the columns
            $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ?, password = ?, phone = ?, address = ?, role_id = ? WHERE user_id = ?");
            $stmt->bind_param("sssssii", $name, $email, $hashedPassword, $phone, $address, $role_id, $user_id);
        } else {
            // Use "ssssii" for the bind_param to match the types of the columns
            $stmt = $mysqli->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ?, role_id = ? WHERE user_id = ?");
            $stmt->bind_param("ssssii", $name, $email, $phone, $address, $role_id, $user_id);
        }
    
        $stmt->execute();
        $stmt->close();
    }
    


    public function deleteUser($user_id)
    {
        // If not associated with any roles, proceed with deletion
        $mysqli = $this->db->getConnection();
        $stmt = $mysqli->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);

        // Execute the delete
        $stmt->execute();
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            // Return a success message
            return "true";
        } else {
            // Return a message indicating that the user was not found
            return "false";
        }
    }
}
