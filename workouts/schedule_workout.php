<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle form submission to schedule new workout
    $memberId = $_POST['member_id'];
    $trainerId = $_POST['trainer_id'];
    $workoutDate = $_POST['workout_date'];
    $duration = $_POST['duration'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("INSERT INTO workouts (member_id, trainer_id, workout_date, duration, notes)
                          VALUES (:memberId, :trainerId, :workoutDate, :duration, :notes)");
    $stmt->bindParam(':memberId', $memberId);
    $stmt->bindParam(':trainerId', $trainerId);
    $stmt->bindParam(':workoutDate', $workoutDate);
    $stmt->bindParam(':duration', $duration);
    $stmt->bindParam(':notes', $notes);

    if ($stmt->execute()) {
        echo "<div class='container mt-5'><p>New workout scheduled successfully.</p></div>";
    } else {
        echo "<div class='container mt-5'><p>Error scheduling new workout.</p></div>";
    }
}

// Fetch members and trainers for dropdowns
$members = $pdo->query("SELECT * FROM members")->fetchAll(PDO::FETCH_ASSOC);
$trainers = $pdo->query("SELECT * FROM trainers")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<div class="card border-dark mb-3">

<div class="card-header">
<h2>Schedule New Workout</h2>
</div>
<div class="card-body text-dark">
    <form method="post">
        <div class="form-group">
            <label for="member_id">Select Member:</label>
            <select name="member_id" class="form-control" required>
                <?php
                foreach ($members as $member) {
                    echo "<option value='{$member['member_id']}'>{$member['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="trainer_id">Select Trainer:</label>
            <select name="trainer_id" class="form-control" required>
                <?php
                foreach ($trainers as $trainer) {
                    echo "<option value='{$trainer['trainer_id']}'>{$trainer['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="workout_date">Workout Date:</label>
            <input type="date" name="workout_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="time" name="duration" class="form-control" required>
        </div>
        <div class="form-group">
        <label for="notes">Notes:</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn_setting">Schedule Workout</button>
    </form>
</div>
</div>
</div>
<?php include '../layouts/footer.php'; ?>