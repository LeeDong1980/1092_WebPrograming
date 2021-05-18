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
    <title>HW05</title>
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

        .left>.thread-title {
            font-size: 20px;
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

        td {
            padding: 10px;
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
        <h1 class="title">Homework 05</h1>
        <div class="left">
            <?php
            function showMsg($row, $numFloor)
            {
                $title = htmlspecialchars($row['title']);
                $nn = htmlspecialchars($row['nickname']);
                $msg = htmlspecialchars($row['content']);
                $msg = str_replace("\n", "<br>", $msg);
                if ($numFloor == 0) {
                    echo '<div class="thread-title"><b>討論串標題：' . $title . '</b></div><br>';
                }
                echo '<div class="first-floor">#' . ($numFloor + 1) . "</div>";
                echo '<table border="1" align="center" cellspacing="0" cellpadding="0"><tr>';
                echo "<td>回應者: " . $nn . "</td>";
                echo "<td>時間: " . $row['time'] . "</td>";
                echo "<td>IP: " . $row['ip'] . "</td></tr>";
                echo "<tr><td colspan=\"3\">留言內容:<br>" . $msg . "</td></tr></table><br>";
            }

            if (isset($_GET['id']) && isset($_POST['content'])) {
                if (strlen($_POST['content'])) {
                    if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                        $sth = $dbh->prepare('SELECT id FROM dz_thread_authority WHERE id = ? and board_id <> 0');
                        $sth->execute(array((int)$_GET['id']));
                        if ($sth->rowCount() > 0) {
                            $ownerAuth = $dbh->prepare('SELECT authority FROM user_authority WHERE account = ?');
                            $ownerAuth->execute(array($_SESSION['account']));
                            $ownerAuth_result = $ownerAuth->fetch();
                            $auth = $ownerAuth_result[0];

                            $boardId = $dbh->prepare('SELECT board_id FROM dz_thread_authority WHERE id = ?');
                            $boardId->execute(array((int)$_GET['id']));
                            $boardId_result = $boardId->fetch();
                            $boardIdFinal = $boardId_result[0];

                            $sth2 = $dbh->prepare(
                                'INSERT INTO dz_thread_authority (board_id, nickname, content, ip, root_thread_id, ownerauthority) VALUES (?, ?, ?, ?, ?, ?)'
                            );
                            $sth2->execute(array(
                                (int)$boardIdFinal,
                                $_SESSION['nickname'],
                                $_POST['content'],
                                $_SERVER['REMOTE_ADDR'],
                                (int)$_GET['id'],
                                (int)$auth
                            ));
                            echo '<meta http-equiv=REFRESH CONTENT=0;url=php_pdo_dz_viewThread.php?id=' . (int)$_GET['id'] . '>';
                        }
                    } else {
                        echo '<p align=center class="accese_denied">發表回應前，請先登入帳戶</p>';
                    }
                } else {
                    echo '<p align=center class="accese_denied">發表回應前，請注意內容不得為空白</p>';
                }
            }
            ?>

            <p align=center>
                <?php
                if (isset($_GET['id'])) {
                    $sth = $dbh->prepare('
        SELECT * from dz_thread_authority
        WHERE (id = ? and board_id <> 0)
        OR (root_thread_id = ?)
        ORDER BY id
    ');
                    $sth->execute(array((int)$_GET['id'], (int)$_GET['id']));
                    if ($sth->rowCount() > 0) {
                        $numFloor = 0;
                        while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                            showMsg($row, $numFloor++);
                        }
                    } else {
                        echo '<p class="accese_denied">討論串不存在, 請重新操作';
                    }
                } else {
                    echo '<p class="accese_denied">未指定討論串, 請重新操作';
                }
                ?></p>

            <hr>

            <form action="php_pdo_dz_viewThread.php?id=<?php echo (int)$_GET['id']; ?>" method="post">
                發表回應：<br><br>
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
            echo '<p class="homepage"><a href="./HW05.php">回到主頁面</a></p>';
            $adminAuth = $dbh->prepare('SELECT authority FROM user_authority WHERE account = ?');
            $adminAuth->execute(array($_SESSION['account']));
            $adminAuth_result = $adminAuth->fetch();
            $adminFinal = $adminAuth_result[0];
            if (substr($adminFinal, 0, 1) === "1") {
                echo '<br><br><p class="homepage">特殊權限：</p>';
                echo '<p class="homepage"><a href="php_deleteReply.php?id=' . $_GET['id'] . '">刪除全部留言</a></p>';
            }
            ?>
        </div>
    </div>










</body>

</html>