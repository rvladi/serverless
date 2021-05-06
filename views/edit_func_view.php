<?php include '../views/header.php'; ?>

<div class="main">
    <div class="content">
        <h4>Edit your function</h4>

        <div class="container">
            <form action="/edit_func.php" method="post">
                <input type="hidden" name="id" value="<?= $func[ID] ?>">

                <label for="name">Function Name</label>
                <input type="text" id="name" name="name" value="<?= $func[NAME] ?>" required>

                <label for="description">Function Description</label>
                <textarea id="description" name="description" style="height:60px" required><?= $func[DESCRIPTION] ?></textarea>

                <label for="body">Function Body</label>
                <textarea id="body" name="body" class="code" spellcheck="false" required><?= $func[BODY] ?></textarea>

                <input type="submit" value="Submit">
            </form>
        </div>

<?php include '../views/footer.php'; ?>
