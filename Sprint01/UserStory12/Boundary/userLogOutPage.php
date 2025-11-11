<?php
session_start();

// clear all session data
$_SESSION = array();

// destroys the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// finally destroy the session
session_destroy();

// redirects back to the User Admin login page
header('Location: ../UserStory11/Boundary/userLoginPage.php');
exit;
