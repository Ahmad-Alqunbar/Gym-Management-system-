<?php

class Permission
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addPermission($name, $description)
    {
        $mysqli = $this->db->getConnection();
        $stmt = $mysqli->prepare("INSERT INTO permissions (name, description) VALUES (?, ?)");
        $stmt->execute([$name, $description]);
    }

    public function getAllPermissions()
    {
        $mysqli = $this->db->getConnection();
        $result = $mysqli->query("SELECT * FROM permissions");

        // Fetch all permissions from the result set
        $permissions = [];
        while ($row = $result->fetch_assoc()) {
            $permissions[] = $row;
        }

        return $permissions;
    }
    public function getAllPermissionsPagnation($page = 1, $perPage = 10)
{
    $mysqli = $this->db->getConnection();

    // Fetch total count
    $totalCountResult = $mysqli->query("SELECT COUNT(*) as count FROM permissions");
    $totalCountRow = $totalCountResult->fetch_assoc();
    $totalCount = $totalCountRow['count'];

    // Calculate offset
    $offset = ($page - 1) * $perPage;

    // Fetch paginated permissions
    $result = $mysqli->query("SELECT * FROM permissions LIMIT $offset, $perPage");

    // Fetch all permissions from the result set
    $permissions = [];
    while ($row = $result->fetch_assoc()) {
        $permissions[] = $row;
    }

    return ['permissions' => $permissions, 'totalCount' => $totalCount];
}
public function getPermissionById($id)
{
    $mysqli = $this->db->getConnection();
    $stmt = $mysqli->prepare("SELECT * FROM permissions WHERE permission_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}
public function updatePermission($id, $name, $description)
{
    $mysqli = $this->db->getConnection();
    $stmt = $mysqli->prepare("UPDATE permissions SET name = ?, description = ? WHERE permission_id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);
    
    // Execute the update
    $stmt->execute();
}
public function deletePermission($id)
{
    // Check if the permission is associated with any roles
    if ($this->isPermissionInUse($id)) {
        // Permission is associated with roles, return a message
        return "Permission is associated with roles and cannot be deleted.";
    }

    // If not associated with any roles, proceed with deletion
    $mysqli = $this->db->getConnection();
    $stmt = $mysqli->prepare("DELETE FROM permissions WHERE permission_id = ?");
    $stmt->bind_param("i", $id);

    // Execute the delete
    $stmt->execute();

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Return a success message
        return "Permission deleted successfully.";
    } else {
        // Return a message indicating that the permission was not found
        return "Cannot delete permission. It is associated with one or more roles.";
    }
}

// Check if the permission is associated with any roles
private function isPermissionInUse($id)
{
    $mysqli = $this->db->getConnection();
    $stmt = $mysqli->prepare("SELECT COUNT(*) FROM role_permissions WHERE permission_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // Fetch the count of associated roles
    $stmt->bind_result($count);
    $stmt->fetch();
    // If count is greater than 0, permission is in use
    return $count > 0;
}




}
