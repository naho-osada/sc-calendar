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
	 * 日付の更新用
	 */
	require_once(dirname(__FILE__) . '/../library/library.php');

	$calLibrary = new scCalendarLibrary();

	$postDatas = $_POST;

	// 存在する年月日かチェック、存在しない場合は何もしない
	if(strlen($postDatas['year']) != 4 || !preg_match("/^[0-9]+$/",$postDatas['year']) || $postDatas['year'] < 1970 || $postDatas['year'] > 2037){
		return false;
	}
	if($postDatas['month'] < 1 || $postDatas['month'] > 12 || !preg_match("/^[0-9]+$/",$postDatas['month'])){
		return false;
	}
	if($postDatas['day'] < 1 || $postDatas['day'] > 31 || !preg_match("/^[0-9]+$/",$postDatas['day'])){
		return false;
	}
	if(!checkdate($postDatas['month'], $postDatas['day'], $postDatas['year'])) {
		return false;
	}
	if($postDatas['dayFlg'] != 1 && $postDatas['dayFlg'] != 2) {
		return false;
	}

	$result = $calLibrary->changeDayData($postDatas);

	// 処理完了
	echo $result;
?>
