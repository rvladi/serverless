<?php session_start(); ?>
<?php include '../views/header.php'; ?>
    <header class="parallax"></header>
    <div class="main">
        <div class="content">
            <h1>Hello Serverless Computing Enthusiasts!</h1>
            <h4 style="text-shadow: none">Welcome to Serverless - the premier platform for serverless functions.</h4>
            <h4 style="text-shadow: none">Here you can:</h4>

            <div class="container">
                <img src="/images/bookshelf.png" class="main_action">
                <h4>View at a glance all functions you have created.</h4>
            </div>

            <div class="container">
                <img src="/images/browser.png" class="main_action">
                <h4>Browse your functions and filter by name and created date.</h4>
            </div>

            <div class="container">
                <img src="/images/gear.png" class="main_action">
                <h4>Pick a function and run it.</h4>
            </div>
        </div>
<?php include '../views/footer.php'; ?>
