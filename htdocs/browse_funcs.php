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
    $name = isset($_GET[NAME]) ? trim($_GET[NAME]) : NULL;

    $start_date = isset($_GET[START_DATE]) ? trim($_GET[START_DATE]) : NULL;
    if (!empty($start_date)) {
        check_date($start_date);
    }

    $end_date = isset($_GET[END_DATE]) ? trim($_GET[END_DATE]) : NULL;
    if (!empty($end_date)) {
        check_date($end_date);
    }

    $dbc = get_database_connection();
    $funcs = get_funcs($dbc, $name, $start_date, $end_date, $user);
    close_database_connection($dbc);

    if (isset($_GET[FORMAT]) && $_GET[FORMAT] === JSON) {
        include '../views/browse_funcs_view_json.php';
    } else {
        include '../views/browse_funcs_view.php';
    }
} else {
    throw new Exception(INVALID_REQUEST_METHOD);
}
