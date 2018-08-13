<?php
/**
 * SC Calendar
 * MITライセンスを使用しています。
 * 詳しくはREADME.txtを参照してください。
 *
 * 作成者：Naho Osada（おさだなほ）
 * https://wm-web-se-pg.com/
 *
 * カレンダー用ライブラリ
 */
require(dirname(__FILE__) . '/configs.php');

class scCalendarLibrary {
	/**
	 * 曜日のシステム値と表示テキスト配列
	 */
	private function setWAry($lang, $start) {
		$calCONFIGS = new scCalendarConfigs();
		// 月曜始まりのとき
		if($lang == $calCONFIGS->LANG_EN){
			$weeks = array(
					$calCONFIGS->TUE => $calCONFIGS->TUE_EN,
					$calCONFIGS->WED => $calCONFIGS->WED_EN,
					$calCONFIGS->THU => $calCONFIGS->THU_EN,
					$calCONFIGS->FRI => $calCONFIGS->FRI_EN,
					$calCONFIGS->SAT => $calCONFIGS->SAT_EN,
			);
		} else {
			$weeks = array(
					$calCONFIGS->TUE => $calCONFIGS->TUE_JP,
					$calCONFIGS->WED => $calCONFIGS->WED_JP,
					$calCONFIGS->THU => $calCONFIGS->THU_JP,
					$calCONFIGS->FRI => $calCONFIGS->FRI_JP,
					$calCONFIGS->SAT => $calCONFIGS->SAT_JP,
			);
		}
		// 月曜始まり
		if($start == $calCONFIGS->WEEK_MON) {
			if($lang == $calCONFIGS->LANG_EN) {
				array_unshift($weeks, $calCONFIGS->MON_EN);
				array_push($weeks, $calCONFIGS->SUN_EN);
			} else {
				array_unshift($weeks, $calCONFIGS->MON_JP);
				array_push($weeks, $calCONFIGS->SUN_JP);
			}
		} else {
			if($lang == $calCONFIGS->LANG_EN) {
				array_unshift($weeks, $calCONFIGS->MON_EN);
				array_unshift($weeks, $calCONFIGS->SUN_EN);
			} else {
				array_unshift($weeks, $calCONFIGS->MON_JP);
				array_unshift($weeks, $calCONFIGS->SUN_JP);
			}
		}
		return $weeks;
	}

	/**
	 * カレンダーのヘッダを表示
	 * $year 年
	 * $month 月
	 * $lang 言語 日本語か英語
	 * $headSize Hタグのサイズ 初期は3
	 */
	private function getHeader($year, $month, $lang, $headSize = 3) {
		$calCONFIGS = new scCalendarConfigs();
		if($lang == $calCONFIGS->LANG_EN){
			$string = '<h' . $headSize . '>' . date('M', strtotime($year . '-' . sprintf('%02d', $month) . '-01')) . ', ' . $year . '</h' . $headSize . '>';
		} else {
			$string = '<h' . $headSize . '>' . $year . '年' . $month . '月</h' . $headSize . '>';
		}
		return $string;
	}

	/**
	 * カレンダーのページャーを表示
	 * $lang 言語
	 * $range 表示範囲 次か前の月が現在の指定＋〇か月以上（以下）になる場合、リンクを表示しない
	 */
	private function setPager($lang, $range, $dispYear, $dispMonth) {
		$calCONFIGS = new scCalendarConfigs();

		// 現在の年月から範囲を割り出す
		$nowDate = date('Y-m-01', time());
		$prevDate = date('Ym', strtotime($nowDate . ' -' . $range . ' month'));
		$nextDate = date('Ym', strtotime($nowDate . ' +' . $range . ' month'));
		$dispDate = $dispYear . sprintf('%02d', $dispMonth);

		$prevFlg = true;
		$nextFlg = true;
		// 前の月の表示判定
		if($dispDate <= $prevDate) {
			$prevFlg = false;
		}
		// 次の月の表示判定
		if($dispDate >= $nextDate) {
			$nextFlg = false;
		}
		$stringAry = array();
		$stringAry[] = '<div class="scCalendarLinks">';

		if($prevFlg) {
			if($lang == $calCONFIGS->LANG_EN){
				$stringAry[] = '<span class="scCalendarPrevLink"><a href="javascript:void(0)"><< Prev</a></span>';
			} else {
				$stringAry[] = '<span class="scCalendarPrevLink"><a href="javascript:void(0)"><<前の月</a></span>';
			}
		}
		if($nextFlg){
			if($lang == $calCONFIGS->LANG_EN){
				$stringAry[] = '<span class="scCalendarNextLink"><a href="javascript:void(0)">Next >></a></span>';
			} else {
				$stringAry[] = '<span class="scCalendarNextLink"><a href="javascript:void(0)">次の月>></a></span>';
			}
		}
		$stringAry[] = '</div>';
		return implode('', $stringAry);
	}

	/**
	 * 曜日を取得して返す
	 * $weekNum 取得する曜日の数値
	 * $lang 取得言語
	 * $start 開始曜日 日曜始まりか月曜始まり（1 or 2）
	 * return 曜日の名称
	 */
	private function getWeeks($weekNum = 0, $lang, $start) {
		$weeks = $this->setWAry($lang, $start);
		return $weeks[$weekNum];
	}

	/**
	 * 曜日の色クラスを付けて返す
	 * $n 番号
	 * $class クラス名
	 */
	private function setWeekColor($n=1, $class='') {
	    require(dirname(__FILE__) . '/../datas/setting.php');
	    $calCONFIGS = new scCalendarConfigs();

	    if(($SET_WEEKSTART == $calCONFIGS->WEEK_MON && $n == 5) || ($SET_WEEKSTART == $calCONFIGS->WEEK_SUN && $n == 6)) {
	        // 土曜日のときは背景色を青にする
	        $class .= ' scCalendarSat';
	    } else if(($SET_WEEKSTART == $calCONFIGS->WEEK_MON && $n == 6) || ($SET_WEEKSTART == $calCONFIGS->WEEK_SUN && $n == 0)) {
	        // 日曜日の時は背景色を赤にする
	        $class .= ' scCalendarSun';
	    }
	    return $class;
	}

	/**
	 * カレンダーを表示する
	 * $admin 管理画面フラグ 通常false
	 * return 生成したカレンダーのHTML
	 */
	public function getCalendar($admin = false) {
	    $calCONFIGS = new scCalendarConfigs();
	    require(dirname(__FILE__) . '/../datas/setting.php');

	    // 表示するカレンダーの年月
	    // GET値がなければ現在年月を取得
	    $dispYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
	    $dispMonth = isset($_GET['month']) ? $_GET['month'] : date('n');
	    // 存在する年月かチェック、存在しない場合は初期化
	    if(strlen($dispYear) != 4 || !preg_match("/^[0-9]+$/",$dispYear) || $dispYear < 1970 || $dispYear > 2037){
	        $dispYear = date('Y');
	    }
	    if($dispMonth < 1 || $dispMonth > 12 || !preg_match("/^[0-9]+$/",$dispMonth)){
	        $dispMonth = date('n');
	    }

	    // 表示月の前の月の情報を取得
	    if($dispMonth == 1) {
	        $prevMonth = 12;
	        $prevYear = $dispYear - 1;
	    } else {
	        $prevMonth = $dispMonth - 1;
	        $prevYear = $dispYear;
	    }
	    // 前の月の日数を取得
	    $prevDays = (int)date('d', strtotime('last day of ' . $prevYear . '-' . $prevMonth));


	    // データをCSVから取得する
	    $eveDatas = array();
	    $filename = dirname(__FILE__) . '/../datas/' . $dispYear . sprintf("%02d", $dispMonth) . '.csv';
	    if(file_exists($filename)) {
    	    $strings = file_get_contents($filename);
    	    if(!empty($strings)) {
	    	    $strAry = explode("\n", $strings);
	    	    foreach($strAry as $str) {
	    	        $eveDatas[str_replace('"', '', $str)] = str_replace('"', '', $str);
	    	    }
	    	}
	    }

	    // カレンダーを表示するための変数初期化
	    $calendarString = '';
	    $calendarStringAry = array();

	    // カレンダーコメントがある場合はコメントを表示
	    // HTML許可
	    if($SET_CALTITLE != '') {
	        $calendarStringAry[] = '<div class="scCalendarTitle">' . $SET_CALTITLE . '</div>';
	    }

	    $calendarStringAry[] = $this->getHeader($dispYear, $dispMonth, $SET_LANGUAGE, 4);

	    // 取得した月の日数を取得
	    $days = (int)date('d', strtotime('last day of ' . $dispYear . '-' . $dispMonth));
	    // 取得した月初めの曜日を取得
	    $startDayw = date('w', strtotime('first day of ' . $dispYear . '-' . $dispMonth));

	    // カレンダーの作成
	    $calendarStringAry[] = '<table class="scCalendarTable">';
	    $calendarStringAry[] = '<thead>';
	    $calendarStringAry[] = '<tr>';

	    // ヘッダの作成
	    // 月曜始まりだった場合
	    if($SET_WEEKSTART == $calCONFIGS->WEEK_MON) {
	        // 日曜日を一番後ろに回す
	        if($startDayw == 0) {
	            $startDayw = 6;
	        } else {
	            $startDayw = $startDayw - 1;
	        }
	    }
	    for($i=0; $i<7; $i++) {
	        $class = 'scCalendarHead';
	        $class = $this->setWeekColor($i, $class);
	        $calendarStringAry[] = '<th class="' . $class . '">' . $this->getWeeks($i, $SET_LANGUAGE, $SET_WEEKSTART) . '</th>';
	    }
	    $calendarStringAry[] = '</tr>';
	    $calendarStringAry[] = '</thead>';

	    // 日付以下の作成
	    $i = 1;
	    $weeksStr = $calCONFIGS->setWeekStr();
	    // 一週間分
	    while($i <= $days) {
	        $calendarStringAry[] = '<tr>';
	        for($n=0; $n<7; $n++) {
	            $class = 'scCalendarData';
	            // 登録データがあるか判定するフラグ
	            $scFlg = false;

	            // 曜日始まりの判定
	            if($SET_WEEKSTART == $calCONFIGS->WEEK_MON) {
	                if($n == 6){
    	                $weekNo = 0;
	                } else {
	                    $weekNo = $n+1;
	                }
	            } else {
	                $weekNo = $n;
	            }

	            // 一日のスタートより前の場合、前の月の日付を表示
	            if($i==1 && $startDayw != $n) {
	                $class .= ' scCalendarPrev';
	                // 3月カレンダー表示で、一週目日曜日の月表示で、木曜始まりの場合、$startDaywは4（木曜日）、曜日カウント$nは0
	                // 2月の最終日が28日の場合、日曜日は28-（4-(0+1)）=28-3=25日となる
	                $prevDay = $prevDays - ($startDayw - ($n + 1));
	                $class = $this->setWeekColor($n, $class);

	                $calendarStringAry[] = '<td class="'. $class .'">' . $prevDay . '</td>';
	                continue;
	            } else if($i > $days) {
	                // 最大日数を超えた場合
	                $nextDay = $i - $days;
	                $class .= ' scCalendarNext';
	                $class = $this->setWeekColor($n, $class);
	                $calendarStringAry[] = '<td class="'. $class .'">' . $nextDay . '</td>';
	                $i++;
	                continue;
	            } else {
	                // 登録されたデータがある日は色を変更する
	                if(isset($eveDatas[$i])) {
	                    $class .= ' scCalendarEvent';
	                    $scFlg = true;
	                } else {
    	                $class = $this->setWeekColor($n, $class);
	                }
	            }

	            $txt = '<span class="scDay">' . $i . '<span class="scWeekDisp">(' . $weeksStr[$weekNo][$SET_LANGUAGE] . ')</span></span>';
	            if($admin) {
	                $txt = '<a href="javascript:void(0)" class="scCalendarChangeData" id="scCalendarChangeData' .$i . '">' . $i . '<span class="scWeekDisp">(' . $weeksStr[$weekNo][$SET_LANGUAGE] . ')</span></a>';
	                $calendarStringAry[] = '<td class="'. $class .'">' . $txt . '</td>';
	            } else {
	                $calendarStringAry[] = '<td class="'. $class .'">' . $txt . '</td>';
	            }

	            $i++;
	        }
	        $calendarStringAry[] = '</tr>';
	    }
	    $calendarStringAry[] = '</table>';
	    $calendarStringAry[] = $this->setPager($SET_LANGUAGE, $SET_RANGE, $dispYear, $dispMonth);

	    // 次の月、前の月リンク動作用
	    $calendarStringAry[] = '<input type="hidden" name="scCalendarDispYear" id="scCalendarDispYear" value="'. $dispYear .'">';
	    $calendarStringAry[] = '<input type="hidden" name="scCalendarDispMonth" id="scCalendarDispMonth" value="'. $dispMonth .'">';

	    return implode("\n", $calendarStringAry);
	}

	/**
	 * 管理画面用
	 * 日付の登録データの更新
	 * years 年
	 * month 月
	 * day 日付
	 * dayFlg 1→登録 2→削除
	 */
	public function changeDayData($datas) {
	    // データ作成 1行で日付
	    $string = '"' . $datas['day'] . '"';

	    // 指定の年月のCSVファイル
	    $file = dirname(__FILE__) . '/../datas/' . $datas['year'].sprintf("%02d", $datas['month']) . '.csv';

	    // 既に存在するデータ
	    $data = '';
	    if(file_exists($file)) {
	        $data = file_get_contents($file);
	    } else {
	        // フォルダがない場合はフォルダを作成
	        if(!file_exists(dirname(__FILE__) . '/../datas/')) {
	            if(!mkdir((dirname(__FILE__) . '/../datas/'), 0757)) {
	                // エラーログ書き込み
	                $this->writeErr("ディレクトリの作成に失敗");
	                return false;
	            }
	        }
	    }

	    // 登録処理
	    $ary = array();
	    if($datas['dayFlg'] == 1) {
	        // 新規
	        if($data != '') {
	            $string = $data . "\n" . $string;
	        }
	    } else if($datas['dayFlg'] == 2) {
	        // 削除
	        $checkDatas = explode("\n", $data);
	        foreach($checkDatas as $checkData) {
	            // 該当の文字列が来たらその行は削除 → 登録データから外す
	            if(strpos($checkData, '"' . $datas['day'] . '"') !== false) continue;
	            $ary[] = $checkData;
	        }
	        $string = implode("\n", $ary);
	    } else {
	        // エラーログ書き込み
	        $this->writeErr("登録、削除値以外のdayFlg");
	        return false;
	    }

	    // 書き込み
	    if($string != '') {
    	    if(file_put_contents($file, $string) === false) {
    	        // エラーログ書き込み
    	        $this->writeErr("ファイル書き込み失敗：" . $file);
    	        return false;
    	    }
	    } else {
	        // 書き込む文字列がなかった場合、ファイルを削除する
	        if(file_exists($file)) {
	            if(unlink($file) === false) {
	                // エラーログ書き込み
	                $this->writeErr("ファイル削除失敗：" . $file);
	            }
	        }
	    }

	    return true;
	}

	/**
	 * 設定情報更新
	 * $datas POSTされてきたデータ
	 * return rue or false
	 */
	public function updateSetting($datas) {
	    $file = dirname(__FILE__) . '/../datas/setting.php';
	    if(empty($datas)) {
	        // 空の場合は強制終了、ファイル更新しない
	        // エラーログ書き込み
	        $this->writeErr("カレンダー設定ファイル書き込み失敗：" . $file);
	        return false;
	    }

	    require_once(dirname(__FILE__) . '/../library/configs.php');
        $calCONFIGS = new scCalendarConfigs();

	    // 値の確認と書き込みデータの作成
	    $strAry = array();
	    $strAry[] = '<?php';
	    $strAry[] = '// カレンダー設定ファイル';
	    foreach($datas as $key=>$data) {
	        if($key == 'sctitle') {
	            // カレンダータイトル
	            $data = strip_tags($data);
	            $data = mb_substr($data, 0, $calCONFIGS->CALENDAR_TITLE_NUM);
	            $data = str_replace('"', '&quot;', $data);
	            $data = str_replace("'", '&#039;', $data);
	            $strAry[] = "\$SET_CALTITLE = '" . $data . "'; // カレンダータイトル";

	        } else if($key == 'range') {
	            //表示範囲
	            // エラーの場合は初期値（3）を設定
	            if(!preg_match('/^[0-9]+$/', $data)) {
	                $data = 3;
	            }
	            // 表示範囲は最大2年分までしか許容しない
	            if($data < 1 || $data > 24) {
	                $data = 3;
	            }
	            $strAry[] = "\$SET_RANGE = ". $data . "; // 表示範囲";
	        } else if($key == 'lang') {
	            // 曜日の言語
	            // 日本語か英語以外の値が来た場合は日本語に初期化
	            if($data != $calCONFIGS->LANG_JA && $data != $calCONFIGS->LANG_EN) {
	                $data = $calCONFIGS->LANG_JA;
	            }
	            $strAry[] = "\$SET_LANGUAGE = ". $data . "; // 曜日の表示言語";
	        } else if($key == 'start') {
	            // 週始まり
	            // 日曜始まりか月曜始まり以外が来た場合は月曜始まりに初期化
	            if($data != $calCONFIGS->WEEK_SUN && $data != $calCONFIGS->WEEK_MON) {
	                $data = $calCONFIGS->WEEK_MON;
	            }
	            $strAry[] = "\$SET_WEEKSTART = " . $data . "; // 週始まり";
	        } else {
	            // 他の値が来たら強制終了、ファイル更新しない
	            // エラーログ書き込み
	            $this->writeErr("カレンダー設定ファイル書き込み失敗：" . $file);
	            return false;
	        }
	    }
	    $strAry[] = '?>';

	    $string = implode("\n", $strAry);

	    if(file_put_contents($file, $string) === false) {
	        // エラーログ書き込み
	        $this->writeErr("カレンダー設定ファイル書き込み失敗：" . $file);
	        return false;
	    }
	    return true;
	}

	/**
	 * エラーログ書き込み用関数
	 * $string エラー内容
	 */
	private function writeErr($str) {
	    $file = dirname(__FILE__) . '/../log/error.log';
	    $string = '"' . date('Y/m/d H:i:s', time()) . '","' . $str . '"';

	    if(file_exists($file)) {
	        $data = file_get_contents($file);
	        $string = $data . "\n" . $string;
	    } else {
	        // フォルダがない場合はフォルダを作成
	        if(!file_exists(dirname(__FILE__) . '/../log/')) {
	            // ここでもディレクトリが作成できなかった場合は終了
	            if(!mkdir((dirname(__FILE__) . '/../log/'), 0757)) return false;
	        }
	    }
	    // 書き込み
	    if(file_put_contents($file, $string) === false) return false;

	    return true;
	}

	/**
	 * ログインチェック
	 */
	public function loginCheck($id='', $pass='') {
	    // ログインチェック
	    if(!isset($_SESSION)){
    	    session_start();
	    }

	    // クッキーを持っている場合、既にログインしているかチェック
	    if (isset($_COOKIE['choco'])) {
    	    if(!isset($_SESSION['hash'])) return false;
    	    if (password_verify($_COOKIE['choco'], $_SESSION['hash'])) {
    	        return true;
    	    } else {
    	        return false;
    	    }
	    }

	    $filename = dirname(__FILE__) . '/../admin/data/login.csv';
	    // ファイルがない場合は何もしない
	    if(!file_exists($filename)) return false;

	    $loginData = file_get_contents($filename);
        $loginAry = explode("\r\n", $loginData);

        $loginDatas = array();
        foreach($loginAry as $ary) {
            $strs = explode(',', $ary);
            $loginDatas[str_replace('"', '', $strs[0])] = str_replace('"', '', $strs[1]);
        }

        // 一致しない場合はエラー
        if($id != $loginDatas['ID'] || $pass != $loginDatas['PASS']) {
            return false;
        }

        // ログインした情報の保存
        $loginDate = time();
        $loginStr = $loginDatas['PASS'] . $loginDate;
        // クッキー保存するハッシュ
        $choco = password_hash($loginStr, PASSWORD_DEFAULT);
        // セッション保存するハッシュ（正解）
        $hash = password_hash($choco, PASSWORD_DEFAULT);
        // ログインは1時間有効
        setcookie('choco', $choco ,time()+60*60);
        $_SESSION['hash'] = $hash;

        return true;
	}

	/**
	 * ログアウト
	 */
	public function logout() {
	    session_start();
	    $_SESSION = array();
	    session_destroy();
	    setcookie('choco', '', time() - 1800);

	    return true;
	}

}
?>
