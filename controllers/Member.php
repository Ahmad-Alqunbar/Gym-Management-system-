<?php

class Member
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function getAllMembersWithPackages($currentPage = 1, $recordsPerPage = 10)
    {
        Member::updateStatusBasedOnEndDate();

        $mysqli = $this->db->getConnection();
        
        // Calculate the starting index for pagination
        $startIndex = ($currentPage - 1) * $recordsPerPage;
    
        // Query to fetch paginated results
        $query = "SELECT members.*, packages.name AS package_name, packages.description AS package_description, packages.price AS package_price, packages.duration AS package_duration
                  FROM members
                  INNER JOIN packages ON members.package_id = packages.package_id
                  LIMIT ?, ?";
    
        // Use a prepared statement for security
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $startIndex, $recordsPerPage);
        $stmt->execute();
    
        // Fetch the result
        $result = $stmt->get_result();
    
        // Fetch all rows
        $data = ($result) ? $result->fetch_all(MYSQLI_ASSOC) : [];
    
        // Close the statement
        $stmt->close();
    
        // Query to get the total number of records
        $countQuery = "SELECT COUNT(*) AS total_records FROM members";
        $totalCountResult = $mysqli->query($countQuery);
        $totalCount = ($totalCountResult) ? $totalCountResult->fetch_assoc()['total_records'] : 0;
    
        // Return the paginated data along with total count
        return [
            'data' => $data,
            'total_records' => $totalCount
        ];
    }
    


    public function addMember($name, $email, $phone, $gender, $age, $package_id, $status)
    {
        $date_start = date('Y-m-d');
    
        // Retrieve package details
        $package = $this->getPackageDetails($package_id);
    
        if ($package) {
            // Calculate end_date based on package duration
            $end_date = date('Y-m-d', strtotime($date_start . ' +' . $package['duration'] . ' days'));
    
            $mysqli = $this->db->getConnection();
            $stmt = $mysqli->prepare("INSERT INTO members (name, email, phone, gender, age, date_start, package_id, status, date_end) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssisiss", $name, $email, $phone, $gender, $age, $date_start, $package_id, $status, $end_date);
            $stmt->execute();
            $stmt->close();
        } else {
            // Handle the case where the package details are not found
            echo "Error: Package details not found for package_id " . $package_id;
        }
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
    
    
    public function updateMember($member_id, $name, $email, $phone, $age, $gender, $package_id, $status, $date_start)
    {
        $mysqli = $this->db->getConnection();
    
        // Convert age to integer
        $age = intval($age);
    
        // Retrieve 'duration' from 'packages' based on 'package_id'
        $package_query = $mysqli->prepare("SELECT duration FROM packages WHERE package_id = ?");
        $package_query->bind_param("i", $package_id);
        $package_query->execute();
        $package_result = $package_query->get_result();
    
        // Check if the package exists
        if ($package_result->num_rows > 0) {
            $package_data = $package_result->fetch_assoc();
            $duration = $package_data['duration'];
    
            // Calculate 'end_date' based on the new 'date_start' and 'duration'
            $end_date = date('Y-m-d', strtotime($date_start . ' +' . $duration . ' days'));
    
            // Update the member
            $stmt = $mysqli->prepare("UPDATE members SET name = ?, email = ?, phone = ?, age = ?, gender = ?, package_id = ?, status = ?, date_start = ?, date_end = ? WHERE id = ?");
            $stmt->bind_param("sssississi", $name, $email, $phone, $age, $gender, $package_id, $status, $date_start, $end_date, $member_id);
            $stmt->execute();
                
            if ($stmt->affected_rows > 0) {
                // Member updated successfully
                return true;
            } else {
                // Member not found or no changes made
                return "Failed to update member. Member not found or no changes made.";
            }
    
            $stmt->close();
        } else {
            return "Package not found.";
        }
    }
    
    
    
    // Add this function to your Member class
public function updateStatusBasedOnEndDate()
{
    $mysqli = $this->db->getConnection();

    // Get all members with active status
    $activeMembersQuery = $mysqli->query("SELECT id, date_end FROM members WHERE status = 1");
    
    while ($member = $activeMembersQuery->fetch_assoc()) {
        $memberId = $member['id'];
        $dateEnd = $member['date_end'];

        // Compare the date_end with today's date
        $today = date('Y-m-d');
        
        if ($dateEnd <= $today) {
            // If date_end is less than or equal to today, update the status to not active
            $stmt = $mysqli->prepare("UPDATE members SET status = 2 WHERE id = ?");
            $stmt->bind_param("i", $memberId);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Status updated successfully
                echo "Status updated for member ID $memberId to Not Active.";
            } else {
                // Failed to update status
                echo "Failed to update status for member ID $memberId.";
            }

            $stmt->close();
        }
    }
}
    
    
    
    public function getMemberDetails($member_id)
    {
        $mysqli = $this->db->getConnection();

        // Fetch member details
        $stmt = $mysqli->prepare("SELECT * FROM members WHERE id = ?");
        $stmt->bind_param("i", $member_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }

    public function deleteMember($member_id)
    {
        $mysqli = $this->db->getConnection();
    
        // Delete the member from the members table
        $stmt = $mysqli->prepare("DELETE FROM members WHERE id = ?");
        $stmt->bind_param("i", $member_id);
    
        // Execute the delete
        $stmt->execute();
    
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            // Return a success message
            return true;
        } else {
            // Return a message indicating that the member was not found
            return "Cannot delete member. It may be associated with other records.";
        }
    }
    
}

?>
