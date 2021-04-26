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
    <title>Document</title>
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

        .left {
            display: inline-block;
            width: 60%;
            height: auto;
            margin-top: 15px;
            margin-left: 30px;
        }

        .right {
            display: inline-block;
            float: right;
            text-align: right;
            width: 30%;
            margin-top: 15px;
            margin-right: 50px;
            padding: 10px;
            border: 3px solid black;
        }

        .thread {
            border: 1px solid black;
            padding: 5px;
            font-size: 16px;
        }

        .accese_accepted {
            font-size: 20px;
            text-align: right;
            margin-right: 30px;
        }

        .log-out {
            font-size: 20px;
            text-align: right;
            margin-right: 30px;
        }

        .accese_denied {
            font-size: 20px;
            text-align: right;
            margin-right: 30px;
        }

        .homepage {
            font-size: 20px;
            text-align: right;
            margin-right: 30px;
        }

        .acc {
            display: block;
            text-align: right;
            margin-right: 30px;
            font-size: 20px;
        }

        hr {
            margin: 20px auto;
        }

        form {
            text-align: left;
            display: table-cell;
            border: 1px solid black;
            margin: 30px;
            padding: 20px;
            font-size: 16px;
            width: 50%;
        }

        form>input {
            width: 80%;
        }

        form>textarea {
            width: 80%;
            height: 80px;
        }

        form>#submit {
            width: 30%;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div id="app">
        <h1 class="title">Homework 04</h1>
        <div class="left">
            <p><?php
                $exist_any = false;
                if (isset($_GET['id'])) {
                    $sth = $dbh->prepare('SELECT id FROM dz_board WHERE id = ?');
                    $sth->execute(array((int)$_GET['id']));
                    if ($sth->rowCount() == 1) {
                        $sth2 = $dbh->prepare('SELECT * from dz_thread WHERE board_id = ? ORDER BY id');
                        $sth2->execute(array((int)$_GET['id']));
                        while ($row = $sth2->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="thread">' . '#' . $row['id'] . ' ' . '<a href="php_pdo_dz_viewThread.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a> 作者: ' . htmlspecialchars($row['nickname']) . ' IP (' . $row['ip'] . ')' . '<br>' . '</div>';
                            $exist_any = true;
                        }
                        if (!$exist_any)
                            echo '<p class="not_exist">目前此看板不存在任何討論串</p>';
                    } else {
                        echo '<p class="accese_denied">看板不存在, 請重新操作</p>';
                    }
                } else {
                    echo '<p class="accese_denied">未指定看板, 請重新操作</p>';
                }
                ?></p>

            <?php
            if (isset($_GET['id']) && isset($_POST['title']) && isset($_POST['content'])) {
                if (strlen($_POST['title']) && strlen($_POST['content'])) {
                    if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                        $sth = $dbh->prepare('SELECT id FROM dz_board WHERE id = ?');
                        $sth->execute(array((int)$_GET['id']));
                        if ($sth->rowCount() == 1) {
                            $sth2 = $dbh->prepare(
                                'INSERT INTO dz_thread (board_id, nickname, title, content, ip) VALUES (?, ?, ?, ?, ?)'
                            );
                            $sth2->execute(array(
                                (int)$_GET['id'],
                                $_SESSION['nickname'],
                                $_POST['title'],
                                $_POST['content'],
                                $_SERVER['REMOTE_ADDR']
                            ));
                            echo '<meta http-equiv=REFRESH CONTENT=0;url=php_pdo_dz_viewBoard.php?id=' . (int)$_GET['id'] . '>';
                        }
                    } else {
                        echo '<p align=center class="accese_denied">發表新主題前，請先登入帳戶</p>';
                    }
                } else {
                    echo '<p align=center class="accese_denied">發表新主題前請注意標題/內容不得為空白</p>';
                }
            }
            ?>

            <hr>
            <form action="php_pdo_dz_viewBoard.php?id=<?php echo (int)$_GET['id']; ?>" method="post">
                發表主題：<br><br>
                標題：<input name="title"><br><br>
                內容：<textarea name="content"></textarea><br><br>
                <input id=submit type="submit" value="發表">
            </form>
        </div>
        <div class="right">
            <?php
            if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                echo '<p class="accese_accepted">目前狀態: 已登入</p>';
                echo '<p class="log-out"><a href="php_sess_logout.php">登出</a></p>';
            } else {
                echo '<p class="accese_denied">目前狀態: 未登入</p>';
                echo '<p class="acc"><a href="php_sess_login.php">使用者登入</a></p>';
            }
            echo '<p class="homepage"><a href="./HW04.php">回到主頁面</a></p>';
            ?>
        </div>
    </div>

</body>

</html>