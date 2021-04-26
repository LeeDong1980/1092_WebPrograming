HW04.php 討論版首頁，可看見各討論版
pdoInc.php 資料庫連線資訊
php_pdo_dz_viewBoard.php 進入討論版，可看見各討論串
php_pdo_dz_viewThread.php 進入討論串，可看見各回復
php_sess_edit.php 修改帳戶資料
php_sess_login.php 登入輸入帳密
php_sess_logout.php 登出跳轉
php_sess_register.php 註冊帳戶

1.如何避免相同的帳號註冊(你可以假設不會有多人幾乎同時註冊)？
>> 如果提交的帳號不存在資料庫中(即查閱此帳號後，結果row數為0)，則准予註冊，否則跳通知阻擋。

2.如何避免未登入的發表？
>> 在發表主題或留言時，檢查Session中是否存有帳號資訊，若無則跳通知阻擋。