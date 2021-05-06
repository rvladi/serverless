<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();

if ($_SERVER[REQUEST_METHOD] === GET) {
    $error = isset($_GET[ERROR]) ? $_GET[ERROR] : NULL;
    include '../views/signup_view.php';
} elseif ($_SERVER[REQUEST_METHOD] === POST) {
    $username = isset($_POST[USERNAME]) ? trim($_POST[USERNAME]) : NULL;
    $password = isset($_POST[PASSWORD]) ? $_POST[PASSWORD] : NULL;

    if (!validate_username($username)) {
        $error = 'Username must be at least ' . MIN_UNAME_LEN . ' characters long.';
        header('Location: /signup.php?error=' . urlencode($error));
        exit;
    }
    if (!validate_password($password)) {
        $error = 'Password must be at least ' . MIN_PASSW_LEN . ' characters long.';
        header('Location: /signup.php?error=' . urlencode($error));
        exit;
    }

    $dbc = get_database_connection();
    $id = create_user($dbc, $username, $password);
    close_database_connection($dbc);

    $created = $id !== NULL; // $id is NULL if username is already taken
    if ($created) {
        $_SESSION[USER_ID] = $id;
        $_SESSION[USERNAME] = htmlspecialchars($username);
        create_user_dir($id);
    } else {
        $error = "Error creating user '$username'. Please choose a different username.";
    }

    if (isset($_POST[FORMAT]) && $_POST[FORMAT] === JSON) {
        if ($created) {
            $res = [STATUS => SUCCESS];
        } else {
            $res = [STATUS => FAILURE, ERROR => $error];
        }
        include '../views/signup_view_result_json.php';
    } else {
        if ($created) {
            include '../views/signup_view_result.php';
        } else {
            header('Location: /signup.php?error=' . urlencode($error));
        }
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}
