<?php
function exception_handler($e)
{
    $error = $e->getMessage();
    if ((isset($_GET[FORMAT]) && $_GET[FORMAT] === JSON)
        || (isset($_POST[FORMAT]) && $_POST[FORMAT] === JSON)) {
        include '../views/error_json.php';
    } else {
        include '../views/error.php';
    }
}

set_exception_handler('exception_handler');
