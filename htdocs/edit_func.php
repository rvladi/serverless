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
        include '../views/edit_func_view_json.php';
    } else {
        include '../views/edit_func_view.php';
    }
} elseif ($_SERVER[REQUEST_METHOD] === POST) {
    $id = isset($_POST[ID]) ? trim($_POST[ID]) : NULL;
    check_id($id);

    $name = isset($_POST[NAME]) ? trim($_POST[NAME]) : NULL;
    check_non_empty($name);

    $description = isset($_POST[DESCRIPTION]) ? trim($_POST[DESCRIPTION]) : NULL;
    check_non_empty($description);

    $body = isset($_POST[BODY]) ? trim($_POST[BODY]) : NULL;
    check_non_empty($body);

    $dbc = get_database_connection();
    begin_transaction($dbc);
    edit_func($dbc, $id, $name, $description, $body, $user);
    $func = get_func($dbc, $id, $user);
    commit_transaction($dbc);
    close_database_connection($dbc);

    compile_cls($body, $id, $user);

    if (isset($_POST[FORMAT]) && $_POST[FORMAT] === JSON) {
        include '../views/edit_func_view_result_json.php';
    } else {
        include '../views/edit_func_view_result.php';
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}
