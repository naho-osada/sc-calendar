<?php
	/**
     * SC Calendar
     * MITライセンスを使用しています。
     * 詳しくはREADME.txtを参照してください。
     *
     * 作成者：Naho Osada（おさだなほ）
     * https://wm-web-se-pg.com/
     *
	 * 管理画面用
	 * 更新ボタンを押されたときに、処理を実行
	 * 処理完了後、リダイレクト
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');
	$calLIBRARY = new scCalendarLibrary();

	$datas = $_POST;

	$result = $calLIBRARY->updateSetting($datas);

	// 処理完了後、リダイレクト
	header('Location: ./index.php?time=' . time());
	exit;
?>
