$(document).ready(function() {
	var DocHeight = $("body").height() + 700;

	parent.postMessage(JSON.stringify({
		subject: 'lti.frameResize',
		height: DocHeight + "px"
	}), '*');

	function showMessage(content) {

		$("#message").html(content);
		$("#message").stop().fadeIn(400).fadeOut(2500);
	}

	$('#form_one2many').submit(function (event) {
		//alert(111);
		if(event.handled !== true) {
			var selectedCourses = $(".target_courses:checked");
			if ((selectedCourses.length > 0)) {
				if ($("#reset_course").is(":checked")) {
					if(confirm("Are you sure, you want to reset the content before copying?") === false) {
						return false;
					}
				}
				showMessage('Submitting....');

				$.ajax({
				type: 'POST',
				url: location.href,
				data: {
					action: 'copy',
					source_course_sis_id: source_course_sis_id,
					user_sis_id: user_sis_id,
					target_courses: selectedCourses.serialize(),
					reset_course: $("#reset_course").is(":checked")
				},
				dataType: 'json'

				}).done(function (data) {
					if (data.err.length > 0) {
						$('#message').html(data.err.join("<br />"));
					}
					else {
						$('#message').html("We will notify you through email once the course(s) get copied");
					}
				}).fail(function (xhr, desc, err) {

					alert("Details: " + desc + "Error:" + err);
				});

			} else {
				alert('Please select atleast a course');
			}
			// Mark event as handled to prevent multiple submissions of the event
			event.handled = true;
		}
		return false;
	});
});
