<?php
include_once '../config/Database.php';
include_once '../controllers/Role.php';
$db = new Database();

$role = new Role($db);
// Get role_id from the form submission
$role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;
// Delete the role
$role->deleteRole($role_id);
$delete =$role->deleteRole($role_id);

// echo($delete);
// exit();
if($delete=="false")
{
    $encodedMessage = urlencode('Role is associated with Users and cannot be deleted.');
    header("Location: role_list.php?delete_error=$encodedMessage");
    exit;  

}else{
  // Redirect back to role_list.php with a success message
$encodedMessage = urlencode('Role deleted successfully.');
header("Location: role_list.php?delete_success=$encodedMessage");
exit;
}

?>