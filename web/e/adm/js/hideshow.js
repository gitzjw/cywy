//  Andy Langton's show/hide/mini-accordion @ http://andylangton.co.uk/jquery-show-hide

// this tells jquery to run the function below once the DOM is ready
$(document).ready(
		function() {

			// choose text for the show/hide link - can contain HTML (e.g. an
			// image)
			var showText = 'Show';
			var hideText = 'Hide';

			// initialise the visibility check
			var is_visible = false;

			// append show/hide links to the element directly preceding the
			// element with a class of "toggle"
			$('.toggle').prev().append(
					' <a href="#" class="toggleLink">' + hideText + '</a>');

			// hide all of the elements with a class of 'toggle'
			$('.toggle').show();

			// capture clicks on the toggle links
			$('a.toggleLink').click(function() {

				// switch visibility
				is_visible = !is_visible;

				// change the link text depending on whether the element is
				// shown or hidden
				if ($(this).text() == showText) {
					$(this).text(hideText);
					$(this).parent().next('.toggle').slideDown('slow');
				} else {
					$(this).text(showText);
					$(this).parent().next('.toggle').slideUp('slow');
				}

				// return false so any link destination is not followed
				return false;

			});
		});

function del(a, r, id) {
	if (confirm('删除操作不可以恢复，是否确定？')) {
		$.ajax({
			url : 'run.php',
			type : 'post',
			data : 'id=' + id + '&action=' + a + '&run=' + r,
			success : function(data) {
				if (data == '1') {
					alert('删除成功');
					window.location.reload();
				} else {
					alert('删除失败');
				}
			}

		})
	} else {
		return false;
	}
}

function msg(a, r, id) {
	var _msg_type = $('#msg_tel').val();
	if (confirm('向用户发送短信，是否确定？')) {
		$.ajax({
			url : 'run.php',
			type : 'post',
			data : 'id=' + id + '&action=' + a + '&run=' + r + '&msgtype='
					+ _msg_type,
			success : function(data) {
				if (data == '1') {
					alert('发送成功');
				} else {
					alert('发送失败');
				}
			}
		})
	} else {
		return false;
	}
}

function userDetail(uid) {
	$.ajax({
		url : 'run.php',
		type : 'post',
		data : 'uid=' + uid + '&action=InsMember&run=getInsMemberUserIdHtml',
		success : function(data) {
			$('#udt').html(data);
		}
	})
}

function getDays() {
	var date = new Date();
	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	if (m == 2) {
		return y % 4 == 0 ? 29 : 28;
	} else if (m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10
			|| m == 12) {
		return 31;
	} else {
		return 30;
	}
}

function orderDetail(oid){
	$.ajax({
		url : 'run.php',
		type : 'post',
		data : 'oid=' + oid + '&action=RepairOrder&run=getRepairOrderHtml',
		success : function(data) {
			$('#odt').html(data);
		}
	})
}
