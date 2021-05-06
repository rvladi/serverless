<?php ob_start(); ?>
<?php include '../utils/html_escape.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Serverless</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/serverless.css">
    <link rel="stylesheet" type="text/css" href="/css/func_grid.css">
</head>
<body>
<div class="sidebar">
    <h1 class="websiteName">Serverless</h1>
    <nav id="nav">
        <div class="menu">
            <div class="navButton">
                <hr>
                <hr>
                <hr>
            </div>
        </div>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/browse_funcs.php">Browse Functions</a></li>
            <li><a href="/create_funcs.php">Create Functions</a></li>

            <?php if (isset($_SESSION[USER_ID])): ?>
                <li><a href="/logout.php">Log Out</a></li>
            <?php else: ?>
                <li><a href="/login.php">Log In</a></li>
                <li><a href="/signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <?php if (isset($_SESSION[USERNAME])): ?>
        <p style="position: absolute; width: 100%; text-align: center; bottom: 10px; color: orange">User: <?= $_SESSION[USERNAME] ?></p>
    <?php endif; ?>
</div>
