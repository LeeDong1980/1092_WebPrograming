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
    <title>Register</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        img {
            display: block;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        .title {
            padding: 10px 0 10px 0;
            text-align: center;
            background-color: #485696;
            color: #E7E7E7;
        }

        form {
            margin: 20px auto;
            border: 1px solid black;
            padding: 15px;
            width: 50%;
        }

        form>input {
            margin: 5px auto;

        }

        form>#submit {
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id=app>
        <h1 class="title">Homework 04</h1>
        <?php
        if (isset($_POST['account']) && isset($_POST['password']) && isset($_POST['nickname'])) {
            //E. 檢查是不是英數混和字串
            $standard_E = "/^([0-9A-Za-z]+)$/";
            $accCheck = preg_match($standard_E, $_POST['account'], $result);
            $pwdCheck = preg_match($standard_E, $_POST['password'], $result);
            $nicknameCheck = preg_match($standard_E, $_POST['nickname'], $result);
            if ($accCheck && $pwdCheck && $nicknameCheck) {
                $sth = $dbh->prepare('SELECT account FROM user WHERE account = ?');
                $sth->execute(array($_POST['account']));
                if ($sth->rowCount() == 0) {
                    $sth2 = $dbh->prepare('INSERT INTO user (account, pwd, nickname) VALUES (?, ?, ?)');
                    $sth2->execute(array($_POST['account'], $_POST['password'], $_POST['nickname']));
                    // $sth2->execute(array($acc, $pwd, $nickname));
                    echo '<meta http-equiv=REFRESH CONTENT=0;url=HW04.php>';
                } else {
                    echo '<p align=center class="accese_denied">此帳號已有人註冊了，請換一個新的!</p>';
                }
            } else {
                echo '<p align=center class="accese_denied">註冊時帳號/密碼/暱稱不合法，請輸入英數組合</p>';
            }
        }
        ?>

        <form align=center action="php_sess_register.php" method="post">
            帳號: <input type="text" name="account"><br>
            密碼: <input type="text" name="password"><br>
            暱稱：<input type="text" name="nickname"><br>
            <input id=submit type="submit" value='確認註冊'>
        </form>
    </div>

</body>

</html>