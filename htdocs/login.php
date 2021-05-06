<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();

if ($_SERVER[REQUEST_METHOD] === GET) {
    $error = isset($_GET[ERROR]) ? $_GET[ERROR] : NULL;
    $location = isset($_GET[LOCATION]) ? trim($_GET[LOCATION]) : '/index.php';
    include '../views/login_view.php';
} elseif ($_SERVER[REQUEST_METHOD] === POST) {
    $username = isset($_POST[USERNAME]) ? trim($_POST[USERNAME]) : NULL;
    $password = isset($_POST[PASSWORD]) ? $_POST[PASSWORD] : NULL;
    $location = isset($_POST[LOCATION]) ? trim($_POST[LOCATION]) : '/index.php';

    if (empty($username) || empty($password)) {
        $error = 'Both username and password must be provided.';
        header('Location: /login.php?error=' . urlencode($error) . '&location=' . urlencode($location));
        exit;
    }

    $dbc = get_database_connection();
    $user = get_user($dbc, $username);
    close_database_connection($dbc);

    $logged_in = $user ? password_verify($password, $user[PASSWORD]) : FALSE;
    if ($logged_in) {
        $_SESSION[USER_ID] = $user[ID];
        $_SESSION[USERNAME] = htmlspecialchars($username);
    } else {
        $error = INVALID_CREDENTIALS;
    }

    if (isset($_POST[FORMAT]) && $_POST[FORMAT] === 'json') {
        if ($logged_in) {
            $res = [STATUS => SUCCESS];
        } else {
            $res = [STATUS => FAILURE, ERROR => $error];
        }
        include '../views/login_view_result_json.php';
    } else {
        if ($logged_in) {
            header("Location: $location");
        } else {
            header('Location: /login.php?error=' . urlencode($error) . '&location=' . urlencode($location));
        }
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}
