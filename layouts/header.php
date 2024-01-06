<?php
session_start();
require_once '../config/Database.php';
require_once '../controllers/User.php';
include_once '../controllers/Setting.php';

$db = new Database();
$settingsController = new Setting($db);
$user_id = $_SESSION['user_id'];
// Retrieve current settings
$currentSettings = $settingsController->getSettings($user_id);

// var_dump($currentSettings);
// exit();

// Check if the user is logged in to show/hide the logout button
$isLoggedIn = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
$db = new Database();
$user = new User($db);
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    // User is not logged in, redirect to the login page
    header('Location: ../index.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym System ONE</title>
    <!-- Bootstrap 5 CSS CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="    https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow&display=swap');
        :root {
            --header-color: <?php echo $currentSettings['header_color']; ?>;
            --header-text-color: <?php echo $currentSettings['header_text_color']; ?>;

            --button-color: <?php echo $currentSettings['button_color']; ?>;
            --button-text-color: <?php echo $currentSettings['button_text_color']; ?>;

            --content-color: <?php echo $currentSettings['content_color']; ?>;
            --content-text-color: <?php echo $currentSettings['content_text_color']; ?>;

            --sidebar-color: <?php echo $currentSettings['sidebar_color']; ?>;
            --sidebar-text-color: <?php echo $currentSettings['sidebar_text_color']; ?>;
            
            /* Add other variables for your settings */
        }
        .sidebar_item{
          background-color: var(--sidebar-color); color: var(--sidebar-text-color);
        }
        .btn_setting{
          background-color: var(--button-color);
          color: var(--button-text-color);
        }
        body {
            font-family: 'Barlow', sans-serif;
           background-color: var(--content-color);
           
        }

        a:hover {
            text-decoration: none;
        }

        .border-left {
            border-left: 3px solid skyblue !important;
        }

        .sidebar {
            top: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
        }


        .overlay {
            background-color: rgb(0 0 0 / 45%);
            z-index: 99;
        }

        /* sidebar for small screens */
        @media screen and (max-width: 767px) {

            .sidebar {
                max-width: 18rem;
                transform: translateX(-100%);
                transition: transform 0.4s ease-out;
            }

            .sidebar.active {
                transform: translateX(0);
            }

        }
    </style>
    
</head>

<body>
    <div class="container-fluid">
        <div class="row">
          <!-- sidebar -->
          <div class="col-md-3 col-lg-2 px-0 position-fixed h-100 bg-white shadow-sm sidebar" id="sidebar">
            <div class="list-group rounded-0" >
            <a href="../dashboard/index.php" class="list-group-item list-group-item-action border-0 d-flex align-items-center" style="background-color: var(--header-color); color: var(--header-text-color);">
                <span class="bi bi-border-all"></span>
                <span class="ml-2">Dashboard</span>
              </a>
              <button class=" sidebar_item list-group-item  list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#users">
                <div>
                  <span class="bi bi-people-fill"></span>
                  <span class="ml-2">Users</span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="users" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../users/user_list.php" class="list-group-item list-group-item-action border-0 pl-5">User List</a>
                  <a href="../users/add_user.php" class="list-group-item list-group-item-action border-0 pl-5">Add User</a>
                </div>
              </div>

              <button class=" sidebar_item list-group-item  list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#sale-collapse">
                <div>
                  <span class="bi bi-people-fill"></span>
                  <span class="ml-2">Members</span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="sale-collapse" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../members/members_list.php" class="list-group-item list-group-item-action border-0 pl-5">Members List</a>
                  <a href="../members/add_member.php" class="list-group-item list-group-item-action border-0 pl-5">Register Member</a>
                </div>
              </div>

              <button class=" sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#role">
                <div>
                  <span class="bi bi-ui-checks-grid"></span>
                  <span class="ml-2">Roles </span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="role" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../role/role_list.php" class="list-group-item list-group-item-action border-0 pl-5">Roles List</a>
                  <a href="../role/add_role.php" class="list-group-item list-group-item-action border-0 pl-5">Add Role</a>

                </div>
              </div>


              <button class=" sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#permission">
                <div>
                  <span class="bi bi-octagon-fill"></span>
                  <span class="ml-2">Permission </span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="permission" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../permission/permission_list.php" class="list-group-item list-group-item-action border-0 pl-5">Permission List</a>
                  <a href="../permission/add_permission.php" class="list-group-item list-group-item-action border-0 pl-5">Add Permission</a>

                </div>
              </div>

              <button class=" sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#traniers">
                <div>
                  
                  <span class="bi bi-person"></span>
                  <span class="ml-2">Trainers</span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="traniers" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../trainers/trainers_list.php" class="list-group-item list-group-item-action border-0 pl-5">Trainers List</a>
                  <a href="../trainers/add_trainer.php" class="list-group-item list-group-item-action border-0 pl-5">Register Trainers</a>
                </div>
              </div>
              <button class=" sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#packages">
                <div>
                  <span class="bi bi-pentagon"></span>
                  <span class="ml-2">packages</span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="packages" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../packages/packages_list.php" class="list-group-item list-group-item-action border-0 pl-5">packages List</a>
                  <a href="../packages/add_package.php" class="list-group-item list-group-item-action border-0 pl-5">Add Package</a>
                </div>
              </div>
             
        
           
            

              <button class="sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#reports">
                <div>
                  <span class="bi bi-folder-symlink"></span>
                  <span class="ml-2">Reports  </span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="reports" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../reports/reports.php" class="list-group-item list-group-item-action border-0 pl-5">Reports</a>

                </div>
              </div>

              <button class="sidebar_item list-group-item list-group-item-action border-0 d-flex justify-content-between align-items-center" data-toggle="collapse" data-target="#settings">
                <div>
                  <span class="bi bi-gear-wide-connected"></span>
                  <span class="ml-2">Settings  </span>
                </div>
                <span class="bi bi-chevron-down small"></span>
              </button>
              <div class="collapse" id="settings" data-parent="#sidebar">
                <div class="list-group">
                  <a href="../settings/settings.php" class="list-group-item list-group-item-action border-0 pl-5">settings</a>

                </div>
              </div>
            </div>
          </div>
          <div class="w-100 vh-100 position-fixed overlay d-none" id="sidebar-overlay"></div>
          <div class="col-md-9 col-lg-10 ml-md-auto px-0" >
        
          <nav class="w-100 d-flex px-4 mb-4 shadow" style="padding-bottom: 8px;background-color: var(--header-color); color: var(--header-text-color);">

                <button class="btn py-0 d-lg-none" id="open-sidebar">
                    <span class="bi bi-list text-info h3"></span>
                </button>

                <?php if ($isLoggedIn): ?>
                    <div class="ml-auto">
                        <form method="post" action="../logout.php">
                            <button class="btn btn_setting btn-sm mt-2" type="submit">Logout</button>
                        </form>
                    </div>
                <?php endif; ?>
                </nav>