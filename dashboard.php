<?php
session_start();

// Check if the user is authenticated
// if (!isset($_SESSION['access_token'])) {
//     // User is not authenticated, redirect to the login page
//     header('Location: index.php');
//     exit;
// }

// Retrieve the authorization code from the query parameters
$code = $_GET['code'];

// Retrieve the username and email from the session
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$avatarUrl = $_SESSION['avatar_url'];
// Clear the session access token (optional)
unset($_SESSION['access_token']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Dahboard</title>
    <head>
      <meta charset="utf-8">
      <title>SSO</title>
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

      <link rel="stylesheet" href="css/style.css?verssion=1">
  </head>
  <body>
    <div class="container">
      <div class="userdetails">
        <div class="card">
          <div class="card-title">
            <h3>Welcome</h3>
          </div>
          <img src="<?php echo $avatarUrl ?>" alt="">
          <div class="card-body">
            <ul class="text-decoration-none">
              <li><p>Authorization code: <?php echo $code; ?></p></li>
              <li><p>Username: <?php echo $username; ?></p></li>
              <li><p>Email: <?php echo $email; ?></p></li>
            </ul>
            <a href="index.php" class="fa fa-sign-out text-">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
