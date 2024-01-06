<?php
include_once '../config/Database.php';
include_once '../controllers/Member.php';

$db = new Database();
$memberManager = new Member($db);

// Get member_id from the form submission
$member_id = isset($_POST['member_id']) ? (int)$_POST['member_id'] : 0;
// echo $member_id;
// exit();
// Delete the member
$deleteMessage = $memberManager->deleteMember($member_id);

// Check if the deletion was successful
if ($deleteMessage == "true") {
    // Redirect back to members.php with a success message
    $encodedMessage = urlencode('Member deleted successfully.');
    header("Location: members_list.php?delete_success=$encodedMessage");
    exit;
} else {
    // Redirect back to members.php with an error message
    $encodedMessage = urlencode($deleteMessage);
    header("Location: members_list.php?delete_error=$encodedMessage");
    exit;
}
?>
