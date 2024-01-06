<?php
include_once '../config/Database.php';
include_once '../controllers/Permission.php';

$db = new Database();
$permission = new Permission($db);

// Get permission_id from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['permission_id'])) {
    $permission_id = (int)$_POST['permission_id'];
    $deleteMessage = $permission->deletePermission($permission_id);

    // Check if the deletion was successful
    if (strpos($deleteMessage, 'successfully') !== false) {
        // Redirect back to permission_list.php with a success message
        $encodedMessage = urlencode($deleteMessage);
        header("Location: permission_list.php?delete_success=$encodedMessage");
        exit;
    } else {
        // Redirect back to permission_list.php with an error message
        $encodedMessage = urlencode($deleteMessage);
        header("Location: permission_list.php?delete_error=$encodedMessage");
        exit;
    }
}
?>
