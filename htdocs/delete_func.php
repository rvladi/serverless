<?php
include '../utils/utils.php';
include '../utils/exception_handler.php';

session_start();
if (!isset($_SESSION[USER_ID])) {
    header('Location: /login.php?location=' . urlencode($_SERVER[REQUEST_URI]));
    exit;
}

$user = $_SESSION[USER_ID];

if ($_SERVER[REQUEST_METHOD] === POST) {
    $id = isset($_POST[ID]) ? trim($_POST[ID]) : NULL;
    check_id($id);

    $dbc = get_database_connection();
    delete_func($dbc, $id, $user);
    close_database_connection($dbc);

    delete_cls($id, $user);

    if (isset($_POST[FORMAT]) && $_POST[FORMAT] === JSON) {
        include '../views/delete_func_view_result_json.php';
    } else {
        include '../views/delete_func_view_result.php';
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}