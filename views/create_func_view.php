<?php include '../views/header.php'; ?>

<div class="main">
    <div class="content">
        <h1>Create your function</h1>
        <div class="container">
            <form action="/create_func.php" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Enter the name of your function" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" placeholder="Write a short description of your function"
                          style="height:60px" required></textarea>

                <label for="body">Body</label>
                <textarea id="body" name="body" class="code" spellcheck="false" required><?=
                    htmlspecialchars(BODY_TEMPLATE)
                ?></textarea>

                <input type="submit" value="Submit">
            </form>
        </div>

<?php include '../views/footer.php'; ?>
