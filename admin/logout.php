<?php
	/**
     * SC Calendar
     * MITライセンスを使用しています。
     * 詳しくはREADME.txtを参照してください。
     *
     * 作成者：Naho Osada（おさだなほ）
     * https://wm-web-se-pg.com/
     *
	 * ログアウト処理
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');
	$calLibrary = new scCalendarLibrary();

	$calLibrary->logout();

    // 処理完了後、リダイレクト
    header('Location: ./login.php');
    exit;
?>
