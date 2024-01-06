<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $memberId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM attendance WHERE member_id = :id");
    $stmt->bindParam(':id', $memberId);
    $stmt->execute();
    $attendanceHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT name FROM members WHERE member_id = :id");
    $stmt->bindParam(':id', $memberId);
    $stmt->execute();
    $memberName = $stmt->fetchColumn();

    if (!$attendanceHistory) {
        echo "<div class='container mt-5'><p>No attendance records found for {$memberName}.</p></div>";
        include '../layouts/footer.php';
        exit();
    }
} else {
    echo "<div class='container mt-5'><p>Invalid member ID.</p></div>";
    include '../layouts/footer.php';
    exit();
}
?>

<div class="container mt-5">
    <h2>Attendance History for <?php echo $memberName; ?></h2>
    <table class="table">
        <thead>
        <tr>
            <th>Check In Time</th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach ($attendanceHistory as $attendanceRecord) {
                echo "<tr>";
                echo "<td>{$attendanceRecord['check_in_time']}</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../layouts/footer.php'; ?>
