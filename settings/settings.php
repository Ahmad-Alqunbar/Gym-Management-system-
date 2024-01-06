<?php
include_once '../layouts/header.php';
include_once '../config/Database.php';
include_once '../controllers/Setting.php';

$db = new Database();
$settingsController = new Setting($db);

// Initialize user ID (replace this with your authentication logic)
$user_id = $_SESSION['user_id'];
$successMessage = '';
// var_dump($user_id);
//     exit();
// Handle Settings Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $settings = [
        'header_color' => $_POST['header_color'],
        'header_text_color' => $_POST['header_text_color'],
        'button_color' => $_POST['button_color'],
        'button_text_color' => $_POST['button_text_color'],
        'content_color' => $_POST['content_color'],
        'content_text_color' => $_POST['content_text_color'],
        'sidebar_color' => $_POST['sidebar_color'],
        'sidebar_text_color' => $_POST['sidebar_text_color'],
    ];

    // Call saveSettings with the user_id and the associative array of settings
    $settingsController->saveSettings($user_id, $settings);


    $successMessage = 'Settings Updated successfully';
}

// Handle Reset Settings
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_settings'])) {
    $settingsController->resetSettings($user_id);

    $successMessage = 'Settings Reset to Default';
}

// Retrieve current settings
$currentSettings = $settingsController->getSettings($user_id);
?>

<!-- Main content -->
<main class="container-fluid">
    <div class="container mt-5">
        <?php if (!empty($successMessage)) : ?>

            <div class="alert alert-success" role="alert">
                <?= $successMessage ?>

                <script>
                    window.open('settings.php', '_self')
                </script>;

            </div>


        <?php endif;

        ?>
        <div class="card border-dark mb-3">
            <div class="card-header">
                <h2>Update Settings</h2>
            </div>
            <div class="card-body text-dark">
                <form action="settings.php" method="post">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_color">Header Color</label>
                                <input type="color" class="form-control" id="header_color" name="header_color" value="<?= $currentSettings['header_color'] ?? '' ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="header_text_color">Header Text Color</label>
                                <input type="color" class="form-control" id="header_text_color" name="header_text_color" value="<?= $currentSettings['header_text_color'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="button_color">Button Color</label>
                                <input type="color" class="form-control" id="button_color" name="button_color" value="<?= $currentSettings['button_color'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="button_text_color">Button Text Color</label>
                                <input type="color" class="form-control" id="button_text_color" name="button_text_color" value="<?= $currentSettings['button_text_color'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_color">Content Color</label>
                                <input type="color" class="form-control" id="content_color" name="content_color" value="<?= $currentSettings['content_color'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="content_text_color">Content Text Color</label>
                                <input type="color" class="form-control" id="content_text_color" name="content_text_color" value="<?= $currentSettings['content_text_color'] ?? '' ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sidebar_color">Sidebar Color</label>
                                <input type="color" class="form-control" id="sidebar_color" name="sidebar_color" value="<?= $currentSettings['sidebar_color'] ?? '' ?>" required>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sidebar_text_color">Sidebar Text Color</label>
                                <input type="color" class="form-control" id="sidebar_text_color" name="sidebar_text_color" value="<?= $currentSettings['sidebar_text_color'] ?? '' ?>" required>
                            </div>
                        </div>

                    </div>

                    <button class="btn btn_setting w-100" type="submit" name="update_settings">Update Settings</button>
                </form>
                <!-- Reset Settings Form -->


                <form action="settings.php" method="post" class='mt-3'>
                    <button class="btn btn-warning w-100" type="submit" name="reset_settings">Reset to Default</button>
                </form>

            </div>
        </div>
    </div>
</main>

<?php include_once '../layouts/footer.php'; ?>