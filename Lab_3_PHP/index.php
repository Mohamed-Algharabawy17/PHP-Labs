<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 3</title>
    <link rel="stylesheet" href="./style.css">
</head>

<body>
        <?php
            require_once "vendor/autoload.php";
            $counter = new Counter(visit_count_file);
            $data = $counter -> check();
        ?>
    <div id="data-div">
        <h1>Number of visitors is: </h1>
        <h1 id="data-h1">
            <?= $data ?>
        </h1>
</div>
</body>

</html>