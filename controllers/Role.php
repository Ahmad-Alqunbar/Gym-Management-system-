<?php
class Role
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addRole($name, $description, $permissions)
    {
        $mysqli = $this->db->getConnection();

        // Use prepared statements to prevent SQL injection
        $stmt = $mysqli->prepare("INSERT INTO roles (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        // Execute the statement
        $stmt->execute();

        // Get the ID of the inserted role
        $role_id = $mysqli->insert_id;

        // Close the statement
        $stmt->close();

        // Save the permissions to the role_permissions table
        foreach ($permissions as $permission_id) {
            $stmt = $mysqli->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $role_id, $permission_id);
            $stmt->execute();
            $stmt->close();
        }
    }

    public function getRolesWithPermissions()
    {
        $mysqli = $this->db->getConnection();
        $result = $mysqli->query("SELECT roles.role_id, roles.name, roles.description, 
                                GROUP_CONCAT(permissions.name SEPARATOR ', ') as permissions
                                FROM roles
                                LEFT JOIN role_permissions ON roles.role_id = role_permissions.role_id
                                LEFT JOIN permissions ON role_permissions.permission_id = permissions.permission_id
                                GROUP BY roles.role_id");

        // Fetch roles with associated permissions from the result set
        $rolesWithPermissions = [];
        while ($row = $result->fetch_assoc()) {
            $row['permissions'] = explode(', ', $row['permissions']);
            $rolesWithPermissions[] = $row;
        }

        return $rolesWithPermissions;
    }

    public function getTotalRoles()
    {
        $mysqli = $this->db->getConnection();
        $result = $mysqli->query("SELECT COUNT(*) as totalRoles FROM roles");
        $row = $result->fetch_assoc();
        return $row['totalRoles'];
    }

    public function getTotalPages($perPage)
    {
        $totalRoles = $this->getTotalRoles(); // Implement this method in your Role class
        return ceil($totalRoles / $perPage);
    }
    public function getRolesWithPermissionsPaginated($page, $perPage)
    {
        $mysqli = $this->db->getConnection();

        // Calculate the offset for the SQL LIMIT clause
        $offset = ($page - 1) * $perPage;

        // Fetch roles with associated permissions for the current page
        $result = $mysqli->query("SELECT roles.role_id, roles.name, roles.description, 
                                GROUP_CONCAT(permissions.name SEPARATOR ', ') as permissions
                                FROM roles
                                LEFT JOIN role_permissions ON roles.role_id = role_permissions.role_id
                                LEFT JOIN permissions ON role_permissions.permission_id = permissions.permission_id
                                GROUP BY roles.role_id
                                LIMIT $offset, $perPage");

        // Fetch roles with associated permissions from the result set
        $rolesWithPermissions = [];
        while ($row = $result->fetch_assoc()) {
            $row['permissions'] = explode(', ', $row['permissions']);
            $rolesWithPermissions[] = $row;
        }

        return $rolesWithPermissions;
    }

    public function editRole($role_id, $name, $description, $permissions)
    {
        $mysqli = $this->db->getConnection();

        // Update the role information
        $stmt = $mysqli->prepare("UPDATE roles SET name = ?, description = ? WHERE role_id = ?");
        $stmt->bind_param("ssi", $name, $description, $role_id);
        $stmt->execute();
        $stmt->close();

        // Delete existing role permissions
        $stmt = $mysqli->prepare("DELETE FROM role_permissions WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $stmt->close();

        // Save the updated permissions to the role_permissions table
        foreach ($permissions as $permission_id) {
            $stmt = $mysqli->prepare("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $role_id, $permission_id);
            $stmt->execute();
            $stmt->close();
        }
       
    }

    public function getRoleDetails($role_id)
    {
        $mysqli = $this->db->getConnection();

        // Use prepared statement to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT * FROM roles WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $roleDetails = $result->fetch_assoc();

        // Close the statement
        $stmt->close();

        // Retrieve permissions associated with the role
        $roleDetails['permissions'] = $this->getRolePermissions($role_id);

        return $roleDetails;
    }

    private function getRolePermissions($role_id)
    {
        $mysqli = $this->db->getConnection();

        // Use prepared statement to prevent SQL injection
        $stmt = $mysqli->prepare("SELECT permission_id FROM role_permissions WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();
        $permissions = [];

        while ($row = $result->fetch_assoc()) {
            $permissions[] = $row['permission_id'];
        }

        // Close the statement
        $stmt->close();

        return $permissions;
    }
    public function deleteRole($role_id)
    {
        $mysqli = $this->db->getConnection();
    
        // Check if the role is associated with any users
        if ($this->isRoleInUse($role_id)) {
            // Role is associated with users, return a message
            return "false";
        }
    
        // Delete related records in role_permissions table
        $stmt = $mysqli->prepare("DELETE FROM role_permissions WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $stmt->close();
    
        // Now, delete the role
        $stmt = $mysqli->prepare("DELETE FROM roles WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
        $stmt->close();
    
        // Return a success message
        return "true";
    }
    
    // Check if the role is associated with any users
    private function isRoleInUse($role_id)
    {
        $mysqli = $this->db->getConnection();
        $stmt = $mysqli->prepare("SELECT COUNT(*) FROM users WHERE role_id = ?");
        $stmt->bind_param("i", $role_id);
        $stmt->execute();
    
        // Fetch the count of associated users
        $stmt->bind_result($count);
        $stmt->fetch();
    
        // If count is greater than 0, role is in use
        return $count > 0;
    }
    
    
}
