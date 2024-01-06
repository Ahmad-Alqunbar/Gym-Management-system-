<?php
include '../layouts/header.php';

// Handle form submission to record attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form submissions for recording attendance
    // You can add the necessary logic based on your requirements
    // For example, insert the attendance record into the database
    $memberId = $_POST['member_id'];
    $checkInTime = date("Y-m-d H:i:s"); // Record the current date and time

    $pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
    $stmt = $pdo->prepare("INSERT INTO attendance (member_id, check_in_time) VALUES (:member_id, :check_in_time)");
    $stmt->bindParam(':member_id', $memberId);
    $stmt->bindParam(':check_in_time', $checkInTime);

    if ($stmt->execute()) {
        // Successful record, you can redirect or display a success message
        header("Location: attendance_tracking.php");
        exit();
    } else {
        echo "<p>Error recording attendance.</p>";
    }
}

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT * FROM members");

?>

<div class="container mt-5">
<div class="card border-dark mb-3">

<div class="card-header">
<h2>Attendance Tracking</h2>
</div>
<div class="card-body text-dark">
    <form method="post">
        <div class="form-group">
            <label for="member_id">Select Member:</label>
            <select class="form-control" id="member_id" name="member_id" required>
                <?php
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['member_id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class=" btn btn_setting">Record Attendance</button>
    </form>
</div>
</div>
</div>
<?php include '../layouts/footer.php'; ?>
