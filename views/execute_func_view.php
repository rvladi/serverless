<?php include '../views/header.php'; ?>

<div class="main">
    <div class="content">
        <h4>Execute your function</h4>

        <div class="resultsContainer">
            <h1 class="func"><?= $func[NAME] ?></h1>

            <p><span class="func">Description:</span> <?= $func[DESCRIPTION] ?></p>
            <p><span class="func">Created:</span> <?= $func[CREATED] ?></p>
            <p><span class="func">Updated:</span> <?= $func[UPDATED] ?></p>
            <p><span class="func">Executed:</span> <?= $func[EXECUTED] ?></p>
            <p><span class="func">Executions:</span> <?= $func[EXECUTIONS] ?></p>
        </div>

        <div class="container">
            <form action="/execute_func.php" method="post">
                <input type="hidden" name="id" value="<?= $func[ID] ?>">

                <label for="param">Function Parameter in JSON Format:</label>
                <textarea id="param" name="param" class="code" spellcheck="false" required><?=
                    htmlspecialchars(PARAM_TEMPLATE)
                ?></textarea>

                <input type="submit" value="Execute Function">
            </form>
        </div>

<?php include '../views/footer.php'; ?>
