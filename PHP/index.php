<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Setup Choices</title>
</head>

<body>
    <!--Sorry i forgot to style the php page-->
    <h1>Step 1 - Select Number of Choices</h1>
    <form method="GET" action="secondPage.php">
        <label>Number of Choices:</label>
        <select name="choices">
            <?php for ($i = 2; $i <= 5; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Continue</button>
    </form>
</body>

</html>