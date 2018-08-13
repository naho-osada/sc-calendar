<?php
	/**
     * SC Calendar
     * MITライセンスを使用しています。
     * 詳しくはREADME.txtを参照してください。
     *
     * 作成者：Naho Osada（おさだなほ）
     * https://wm-web-se-pg.com/
	 * カレンダー管理画面
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');
	$calLibrary = new scCalendarLibrary();

	// アクセス日時
	$datas = $_POST;
	$errMsg = '';

	session_start();
	// ログイン画面に来た時にセッションとクッキーがある場合は破棄
	if(isset($_SESSION) && isset($_COOKIE['choco'])) {
	    $calLibrary->logout();
	} else if(!empty($datas)) {
	    $result = $calLibrary->loginCheck($datas['user-id'], $datas['user-pass']);
	    if($result === false) {
	        $errMsg = 'ログイン情報に誤りがあります。';
	    } else {
            // 処理完了後、リダイレクト
            header('Location: ./index.php');
            exit;
	    }
	}
?>
<html>
<head>
    <title>ログイン/SC&nbsp;Calendar管理画面</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="./css/style-admin.css">
</head>
<body>
<header class="main-img"><img src="./img/scCalendarImg.jpg" alt="ヘッダー画像" /></header>
<div class="login-main">
    <h1>ログイン</h1>
    <div class="admin-box">
<?php
    if(!empty($errMsg)) {
        echo '<span class="err-msg">' . $errMsg . '</span>';
    }
?>
        <form method="post" action="./login.php">
        	<dl class="login-box">
        		<dt>ID</dt>
        		<dd><input type="text" name="user-id" class="admin-text" value="" /></dd>
        		<dt>PASS</dt>
        		<dd><input type="password" name="user-pass" class="admin-text" value="" /></dd>
        	</dl>
        	<div class="scCalendarLogin"><input type="submit" id="scCalendarLogin" value="ログイン" /></div>
        </form>
    </div>
    </div>
	<footer class="footer-copy">&copy; 2018 <a href="https://wm-web-se-pg.com/" target="_blank">Naho Osada</a></footer>
</body>
</html>
