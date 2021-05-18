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
    <title>Edit</title>
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
        <h1 class="title">Homework 05</h1>

        <?php
        if (!isset($_SESSION['account'])) {
            die('<meta http-equiv=REFRESH CONTENT=0;url=../examples/php_sess_login.php>');
        }

        $resultStr = '';
        if (isset($_POST['nickname']) && isset($_POST['password'])) {
            $sth = $dbh->prepare('SELECT account FROM user_authority WHERE account = ? and pwd = ?');
            $sth->execute(array($_SESSION['account'], $_POST['password']));
            if ($sth->rowCount() == 1) {
                if ($_POST['newpwd1'] != '' && $_POST['newpwd2'] != '') {
                    if ($_POST['newpwd1'] == $_POST['newpwd2']) {
                        //E. 檢查是不是英數混和字串
                        $standard_E = "/^([0-9A-Za-z]+)$/";
                        $pwdCheck = preg_match($standard_E, $_POST['newpwd1'], $result);
                        if ($pwdCheck) {
                            $sth2 =  $dbh->prepare('UPDATE user_authority SET nickname = ?, pwd = ? WHERE account = ?');
                            $sth2->execute(array($_POST['nickname'], $_POST['newpwd1'], $_SESSION['account']));
                            $resultStr = '<p align=center class="accese_accepted">修改暱稱或密碼成功';
                            $_SESSION['nickname'] = $_POST['nickname'];
                        } else {
                            $resultStr = '<p align=center class="accese_denied">新密碼含有非法字元';
                        }
                    } else {
                        $resultStr = '<p align=center class="accese_denied">兩次新密碼填寫不同';
                    }
                } else {
                    $sth2 =  $dbh->prepare('UPDATE user_authority SET nickname = ? WHERE account = ?');
                    $sth2->execute(array($_POST['nickname'], $_SESSION['account']));
                    $_SESSION['nickname'] = $_POST['nickname'];
                    $resultStr = '<p align=center class="accese_accepted">修改暱稱成功';
                }
            } else {
                $resultStr = '<p align=center class="accese_denied">密碼填寫錯誤';
            }
        }
        ?>

        <?php echo $resultStr . '</p>'; ?>

        <form align=center action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">
            帳號：<?php echo $_SESSION['account']; ?><br>
            暱稱：<input name="nickname" value="<?php echo $_SESSION['nickname'] ?>"><br>
            密碼：<input type="password" name="password" placeholder="必填"><br>
            修改密碼：<input name="newpwd1" placeholder="僅修改密碼時需填"><br>
            確認密碼：<input name="newpwd2" placeholder="僅修改密碼時需填"><br>
            <input id="submit" type="submit">
        </form>

        <p align=center><a href="php_sess_logout.php">登出</a></p>
        <p align=center><a href="HW05.php">回到主頁面</a></p>
    </div>
</body>

</html>