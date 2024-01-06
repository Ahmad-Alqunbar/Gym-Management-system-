<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if (isset($_GET['id'])) {
    $workoutId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT workouts.*, members.name AS member_name, trainers.name AS trainer_name FROM workouts
                            INNER JOIN members ON workouts.member_id = members.member_id
                            INNER JOIN trainers ON workouts.trainer_id = trainers.trainer_id
                            WHERE workout_id = :id");
    $stmt->bindParam(':id', $workoutId);
    $stmt->execute();
    $workout = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($workout) {
        // Display workout details
        echo "<div class='container mt-5'>";
        echo "<h2>Workout Details</h2>";
        echo "<p><strong>Date:</strong> {$workout['workout_date']}</p>";
        echo "<p><strong>Member:</strong> {$workout['member_name']}</p>";
        echo "<p><strong>Trainer:</strong> {$workout['trainer_name']}</p>";
        echo "<p><strong>Duration:</strong> {$workout['duration']}</p>";
        echo "<p><strong>Notes:</strong> {$workout['notes']}</p>";
        echo "</div>";
    } else {
        echo "<div class='container mt-5'><p>Workout not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid workout ID.</p></div>";
}

include '../layouts/footer.php';
?>
