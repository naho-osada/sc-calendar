<?php
	/**
     * SC Calendar
     * MITライセンスを使用しています。
     * 詳しくはREADME.txtを参照してください。
     *
     * 作成者：Naho Osada（おさだなほ）
     * https://wm-web-se-pg.com/
     *
	 * カレンダー管理画面
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');
	require_once(dirname(__FILE__) . '/../library/configs.php');
	require(dirname(__FILE__) . '/../datas/setting.php');

	$calConfigs = new scCalendarConfigs();
	$calLibrary = new scCalendarLibrary();

	if($calLibrary->loginCheck() === false) {
	    // ログインしていない場合はリダイレクト
	    header('Location: ./login.php');
	    exit;
	}

	$calendarString = $calLibrary->getCalendar(true);

	// 設定値の読み込み
	$langs = $calConfigs->setLang();
	$startW = $calConfigs->setWeekStart();
?>
<!DOCTYPE html>
<html>
<head>
    <title>登録情報の変更/SC&nbsp;Calendar管理画面</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../css/calendar.css">
    <link rel="stylesheet" href="./css/style-admin.css">
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="./js/jquery-ui.js"></script>
    <script type="text/javascript" src="./js/calendar.js"></script>
</head>
<body>
<header class="main-img"><img src="./img/scCalendarImg.jpg" alt="ヘッダー画像" /></header>
<div class="main">
<div class="scCalendarLogout"><a href="./logout.php">ログアウト</a></div>
    <h1>登録情報の変更</h1>
    <div class="contents">
    <ul>
        <li>スケジュールの登録は日付をクリックすると日付セルの色が変わります。</li>
        <li>その他の項目（言語、週始まり、表示範囲、カレンダーコメント）は変更後、「登録」ボタンをクリックしてください。</li>
    	<li><span class="txt-red">カレンダータイトルに制限文字数以上を入力した場合は自動で<?php echo $calConfigs->CALENDAR_TITLE_NUM; ?>文字数内のものを登録します。</span></li>
    </ul>
    </div>
    <h2>現在のカレンダー</h2>
    <div id="scCalendarMainArea" class="calendar-area"><?php echo $calendarString; ?></div>
    <h2>その他の設定</h2>
    <div class="admin-box" id="admin-box">
        <form method="post" class="update-set" action="./change.php">
        	<dl>
        		<dt>言語</dt>
        		<dd>
<?php
            $count = 0;
            foreach($langs as $key=>$lang) {
                if($count != 0) {
                    echo "&nbsp;";
                }
                $check = ($SET_LANGUAGE == $key) ? 'checked' : '';
?>
    				<label for="lang<?php echo $key?>"><input type="radio" name="lang" id="lang<?php echo $key?>" value="<?php echo $key?>" <?php echo $check;?>/><?php echo $lang; ?></label>
<?php
            $count++;
            }
?>
        		</dd>
        		<dt>週始まり</dt>
        		<dd>
<?php
            $count = 0;
            foreach($startW as $key=>$start) {
                if($count != 0) {
                    echo "&nbsp;";
                }
                $check = ($SET_WEEKSTART == $key) ? 'checked' : '';
?>
    				<label for="start<?php echo $key?>"><input type="radio" name="start" id="start<?php echo $key?>" value="<?php echo $key?>" <?php echo $check; ?>/><?php echo $start; ?></label>
<?php
            $count++;
            }
?>
        		</dd>
        		<dt>表示範囲</dt>
        		<dd>
        		<select name="range" id="range" class="range">
<?php
        // 最大2年分
        for($i=1; $i<25; $i++) {
            $select = ($SET_RANGE == $i) ? 'selected' : '';
?>
    			<option value="<?php echo $i; ?>" <?php echo $select; ?>><?php echo $i; ?></option>
<?php
        }
?>
        		</select>ヶ月分
        		</dd>
        		<dt>カレンダータイトル<br><span class="txt-red"><?php echo $calConfigs->CALENDAR_TITLE_NUM; ?>文字以内</span></dt>
        		<dd><input type="text" name="sctitle" class="sctitle" value="<?php echo $SET_CALTITLE; ?>" /></dd>
        	</dl>
        	<div class="scCalendarUpdate"><input type="submit" value="登&nbsp;録" id="scCalendarUpdate" /></div>
        </form>
    </div>
    </div>
	<footer class="footer-copy">&copy; 2018 <a href="https://wm-web-se-pg.com/" target="_blank">Naho Osada</a></footer>
</body>
</html>
