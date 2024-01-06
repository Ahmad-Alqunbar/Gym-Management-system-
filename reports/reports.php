<?php
include '../layouts/header.php';

$pdo = new PDO("mysql:host=localhost;dbname=gym_sys", "root", "12344321");
?>

<div class="container mt-5">
    <h2>Reports</h2>

    <!-- Financial Report -->
    <div class="mt-4">
        <h4>Financial Report</h4>

        <!-- Example: Total Income -->
        <?php

$incomeStmt = $pdo->query("SELECT SUM(amount) AS total_income FROM gym_sys.payments WHERE payment_status = 'Paid'");

        $totalIncome = $incomeStmt->fetch(PDO::FETCH_ASSOC)['total_income'];

        echo "<p>Total Income: $" . number_format($totalIncome, 2) . "</p>";
        ?>
        
        <!-- Example: Total Expenses -->
        <?php
        $expenseStmt = $pdo->query("SELECT SUM(amount) AS total_expenses FROM expenses");
        $totalExpenses = $expenseStmt->fetch(PDO::FETCH_ASSOC)['total_expenses'];

        echo "<p>Total Expenses: $" . number_format($totalExpenses, 2) . "</p>";
        ?>

        <!-- Example: Net Income -->
        <?php
        $netIncome = $totalIncome - $totalExpenses;
        echo "<p>Net Income: $" . number_format($netIncome, 2) . "</p>";
        ?>
    </div>

    <!-- Membership Report -->
    <div class="mt-4">
        <h4>Membership Report</h4>

        <!-- Example: Total Members -->
        <?php
        $totalMembersStmt = $pdo->query("SELECT COUNT(*) AS total_members FROM members");
        $totalMembers = $totalMembersStmt->fetch(PDO::FETCH_ASSOC)['total_members'];

        echo "<p>Total Members: " . $totalMembers . "</p>";
        ?>

        <!-- Example: Membership Renewals -->
        <?php
        $renewalsStmt = $pdo->query("SELECT COUNT(*) AS total_renewals FROM membership WHERE end_date >= CURDATE()");
        $totalRenewals = $renewalsStmt->fetch(PDO::FETCH_ASSOC)['total_renewals'];

        echo "<p>Membership Renewals: " . $totalRenewals . "</p>";
        ?>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>
