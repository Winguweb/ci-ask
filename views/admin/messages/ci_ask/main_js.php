<?php require SYSPATH.'../application/views/admin/utils_js.php' ?>

// Form Submission
function askAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('<?php echo Kohana::lang('ci_ask.messages.are_you_sure_you_want_to_mark_reports'); ?> ' + confirmAction + '?')
	if (answer) {
		if (id != "") {
			$(document.getElementById("checkallmessages")).attr("checked", false);
			CheckAll( 'checkallmessages', 'message_id[]' );
		}

		// Set Message ID
		$(document.getElementById("message_single")).val(id);
		// Set Submit Type
		$(document.getElementById("action")).val(action);
		// Submit Form
		$(document.getElementById("askAction")).submit();
	}
}
