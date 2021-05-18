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
            margin-top: 30px;
        }

        .right {
            display: inline-block;
            float: right;
            text-align: right;
            width: 30%;
            margin-top: 30px;
            margin-right: 50px;
            padding: 10px;
            border: 3px solid black;
            font-size: 20px;
        }

        .view-board {
            display: block;
            margin: 0 auto;
            text-align: center;
        }

        .welcome {
            font-size: 20px;
            text-align: right;
            margin-right: 30px;
        }

        .acc {
            display: block;
            /* float: right; */
            text-align: right;
            margin-right: 30px;
            font-size: 20px;
        }

        table {
            border: 3px solid black;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }

        td {
            padding: 10px;
        }

        td,
        tr {

            border: 1px solid black;
            text-align: center;
            font-size: 24px;
        }


        td>a:hover {
            background-color: #F9C784;
        }
    </style>
</head>

<body>
    <div id="app">
        <h1 class="title">Homework 05</h1>
        <div class="left">
            <div class="view-board">
                <table border="1" align="center" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><b>看板名稱</b></td>
                    </tr>
                    <?php
                    $sth = $dbh->query("SELECT * FROM dz_board_authority");
                    while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>" . "<td>" . '<a href="php_pdo_dz_viewBoard.php?id=' . $row['id'] . '">' . $row['name'] . '</a>' . "</td>" . "</tr>";
                    }
                    ?>

                </table>

            </div>
        </div>
        <div class="right">
            <div>
                <?php
                if (isset($_SESSION['account']) && $_SESSION['account'] != null) {
                    echo '<div class="welcome">' . '<p>Hi, ' . $_SESSION['nickname'] . ' 歡迎來到討論版</p>' . '</div>';
                    echo '<p class="acc"><a href="php_sess_edit.php">修改帳戶資料</a></p>';
                    echo '<p class="acc"><a href="php_sess_logout.php">登出</a></p>';
                } else {
                    echo '<p class="acc"><a href="php_sess_register.php">使用者註冊</a></p>';
                    echo '<p class="acc"><a href="php_sess_login.php">使用者登入</a></p>';
                }
                ?>
            </div>
        </div>

    </div>

</body>

</html>