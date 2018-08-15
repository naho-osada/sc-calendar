/**
 * SC Calendar
 * MITライセンスを使用しています。
 * 詳しくはREADME.txtを参照してください。
 *
 * 作成者：Naho Osada（おさだなほ）
 * https://wm-web-se-pg.com/
 */

jQuery(function($){
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
	jQuery.get({
		url: './ajax.php',
		data: { year: dispYear, month: dispMonth },
	})
	.fail(function () {
	    // エラー処理
		alert("カレンダーの取得に失敗しました。");
	}).done(function (data) {
	    // 成功処理
		jQuery('#scCalendarMainArea').html('');
		jQuery('#scCalendarMainArea').html(data);
		scCalendarSetClickEvent();
	});
}

function scCalendarSetClickEvent() {
	var dispYear;
	var dispMonth;

	jQuery('.scCalendarNextLink').on('click',function(){
		dispYear = jQuery('#scCalendarDispYear').val();
		dispMonth = jQuery('#scCalendarDispMonth').val();
		if(dispMonth == 12) {
			dispMonth = 1;
			++dispYear;
		} else {
			++dispMonth;
		}
		scCalendarChangeCal(dispYear, dispMonth);
	});

	jQuery('.scCalendarPrevLink').on('click',function(){
		dispYear = jQuery('#scCalendarDispYear').val();
		dispMonth = jQuery('#scCalendarDispMonth').val();
		if(dispMonth == 1) {
			dispMonth = 12;
			--dispYear;
		} else {
			--dispMonth;
		}
		scCalendarChangeCal(dispYear, dispMonth);
	});
}