<?php
session_start();
require_once 'config/Database.php';
require_once 'controllers/User.php';

$db = new Database();
$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
  // Example usage in your login logic
$loginResult = $user->login($email, $password);

if ($loginResult['success']) {
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = $loginResult['user_id'];
    header('Location: dashboard/index.php');
    exit();
} else {
    $loginError = $loginResult['message'];
}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=,initial-scale=1.0">
    <title>Fitness</title>
    <link rel="stylesheet" href="login/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">   
</head>

<body>
    <div class="container mt-5">
        <div class="row m-5 no-gutters shadow-lg">
            <div class="col-md-6 d-none d-md-block">
                <img src="login/logo-white.png" class="img-fluid" style="min-height:100%;"/>
            </div>
            <div class="col-md-6 bg-orange p-5">
            <h3 class="pb-3 mt-2">System Login</h3>  
                <div class="form-style">
                    <form action="index.php" method="post">
                            <div class="form-group pb-3">
                                <input type="email" name="email" placeholder="Email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group pb-3">
                                <input type="password" name="password" placeholder="Password" class="form-control" id="exampleInputPassword1">
                            </div>
                            <div class="pb-2">
                                <button type="submit" class="btn btn-dark w-100 font-weight-bold mt-2">Login</button>
                            </div>
                    </form>
            
                </div>

            </div>
        </div>
        <?php if (isset($loginError)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $loginError; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://use.fontawesome.com/f59bcd8580.js"></script>