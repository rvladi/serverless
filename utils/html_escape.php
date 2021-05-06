<?php
include_once 'constants.php';

if (isset($error)) {
    $error = htmlspecialchars($error);
}

if (isset($location)) {
    $location = htmlspecialchars($location);
}

if (isset($funcs)) {
    foreach ($funcs as &$func) {
        $func[NAME] = htmlspecialchars($func[NAME]);
        $func[DESCRIPTION] = htmlspecialchars($func[DESCRIPTION]);
        $func[BODY] = htmlspecialchars($func[BODY]);
        $func[CREATED] = htmlspecialchars($func[CREATED]);
        $func[UPDATED] = htmlspecialchars($func[UPDATED]);
        $func[EXECUTED] = htmlspecialchars($func[EXECUTED]);
    }
    unset($func);
}

if (isset($func)) {
    $func[NAME] = htmlspecialchars($func[NAME]);
    $func[DESCRIPTION] = htmlspecialchars($func[DESCRIPTION]);
    $func[BODY] = htmlspecialchars($func[BODY]);
    $func[CREATED] = htmlspecialchars($func[CREATED]);
    $func[UPDATED] = htmlspecialchars($func[UPDATED]);
    $func[EXECUTED] = htmlspecialchars($func[EXECUTED]);
}

if (isset($param)) {
    $param = htmlspecialchars($param);
}

if (isset($result)) {
    $result = htmlspecialchars($result);
}
