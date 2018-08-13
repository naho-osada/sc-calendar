$(function(){
	scCalendarSetClickEvent();
});

/**
 * 表示月の変更
 * @param dispYear 年
 * @param dispMonth 月
 * @returns カレンダー
 */
function scCalendarChangeCal(dispYear, dispMonth) {
	setTimeout(function(){
		$.get({
			url: './ajax.php',
			data: { year: dispYear, month: dispMonth },
		})
		.fail(function () {
		    // エラー処理
			alert("データの更新に失敗しました。");
		}).done(function (data) {
		    // 成功処理
			$('#scCalendarMainArea').html('');
			$('#scCalendarMainArea').html(data);
			scCalendarSetClickEvent();
		});
	},200);
}

/**
 * 登録日の変更
 * @param dispYear 年
 * @param dispMonth 月
 * @param day 日
 * @param dayFlg 削除フラグ
 * @returns 成功時はカレンダーの更新、失敗時はfalseアラート
 */
function scCalendarChangeData(dispYear, dispMonth, day, dayFlg) {
	$.post({
		url: './change-day.php',
		dataType: 'text',
		data: { year: dispYear, month: dispMonth, day: day, dayFlg: dayFlg },
	})
	.fail(function () {
	    // エラー処理
		alert("データの更新に失敗しました。");
	}).done(function (data) {
	    // 成功処理
		scCalendarChangeCal(dispYear, dispMonth);
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

	$('.scCalendarChangeData').on('click',function(){
		var dayFlg = 1;
		var dayId = $(this).attr('id');
		var day = dayId.replace('scCalendarChangeData', '');
		dispYear = $('#scCalendarDispYear').val();
		dispMonth = $('#scCalendarDispMonth').val();

		if($(this).parent().is('.scCalendarEvent')) {
			dayFlg = 2;
		}
		scCalendarChangeData(dispYear, dispMonth, day, dayFlg);
	});
}
