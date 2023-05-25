<?php
session_start();

// Include the GitHub OAuth library
require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Github;

// Configuration settings
$config = [
    'github' => [
        'clientId'     => '9ff977384313490414d7',
        'clientSecret' => '923ec3ffad14dfb5fee4aa4de635d40daeabf96a',
        'redirectUri'  => 'http://localhost/ssoPHP/callback.php',
    ],
];

$provider = new Github($config['github']);

// Check if the user is already authenticated
if (isset($_SESSION['access_token'])) {
    // User is authenticated, redirect to protected page
    header('Location: dashborad.php');
    exit;
}

// Check if the user clicked the login button
if (isset($_GET['login'])) {
    // Generate the authorization URL with a unique state parameter
    $authorizationUrl = $provider->getAuthorizationUrl([
      'scope' => ['user', 'user:email'], // Add 'user:email' to the scope
          'state' => bin2hex(random_bytes(16)) // Generate a random state value
    ]);

    // Store the state in the session for security validation
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect to GitHub login page
    header("Location: {$authorizationUrl}");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
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
    <div class="container-fluid">
      <div class="login">
        <div class="card d-flex justify-content-center">
          <div class="card-title">
            <h3>Welcome to SSO App</h3>
          </div>
          <div class="card-body d-flex justify-content-center">

              <a href="?login" class="btn btn-success">Login With
                <i class="fa fa-github fa-3x" style="padding:5px"></i>
              </a>

          </div>
          <div class="card-footer">
            <a href="?login">Do not have acount?</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
