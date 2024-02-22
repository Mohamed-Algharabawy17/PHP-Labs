<?php
    $user_logs = file("submitted_data.txt");
    // print_r($user_logs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>User Data Table</h1>
    <table>
        <tr>
            <th>Visit Date&Time</th>
            <th>IP Address</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
        </tr>
        <?php foreach($user_logs as $line) { 
            $data = explode(",", $line);
            $date_time = $data[0];
            $ip_address = $data[1];
            $name = $data[2];
            $email = $data[3];
            $message = $data[4];
        ?>
            <tr>
                <td><?= $date_time ?></td>
                <td><?= $ip_address ?></td>
                <td><?= $name ?></td>
                <td><?= $email ?></td>
                <td><?= $message ?></td>
            </tr>
        <?php } ?>

    </table>
</body>

</html>
