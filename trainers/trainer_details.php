<?php
include '../layouts/header.php';

// Example PHP code to fetch and display trainer details from the database
$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "username", "password");
$trainerId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM trainers INNER JOIN users ON trainers.user_id = users.user_id WHERE trainers.trainer_id = ?");
$stmt->execute([$trainerId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
    <h2>Trainer Details</h2>
    <ul class="list-group">
        <li class="list-group-item">Name: <?php echo $row['name']; ?></li>
        <li class="list-group-item">Email: <?php echo $row['email']; ?></li>
        <li class="list-group-item">Hire Date: <?php echo $row['hire_date']; ?></li>
        <li class="list-group-item">Specialization: <?php echo $row['specialization']; ?></li>
        <!-- Add more details as needed -->
    </ul>
</div>

<?php include '../layouts/footer.php'; ?>
