<?php
/**
 * SC Calendar
 * MITライセンスを使用しています。
 * 詳しくはREADME.txtを参照してください。
 *
 * 作成者：Naho Osada（おさだなほ）
 * https://wm-web-se-pg.com/
 *
 * 設定ファイル
 */

class scCalendarConfigs {
	public $SUN = 0;
	public $MON = 1;
	public $TUE = 2;
	public $WED = 3;
	public $THU = 4;
	public $FRI = 5;
	public $SAT = 6;

	public $SUN_JP = '日';
	public $MON_JP = '月';
	public $TUE_JP = '火';
	public $WED_JP = '水';
	public $THU_JP = '木';
	public $FRI_JP = '金';
	public $SAT_JP = '土';

	public $SUN_EN = 'SUN';
	public $MON_EN = 'MON';
	public $TUE_EN = 'TUE';
	public $WED_EN = 'WED';
	public $THU_EN = 'THU';
	public $FRI_EN = 'FRI';
	public $SAT_EN = 'SAT';

	/**
	 * 曜日の出力用
	 * $n 曜日番号
	 * $lang 言語コード
	 */
	public function setWeekStr() {
	    $weeks = array();
	    $weeks = array(
	        0 => array($this->LANG_JA => $this->SUN_JP, $this->LANG_EN => $this->SUN_EN),
	        1 => array($this->LANG_JA => $this->MON_JP, $this->LANG_EN => $this->MON_EN),
	        2 => array($this->LANG_JA => $this->TUE_JP, $this->LANG_EN => $this->TUE_EN),
	        3 => array($this->LANG_JA => $this->WED_JP, $this->LANG_EN => $this->WED_EN),
	        4 => array($this->LANG_JA => $this->THU_JP, $this->LANG_EN => $this->THU_EN),
	        5 => array($this->LANG_JA => $this->FRI_JP, $this->LANG_EN => $this->FRI_EN),
	        6 => array($this->LANG_JA => $this->SAT_JP, $this->LANG_EN => $this->SAT_EN)
	    );
	    return $weeks;
	}

	/**
	 * カレンダーの曜日言語設定
	 * 1 日本語
	 * 2 英語
	 */
	public $LANG_JA = 1;
	public $LANG_EN = 2;

	public $LANG_JA_NAME = '日本語';
	public $LANG_EN_NAME = '英語';

	public function setLang() {
	    $langs = array();
	    $langs = array(
	        $this->LANG_JA => $this->LANG_JA_NAME,
	        $this->LANG_EN => $this->LANG_EN_NAME
	    );
	    return $langs;
	}

	/**
	 * カレンダーの週始まり設定
	 * 1 日曜日
	 * 2 月曜日
	 */
	public $WEEK_SUN = 1;
	public $WEEK_MON = 2;

	public $WEEK_SUN_NAME = '日曜始まり';
	public $WEEK_MON_NAME = '月曜始まり';

	public function setWeekStart() {
	    $startW = array();
	    $startW = array(
	        $this->WEEK_SUN => $this->WEEK_SUN_NAME,
	        $this->WEEK_MON => $this->WEEK_MON_NAME
	    );
	    return $startW;
	}

	/**
	 * カレンダーのタイトル入力文字数
	 */
	public $CALENDAR_TITLE_NUM = 20;
}
?>