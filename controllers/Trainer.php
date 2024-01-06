<?php

class Trainer{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function addTrainer($name, $age, $image, $hire_date, $gender, $expertise)
    {
        $mysqli = $this->db->getConnection();
    
        // Check if an image was uploaded successfully
        if ($image['error'] == UPLOAD_ERR_OK) {
            // Specify the upload directory
            $uploadDir = '../uploads/trainer/';
    
            // Generate a unique name for the uploaded file
            $uploadFile = $uploadDir . uniqid() . '_' . basename($image['name']);
            if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
                // Use prepared statements to prevent SQL injection
                $stmt = $mysqli->prepare("INSERT INTO trainers (name, age, image_url, hire_date, gender, expertise) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sissss", $name, $age, $uploadFile, $hire_date, $gender, $expertise);
    
                $stmt->execute();
                $trainer_id = $mysqli->insert_id;
    
                 $stmt->close();
                    return $trainer_id;
            } else {
                return "Failed to move the uploaded file.";
            }
        } else {
            return "Image upload failed.";
        }
    }

        public function getAllTrainers()
        {
            $query = "SELECT * FROM trainers";
            $result = $this->db->getConnection()->query($query);

            return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
        }

}




