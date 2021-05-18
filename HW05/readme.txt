HW05.php 討論版首頁，可看見各討論版
pdoInc.php 資料庫連線資訊
php_pdo_dz_viewBoard.php 進入討論版，可看見各討論串
php_pdo_dz_viewThread.php 進入討論串，可看見各回復
php_sess_edit.php 修改帳戶資料
php_sess_login.php 登入輸入帳密
php_sess_logout.php 登出跳轉
php_sess_register.php 註冊帳戶
php_deleteReply.php 刪除主題下除發文者外全部留言
php_deleteTopic.php 刪除看板下全部主題

1.刪除功能如何控管權限？
>> 為註冊使用者新增權限欄位，當權限符合時才會出現刪除按鈕，若使用者試圖透過輸入網址方式進入刪除頁面，也會經過權限檢核才刪除。