<?php
	/**
     * SC Calendar
     * MITライセンスを使用しています。
     * 詳しくはREADME.txtを参照してください。
     *
     * 作成者：Naho Osada（おさだなほ）
     * https://wm-web-se-pg.com/
     *
	 * カレンダー表示のajax通信処理用
	 * 管理画面用
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');
	$caljpLibrary = new scCalendarLibrary();
	$calendarString = $caljpLibrary->getCalendar(true);
	echo $calendarString;
?>
