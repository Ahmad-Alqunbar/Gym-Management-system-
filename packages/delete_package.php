<?php
// Include necessary files (config, Database, etc.)
include_once '../config/Database.php';
include_once '../controllers/Package.php';

// Create a new Database instance
$db = new Database();

// Create a new Package instance
$package = new Package($db);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package_id'])) {
    $package_id = $_POST['package_id'];

    // Attempt to delete the package
    $deleteMessage = $package->deletePackage($package_id);

    // Check if the deletion was successful
    if ($deleteMessage === true) {
        // Redirect back to packages_list.php with a success message
        $encodedMessage = urlencode('Package deleted successfully.');
        header("Location: packages_list.php?delete_success=$encodedMessage");
        exit;
    } else {
        // Redirect back to packages_list.php with an error message
        $encodedMessage = urlencode($deleteMessage);
        header("Location: packages_list.php?delete_error=$encodedMessage");
        exit;
    }
} else {
    // Redirect to the packages_list.php if accessed without proper parameters
    header("Location: packages_list.php");
    exit;
}
