<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
if (!isset($_SESSION[USER_ID])) {
    header('Location: /login.php?location=' . urlencode($_SERVER[REQUEST_URI]));
    exit;
}

$user = $_SESSION[USER_ID];

if ($_SERVER[REQUEST_METHOD] === GET) {
    $id = isset($_GET[ID]) ? trim($_GET[ID]) : NULL;
    check_id($id);

    $dbc = get_database_connection();
    $func = get_func($dbc, $id, $user);
    close_database_connection($dbc);

    if (isset($_GET[FORMAT]) && $_GET[FORMAT] === JSON) {
        include '../views/show_func_view_json.php';
    } else {
        include '../views/show_func_view.php';
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}
