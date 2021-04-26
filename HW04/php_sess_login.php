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
    <title>Login</title>
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
        if (isset($_SESSION['account']) && $_SESSION['account'] != null) { // 如果登入過，則直接轉到登入後頁面
            echo '<meta http-equiv=REFRESH CONTENT=0;url=HW04.php>';
        } else if (isset($_POST['account']) && isset($_POST['password'])) {
            //E. 檢查是不是英數混和字串
            $standard_E = "/^([0-9A-Za-z]+)$/";
            $accCheck = preg_match($standard_E, $_POST['account'], $result);
            $pwdCheck = preg_match($standard_E, $_POST['password'], $result);
            // $acc = preg_replace("/[^A-Za-z0-9]/", "", $_POST['account']);
            // $pwd = preg_replace("/[^A-Za-z0-9]/", "", $_POST['password']);
            if ($accCheck && $pwdCheck) {
                $sth = $dbh->prepare('SELECT account, pwd, nickname FROM user where account = ?');
                $sth->execute(array($_POST['account']));
                $row = $sth->fetch(PDO::FETCH_ASSOC);
                // 比對密碼
                if ($row['pwd'] == $_POST['password']) {
                    $_SESSION['account'] = $row['account'];
                    $_SESSION['nickname'] = $row['nickname'];
                    echo '<meta http-equiv=REFRESH CONTENT=0;url=HW04.php>';
                } else {
                    echo '<p align=center class="accese_denied">密碼錯誤! 請重新輸入';
                }
            } else {
                echo '<p align=center class="accese_denied">請確認帳號和密碼非空白或含非法字元!';
            }
        }
        ?>

        <form align=center action="php_sess_login.php" method="post">
            帳號：<input type="text" name="account"><br>
            密碼：<input type="password" name="password"><br>
            <input id=submit type="submit">
        </form>

    </div>
</body>

</html>