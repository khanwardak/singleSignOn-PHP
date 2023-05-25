<?php
session_start();

require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Github;

$config = [
    'github' => [
        'clientId' => 'b6d7aeefdbf0ebebdd25',
        'clientSecret' => '57d7f6d652942dbdab22cb3591397d3b7c7621b2',
        'redirectUri' => 'http://localhost/sso-php/callback.php',
    ],
];

$provider = new Github($config['github']);

// Check if the user denied the authorization request
if (isset($_GET['error']) && $_GET['error'] === 'access_denied') {
    // Authorization request was denied
    die('Authorization denied');
}

// Check if the state parameter is present
if (!isset($_GET['state']) || empty($_GET['state'])) {
    die('Invalid state');
}

// Verify the state parameter to protect against CSRF attacks
if (!isset($_SESSION['oauth2state']) || $_SESSION['oauth2state'] !== $_GET['state']) {
    die('Invalid state');
}

try {
    // Exchange the authorization code for an access token
    $accessToken = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Store the access token in the session
    $_SESSION['access_token'] = $accessToken->getToken();

    // Get the authenticated user's details
    $user = $provider->getResourceOwner($accessToken);

    // Retrieve the username and email
    $username = $user->getNickname();
    $email = $user->getEmail();
    $avatarUrl = $user->toArray()['avatar_url'];

    // Store the username and email in the session
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['avatar_url'] = $avatarUrl;

    // Redirect to the protected page along with the authorization code
    header('Location: dashboard.php?code=' . $_GET['code']);
    exit;
} catch (Exception $e) {
    // Handle error
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>
.
