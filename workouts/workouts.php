<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
$stmt = $pdo->query("SELECT workouts.*, members.registration_date, members.dob, 
members.gender, members.emergency_contact,
 members.membership_status, users.name AS member_name,
  trainers.hire_date, trainers.specialization,
   users_trainer.name AS trainer_name
        FROM workouts
        INNER JOIN members ON workouts.member_id = members.member_id
        INNER JOIN trainers ON workouts.trainer_id = trainers.trainer_id
        INNER JOIN users AS users_trainer ON trainers.user_id = users_trainer.user_id
        INNER JOIN users ON members.user_id = users.user_id");
?>

<div class="container mt-5">
    <h2>Scheduled Workouts</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Date</th>
            <th>Member</th>
            <th>Trainer</th>
            <th>Duration</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>{$row['workout_date']}</td>";
                echo "<td>{$row['member_name']}</td>";
                echo "<td>{$row['trainer_name']}</td>";
                echo "<td>{$row['duration']}</td>";
                echo "<td>
                        <a href='workout_details.php?id={$row['workout_id']}' class='btn btn_setting btn-sm'>Details</a>
                     </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="schedule_workout.php" class="btn btn_setting">Schedule New Workout</a>
</div>

<?php include '../layouts/footer.php'; ?>
