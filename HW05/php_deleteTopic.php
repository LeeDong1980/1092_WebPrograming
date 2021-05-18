<?php
session_start();
include("pdoInc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>

<body>
    <?php
    $adminAuth = $dbh->prepare('SELECT authority FROM user_authority WHERE account = ?');
    $adminAuth->execute(array($_SESSION['account']));
    $adminAuth_result = $adminAuth->fetch();
    $adminFinal = $adminAuth_result[0];
    // echo '<p>權限為' . $adminFinal . '</p>';
    if (substr(strval($adminFinal), 0, 1) === "1") {
        $deleteTopic = $dbh->prepare('DELETE FROM dz_thread_authority WHERE board_id = ?');
        $deleteTopic->execute(array((int)$_GET['id']));

        echo '<meta http-equiv=REFRESH CONTENT=0;url=HW05.php>';
    } else {
        echo '<p>無權限刪除，自動跳轉至首頁</p>';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=HW05.php>';
    }

    ?>
</body>

</html>