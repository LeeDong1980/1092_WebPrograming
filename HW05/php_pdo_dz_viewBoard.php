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
        <h1 class="title">Homework 05</h1>
        <div class="left">
            <p><?php
                $exist_any = false;
                if (isset($_GET['id'])) {
                    $sth = $dbh->prepare('SELECT id FROM dz_board_authority WHERE id = ?');
                    $sth->execute(array((int)$_GET['id']));
                    if ($sth->rowCount() == 1) {
                        $sth2 = $dbh->prepare('SELECT * from dz_thread_authority WHERE board_id = ? AND root_thread_id = 0 ORDER BY id');
                        $sth2->execute(array((int)$_GET['id']));
                        while ($row = $sth2->fetch(PDO::FETCH_ASSOC)) {
                            echo '<div class="thread">' . '#' . $row['id'] . ' ' . '<a href="php_pdo_dz_viewThread.php?id=' . $row['id'] . '">' . htmlspecialchars($row['title']) . '</a> ??????: ' . htmlspecialchars($row['nickname']) . ' IP (' . $row['ip'] . ')' . '<br>' . '</div>';
                            $exist_any = true;
                        }
                        if (!$exist_any)
                            echo '<p class="not_exist">???????????????????????????????????????</p>';
                    } else {
                        echo '<p class="accese_denied">???????????????, ???????????????</p>';
                    }
                } else {
                    echo '<p class="accese_denied">???????????????, ???????????????</p>';
                }
                ?></p>

            <?php
            if (isset($_GET['id']) && isset($_POST['title']) && isset($_POST['content'])) {
                if (strlen($_POST['title']) && strlen($_POST['content'])) {
                    if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                        $sth = $dbh->prepare('SELECT id FROM dz_board_authority WHERE id = ?');
                        $sth->execute(array((int)$_GET['id']));
                        if ($sth->rowCount() == 1) {
                            $ownerAuth = $dbh->prepare('SELECT authority FROM user_authority WHERE account = ?');
                            $ownerAuth->execute(array($_SESSION['account']));
                            $ownerAuth_result = $ownerAuth->fetch();
                            $auth = $ownerAuth_result[0];

                            $sth2 = $dbh->prepare(
                                'INSERT INTO dz_thread_authority (board_id, nickname, title, content, ip, ownerauthority) VALUES (?, ?, ?, ?, ?, ?)'
                            );
                            $sth2->execute(array(
                                (int)$_GET['id'],
                                $_SESSION['nickname'],
                                $_POST['title'],
                                $_POST['content'],
                                $_SERVER['REMOTE_ADDR'],
                                (int)$auth
                            ));
                            echo '<meta http-equiv=REFRESH CONTENT=0;url=php_pdo_dz_viewBoard.php?id=' . (int)$_GET['id'] . '>';
                        }
                    } else {
                        echo '<p align=center class="accese_denied">???????????????????????????????????????</p>';
                    }
                } else {
                    echo '<p align=center class="accese_denied">?????????????????????????????????/?????????????????????</p>';
                }
            }
            ?>

            <hr>
            <form action="php_pdo_dz_viewBoard.php?id=<?php echo (int)$_GET['id']; ?>" method="post">
                ???????????????<br><br>
                ?????????<input name="title"><br><br>
                ?????????<textarea name="content"></textarea><br><br>
                <input id=submit type="submit" value="??????">
            </form>
        </div>
        <div class="right">
            <?php
            if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                echo '<p class="accese_accepted">????????????: ?????????</p>';
                echo '<p class="log-out"><a href="php_sess_logout.php">??????</a></p>';
            } else {
                echo '<p class="accese_denied">????????????: ?????????</p>';
                echo '<p class="acc"><a href="php_sess_login.php">???????????????</a></p>';
            }
            echo '<p class="homepage"><a href="./HW05.php">???????????????</a></p>';
            $adminAuth = $dbh->prepare('SELECT authority FROM user_authority WHERE account = ?');
            $adminAuth->execute(array($_SESSION['account']));
            $adminAuth_result = $adminAuth->fetch();
            $adminFinal = $adminAuth_result[0];
            if (substr($adminFinal, 0, 1) === "1") {
                echo '<br><br><p class="homepage">???????????????</p>';
                echo '<p class="homepage"><a href="php_deleteTopic.php?id=' . $_GET['id'] . '">??????????????????</a></p>';
            }
            ?>
        </div>
    </div>

</body>

</html>