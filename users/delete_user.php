<?php
include_once '../config/Database.php';
include_once '../controllers/User.php';

$db = new Database();
$user = new User($db);

// Get user_id from the form submission
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;

// Delete the user
$deleteMessage = $user->deleteUser($user_id);
// echo $deleteMessage;
// exit();
// Check if the deletion was successful
if ($deleteMessage =="true") {
    // Redirect back to user_list.php with a success message
    $encodedMessage = urlencode('User deleted successfully.');
    header("Location: user_list.php?delete_success=$encodedMessage");
    exit;
} else {
    // Redirect back to user_list.php with an error message
    $encodedMessage = urlencode($deleteMessage);
    header("Location: user_list.php?delete_error=$encodedMessage");
    exit;
}
?>
