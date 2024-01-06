<?php
include '../layouts/header.php';

// Handle membership management actions (renewals, upgrades, etc.)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submissions for membership management actions
    // You can add the necessary logic based on your requirements
    // For example, update the membership in the database
    $membershipId = $_POST['membership_id'];
    $newEndDate = $_POST['new_end_date'];

    $pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
    $stmt = $pdo->prepare("UPDATE membership SET end_date = :new_end_date WHERE membership_id = :membership_id");
    $stmt->bindParam(':new_end_date', $newEndDate);
    $stmt->bindParam(':membership_id', $membershipId);

    if ($stmt->execute()) {
        // Successful update, you can redirect or display a success message
        header("Location: memberships.php");
        exit();
    } else {
        echo "<p>Error updating membership.</p>";
    }
}

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $membershipId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM membership WHERE membership_id = :id");
    $stmt->bindParam(':id', $membershipId);
    $stmt->execute();
    $membership = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$membership) {
        echo "<div class='container mt-5'><p>Membership not found.</p></div>";
        include '../layouts/footer.php';
        exit();
    }
} else {
    echo "<div class='container mt-5'><p>Invalid membership ID.</p></div>";
    include '../layouts/footer.php';
    exit();
}
?>

<div class="container mt-5">
    <h2>Manage Membership</h2>
    <form method="post">
        <input type="hidden" name="membership_id" value="<?php echo $membership['membership_id']; ?>">
        
        <div class="form-group">
            <label for="new_end_date">New End Date:</label>
            <input type="date" class="form-control" id="new_end_date" name="new_end_date" required>
        </div>

        <button type="submit" class="btn btn_setting">Update Membership</button>
    </form>
</div>

<?php include '../layouts/footer.php'; ?>
