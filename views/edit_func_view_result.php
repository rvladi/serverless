<?php include '../views/header.php'; ?>

<div class="main">
    <div class="content">
        <div class="resultsContainer">
            <h4>The function has been edited successfully.</h4>

            <h1 class="func"><?= $func[NAME] ?></h1>
            <p><span class="func">Created:</span> <?= $func[CREATED] ?></p>
            <p><span class="func">Updated:</span> <?= $func[UPDATED] ?></p>
            <p><span class="func">Executed:</span> <?= $func[EXECUTED] ?></p>
            <p><span class="func">Executions:</span> <?= $func[EXECUTIONS] ?></p>
            <p><span class="func">Description:</span> <?= $func[DESCRIPTION] ?></p>
            <p><span class="func">Body:</span></p>
            <textarea class="code" readonly><?= $func[BODY] ?></textarea>
        </div>

        <form>
            <input type="hidden" name="id" value="<?= $func[ID] ?>">
            <table class="show_func_actions">
                <tr>
                    <td><input style="float:left" type="submit" value="Execute function" formaction="/execute_func.php" formmethod="get"></td>
                    <td><input type="submit" value="Edit function" formaction="/edit_func.php" formmethod="get"></td>
                    <td><input type="submit" value="Delete function" formaction="/delete_func.php" formmethod="post"></td>
                </tr>
            <table>
        </form>

<?php include '../views/footer.php'; ?>
