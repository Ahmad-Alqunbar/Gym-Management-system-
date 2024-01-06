<?php

class Package
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllPackages()
    {
        $query = "SELECT * FROM packages";
        $result = $this->db->getConnection()->query($query);

        return ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function addPackage($name, $description, $price, $duration)
    {
        $mysqli = $this->db->getConnection();
        $stmt = $mysqli->prepare("INSERT INTO packages (name, description, price, duration) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $name, $description, $price, $duration);
        $stmt->execute();
        $stmt->close();
    }

    public function updatePackage($package_id, $name, $description, $price, $duration)
    {
        $mysqli = $this->db->getConnection();

        // Update the package
        $stmt = $mysqli->prepare("UPDATE packages SET name = ?, description = ?, price = ?, duration = ? WHERE package_id = ?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $duration, $package_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Package updated successfully
            return true;
        } else {
            // Package not found or no changes made
            return "Failed to update package. Package not found or no changes made.";
        }

        $stmt->close();
    }

    public function getPackageDetails($package_id)
    {
        $mysqli = $this->db->getConnection();

        // Fetch package details
        $stmt = $mysqli->prepare("SELECT * FROM packages WHERE package_id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }
    public function deletePackage($package_id)
    {
        // Check if the package is associated with any members
        if ($this->isPackageAssociatedWithMembers($package_id)) {
            return "Cannot delete package. It is associated with one or more members.";
        }
    
        // If not associated with any members, proceed with deletion
        $mysqli = $this->db->getConnection();
    
        // Delete the package from the packages table
        $stmt = $mysqli->prepare("DELETE FROM packages WHERE package_id = ?");
        $stmt->bind_param("i", $package_id);
    
        // Execute the delete
        $stmt->execute();
    
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            // Return a success message
            return true;
        } else {
            // Return a message indicating that the package was not found
            return "Cannot delete package. It may be associated with other records.";
        }
    }
    
    private function isPackageAssociatedWithMembers($package_id)
    {
        $mysqli = $this->db->getConnection();
    
        // Check if the package is associated with any members
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM members WHERE package_id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $stmt->bind_result($memberCount);
        $stmt->fetch();
    
        return $memberCount > 0;
    }
    


}
?>
