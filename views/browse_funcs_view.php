<?php include '../views/header.php'; ?>

<div class="main">
    <div class="content">
        <h1>Browse Functions</h1>

        <form action="/browse_funcs.php" method="get">
            <table class="browse_funcs_filter">
                <tr>
                    <td>
                        <label for="name">Name prefix:</label>
                        <input type="text" name="name" id="name" value="<?= $name ?>">
                    </td>
                    <td>
                        <label for="start_date">Created after:</label>
                        <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>">
                    </td>
                    <td>
                        <label for="end_date">Created before:</label>
                        <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>">
                    </td>
                    <td>
                        <input type="Submit" value="Filter">
                    </td>
                </tr>
            </table>
        </form>

        <div class="grid-container">
            <?php foreach ($funcs as $func): ?>
                <a href="/show_func.php?id=<?= $func[ID] ?>">
                    <div class="grid-item">
                        <div class="funcImage">
                            <img src="/images/serverless<?= $func[ID] % 5 ?>.jpg" width="100%" height="170px">
                        </div>

                        <br/>

                        <div class="funcName">
                            <p><?= $func[NAME] ?></p>
                        </div>

                        <div class="funcDate">
                            <p>Created: <?= $func[CREATED] ?></p>
                        </div>

                        <div class="funcDate">
                            <p>Updated: <?= $func[UPDATED] ?></p>
                        </div>

                        <div class="funcDate">
                            <p>Executed: <?= $func[EXECUTED] ?></p>
                        </div>

                        <div class="funcDate">
                            <p>Executions: <?= $func[EXECUTIONS] ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

<?php include '../views/footer.php'; ?>
