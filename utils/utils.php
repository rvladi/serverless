<?php
include_once 'constants.php';
$config = include 'config.php';

// =============================================================================
// validation utils
// =============================================================================

function check_non_empty($string)
{
    if ($string === '') {
        throw new Exception('string must be non-empty');
    }
}

function check_id($id)
{
    if (!ctype_digit($id)) {
        throw new Exception('id must be a non-negative integer');
    }
}

function check_date($date)
{
    if (date_create_from_format('Y-m-d', $date) === FALSE) {
        throw new Exception('invalid date');
    }
}

function validate_username($username)
{
    return strlen($username) >= MIN_UNAME_LEN;
}

function validate_password($password)
{
    return strlen($password) >= MIN_PASSW_LEN;
}

// =============================================================================
// database utils
// =============================================================================

function get_database_connection()
{
    global $config;

    $dbc = @mysqli_connect($config[DB_HOST], $config[DB_USER], $config[DB_PASSWORD], $config[DB_NAME]);
    if (!$dbc) {
        $err = mysqli_connect_error();
        throw new Exception($err);
    }

    $charset_set = mysqli_set_charset($dbc, DB_CHARSET);
    if (!$charset_set) {
        $err = mysqli_error($dbc);
        @mysqli_close($dbc);
        throw new Exception($err);
    }

    return $dbc;
}

function close_database_connection($dbc)
{
    @mysqli_close($dbc);
}

function begin_transaction($dbc)
{
    $success = mysqli_begin_transaction($dbc);
    if (!$success) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function commit_transaction($dbc)
{
    $success = mysqli_commit($dbc);
    if (!$success) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function rollback_transaction($dbc)
{
    $success = mysqli_rollback($dbc);
    if (!$success) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function get_funcs($dbc, $name, $start_date, $end_date, $user)
{
    $funcs = [];

    $name = mysqli_real_escape_string($dbc, $name);
    $start_date = mysqli_real_escape_string($dbc, $start_date);
    $end_date = mysqli_real_escape_string($dbc, $end_date);

    $clauses = ["creator = $user"];
    if ($name) {
        $clauses[] = "name LIKE '$name%'";
    }
    if ($start_date) {
        $clauses[] = "created >= '$start_date'";
    }
    if ($end_date) {
        $clauses[] = "created <= '$end_date'";
    }
    $where_clause = 'WHERE ' . implode(' AND ', $clauses);

    $sql = "SELECT id, name, description, body, created, updated, executed, executions FROM funcs $where_clause";

    if ($res = mysqli_query($dbc, $sql)) {
        while ($row = mysqli_fetch_assoc($res)) {
            $funcs[] = [
                ID => (int) $row[ID],
                NAME => $row[NAME],
                DESCRIPTION => $row[DESCRIPTION],
                BODY => $row[BODY],
                CREATED => $row[CREATED],
                UPDATED => $row[UPDATED],
                EXECUTED => $row[EXECUTED],
                EXECUTIONS => (int) $row[EXECUTIONS],
            ];
        }
        mysqli_free_result($res);
    } else {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }

    return $funcs;
}

function get_func($dbc, $id, $user)
{
    $func = NULL;

    $sql = "SELECT id, name, description, body, created, updated, executed, executions FROM funcs"
        . " WHERE id = $id AND creator = $user";

    if ($res = mysqli_query($dbc, $sql)) {
        if ($row = mysqli_fetch_assoc($res)) {
            $func = [
                ID => (int) $row[ID],
                NAME => $row[NAME],
                DESCRIPTION => $row[DESCRIPTION],
                BODY => $row[BODY],
                CREATED => $row[CREATED],
                UPDATED => $row[UPDATED],
                EXECUTED => $row[EXECUTED],
                EXECUTIONS => (int) $row[EXECUTIONS],
            ];
        }
        mysqli_free_result($res);
    } else {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }

    return $func;
}

function create_func($dbc, $name, $description, $body, $user)
{
    $name = mysqli_real_escape_string($dbc, $name);
    $description = mysqli_real_escape_string($dbc, $description);
    $body = mysqli_real_escape_string($dbc, $body);

    $sql = "INSERT INTO funcs(name, description, body, creator)"
        . " VALUES ('$name', '$description', '$body', $user)";

    if (!mysqli_query($dbc, $sql)) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }

    $id = mysqli_insert_id($dbc);
    return $id;
}

function edit_func($dbc, $id, $name, $description, $body, $user)
{
    $name = mysqli_real_escape_string($dbc, $name);
    $description = mysqli_real_escape_string($dbc, $description);
    $body = mysqli_real_escape_string($dbc, $body);

    $sql = "UPDATE funcs SET name = '$name', description = '$description', body = '$body', updated = NOW()"
        . " WHERE id = $id AND creator = $user";

    if (!mysqli_query($dbc, $sql)) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function delete_func($dbc, $id, $user)
{
    $sql = "DELETE FROM funcs WHERE id = $id AND creator = $user";

    if (!mysqli_query($dbc, $sql)) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function execute_func($dbc, $id, $user)
{
    $sql = "UPDATE funcs SET executed = NOW(), executions = executions + 1"
        . " WHERE id = $id AND creator = $user";

    if (!mysqli_query($dbc, $sql)) {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }
}

function get_user($dbc, $username)
{
    $user = NULL;

    $username = mysqli_real_escape_string($dbc, $username);

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";

    if ($res = mysqli_query($dbc, $sql)) {
        if ($row = mysqli_fetch_assoc($res)) {
            $user = [
                ID => (int) $row[ID],
                USERNAME => $row[USERNAME],
                PASSWORD => $row[PASSWORD],
            ];
        }
        mysqli_free_result($res);
    } else {
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }

    return $user;
}

function create_user($dbc, $username, $password)
{
    $username = mysqli_real_escape_string($dbc, $username);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username, password) VALUES ('$username', '$password')";

    if (!mysqli_query($dbc, $sql)) {
        $errno = mysqli_errno($dbc);
        if ($errno === DB_DUP_ENTRY) {
            return NULL;
        }
        $err = mysqli_error($dbc);
        throw new Exception($err);
    }

    $id = mysqli_insert_id($dbc);
    return $id;
}

function create_user_dir($user_id)
{
    $success = @mkdir(JAVA_FUNC_ROOT . "/$user_id");
    return $success;
}

// =============================================================================
// function utils
// =============================================================================

function preprocess_cls($body, $id)
{
    $pattern = '/(public\s+class\s+)(\w+)/';
    $replacement = '$1' . JAVA_CLASS_PREFIX . $id;
    $body = preg_replace($pattern, $replacement, $body, 1 /* $limit */);
    return $body;
}

function compile_cls($body, $id, $user)
{
    $src_path = JAVA_FUNC_ROOT . "/$user/" . JAVA_CLASS_PREFIX . "$id.java";

    // create source file
    $body = preprocess_cls($body, $id);
    file_put_contents($src_path, $body);

    $cmd = "javac -cp " . JAVA_CLASSPATH . " $src_path";

    $descriptorspec = [
        1 => ['file', '/dev/null', 'w'], // stdout
        2 => ['file', '/dev/null', 'w'], // stderr
    ];

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {
        $status = proc_close($process);
        if ($status !== 0) {
            $err = 'error compiling class';
        }
    } else {
        $err = 'error spawning subprocess';
    }

    if (isset($err)) {
        // cleanup
        delete_cls($id, $user);

        throw new Exception($err);
    }
}

function execute_cls($param, $id, $user)
{
    $cmd = "java -cp " . JAVA_CLASSPATH . ":" . JAVA_FUNC_ROOT . "/$user"
        . " -Djava.security.manager=" . JAVA_SECURITY_MANAGER
        . " -Djava.security.policy==" . JAVA_SECURITY_POLICY
        . " " . JAVA_FUNC_EXECUTOR
        . " " . JAVA_CLASS_PREFIX . $id;

    $descriptorspec = [
        0 => ['pipe', 'r'], // stdin
        1 => ['pipe', 'w'], // stdout
        2 => ['pipe', 'w'], // stderr
    ];

    $process = proc_open($cmd, $descriptorspec, $pipes);

    if (is_resource($process)) {
        fwrite($pipes[0], $param);
        fclose($pipes[0]);

        $res = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $err = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        proc_close($process);

        $result = ($err === '') ? $res : json_encode([ERROR => $err]);
    } else {
        $result = json_encode([ERROR => 'error spawning subprocess']);
    }

    return $result;
}

function delete_cls($id, $user)
{
    $base_path = JAVA_FUNC_ROOT . "/$user/" . JAVA_CLASS_PREFIX . $id;

    // remove source file
    @unlink("$base_path.java");

    // remove class file
    @unlink("$base_path.class");

    // remove nested classes
    $classes = glob("$base_path\$*.class");
    foreach ($classes as $class) {
        @unlink($class);
    }
}
