/**
 * SC Calendar
 * MITライセンスを使用しています。
 * 詳しくはREADME.txtを参照してください。
 *
 * 作成者：Naho Osada（おさだなほ）
 * https://wm-web-se-pg.com/
 */

$(function(){
	if(!$('#scCalendarMainArea').length) {
		return false;
	}

	scCalendarSetClickEvent();
	scCalendarChangeCal();
});

/**
 * カレンダーの表示月変更
 * dispYear:年
 * dispMonth:月
 * @returns カレンダーHTML
 */
function scCalendarChangeCal(dispYear, dispMonth) {
	$.get({
		url: './ajax.php',
		data: { year: dispYear, month: dispMonth },
	})
	.fail(function () {
	    // エラー処理
		alert("カレンダーの取得に失敗しました。");
	}).done(function (data) {
	    // 成功処理
		$('#scCalendarMainArea').html('');
		$('#scCalendarMainArea').html(data);
		scCalendarSetClickEvent();
	});
}

function scCalendarSetClickEvent() {
	var dispYear;
	var dispMonth;

	$('.scCalendarNextLink').on('click',function(){
		dispYear = $('#scCalendarDispYear').val();
		dispMonth = $('#scCalendarDispMonth').val();
		if(dispMonth == 12) {
			dispMonth = 1;
			++dispYear;
		} else {
			++dispMonth;
		}
		scCalendarChangeCal(dispYear, dispMonth);
	});

	$('.scCalendarPrevLink').on('click',function(){
		dispYear = $('#scCalendarDispYear').val();
		dispMonth = $('#scCalendarDispMonth').val();
		if(dispMonth == 1) {
			dispMonth = 12;
			--dispYear;
		} else {
			--dispMonth;
		}
		scCalendarChangeCal(dispYear, dispMonth);
	});
}