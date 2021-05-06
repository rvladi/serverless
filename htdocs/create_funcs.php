<?php session_start(); ?>
<?php include '../views/header.php'; ?>
<header class="parallax"></header>
<div class="main">
    <div class="content">
        <h1>Create your functions here!</h1>
        <div class="resultsContainer">

            <img src="/images/tools.png"
                 style="float:left; margin-right: 30px">

            <p>Anyone can create and execute a function on Serverless.</p>
            <p>You can easily run code without provisioning or managing servers.</p>
            <p>Thousands of cloud computing enthusiasts use the Serverless platform every month.</p>
            <br/>
            <form action="/create_func.php" method="get">
                <input id="button" type="submit" value="Create my function!">
            </form>
        </div>
<?php include '../views/footer.php'; ?>
