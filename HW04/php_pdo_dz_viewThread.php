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
        <h1 class="title">Homework 04</h1>
        <div class="left">
            <?php
            function showMsg($row, $numFloor)
            {
                $title = htmlspecialchars($row['title']);
                $nn = htmlspecialchars($row['nickname']);
                $msg = htmlspecialchars($row['content']);
                $msg = str_replace("\n", "<br>", $msg);
                if ($numFloor == 0) {
                    echo '<div class="thread-title"><b>??????????????????' . $title . '</b></div><br>';
                }
                echo '<div class="first-floor">#' . ($numFloor + 1) . "</div>";
                echo '<table border="1" align="center" cellspacing="0" cellpadding="0"><tr>';
                echo "<td>?????????: " . $nn . "</td>";
                echo "<td>??????: " . $row['time'] . "</td>";
                echo "<td>IP: " . $row['ip'] . "</td></tr>";
                echo "<tr><td colspan=\"3\">????????????:<br>" . $msg . "</td></tr></table><br>";
            }

            if (isset($_GET['id']) && isset($_POST['content'])) {
                if (strlen($_POST['content'])) {
                    if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                        $sth = $dbh->prepare('SELECT id FROM dz_thread WHERE id = ? and board_id <> 0');
                        $sth->execute(array((int)$_GET['id']));
                        if ($sth->rowCount() > 0) {
                            $sth2 = $dbh->prepare(
                                'INSERT INTO dz_thread (nickname, content, ip, root_thread_id) VALUES (?, ?, ?, ?)'
                            );
                            $sth2->execute(array(
                                $_SESSION['nickname'],
                                $_POST['content'],
                                $_SERVER['REMOTE_ADDR'],
                                (int)$_GET['id']
                            ));
                            echo '<meta http-equiv=REFRESH CONTENT=0;url=php_pdo_dz_viewThread.php?id=' . (int)$_GET['id'] . '>';
                        }
                    } else {
                        echo '<p align=center class="accese_denied">????????????????????????????????????</p>';
                    }
                } else {
                    echo '<p align=center class="accese_denied">????????????????????????????????????????????????</p>';
                }
            }
            ?>

            <p align=center>
                <?php
                if (isset($_GET['id'])) {
                    $sth = $dbh->prepare('
        SELECT * from dz_thread
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
                        echo '<p class="accese_denied">??????????????????, ???????????????';
                    }
                } else {
                    echo '<p class="accese_denied">??????????????????, ???????????????';
                }
                ?></p>

            <hr>

            <form action="php_pdo_dz_viewThread.php?id=<?php echo (int)$_GET['id']; ?>" method="post">
                ???????????????<br><br>
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
            echo '<p class="homepage"><a href="./HW04.php">???????????????</a></p>';
            ?>
        </div>
    </div>










</body>

</html>