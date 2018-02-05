$(function() {

	if ($.pjax) {
		
		$.pjax.defaults.timeout = 5000;
		
		$(document).on('pjax:timeout', function(e) {
			e.preventDefault();
		});
		
		$(document).on('pjax:send', function(e) {
			var pjaxID = e.target.id;
			$('#loader_' + pjaxID).show();
		});
		$(document).on('pjax:complete', function(e) {
			var pjaxID = e.target.id;
			$('#loader_' + pjaxID).hide();
		});
		
	}
	
	$(document).pjax('a', '#tasksPjax', { push: false });
	
	$.pjax({
		url: SITE_URL + 'Main/listTasks', 
		container: '#tasksPjax',
		push: false
	});
	
	$('#addTaskBtn').on('click', function() {
		$.ajax({
			url: SITE_URL + 'Main/addTask',
            type: 'GET',
            success: function(response) {
				showModal('#addTaskModal', response);
            }
        });
	});
	
	var addTaskValidate = null;
	$('#addTaskModal').on('shown.bs.modal', function () {
		$('#task-username').trigger('focus');
		
		addTaskValidate = $('#addTaskForm').validate({
			rules: {
				'Task[username]': 'required',
				'Task[email]': {
					required: true,
					email: true
				},
				'Task[text]': 'required'
			},
			highlight: function (element, errorClass, validClass) {
				$(element).addClass('is-invalid').removeClass('is-valid');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).addClass('is-valid').removeClass('is-invalid');
			}
		});
	});
	
	$('#addTaskSub').on('click', function() {
		$('#addTaskForm').submit();
	});
	
	$('#addTaskPreviewBtn').on('click', function() {
		if (addTaskValidate.form()) {
			var subButton = $('#addTaskPreviewBtn');
			buttonLoading(subButton);
			
			$.ajax({
				url: $('#addTaskForm').attr('action') + 'Preview',
				type: 'POST',
				data: new FormData($('#addTaskForm')[0]),
				cache: false,
				contentType: false,
				processData: false,
				success: function(response) {
					$('.task-preview').html(response);
					$('.task-preview').css('visibility', 'visible');
					buttonActive(subButton);
				}
			});
		}
	});
	
	$('#addTaskModal').on('click', '.preview-task-return-btn', function() {
		$('.task-preview').css('visibility', 'hidden');
		$('.task-preview').html('');
	});
	
	$('#addTaskModal').off('submit', '#addTaskForm');
	$('#addTaskModal').on('submit', '#addTaskForm', function(e) {
		e.preventDefault();
		
		var subButton = $('#addTaskSub');
		buttonLoading(subButton);
		
		$.ajax({
			url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
			cache: false,
			contentType: false,
			processData: false,
            success: function(response) {
                var result = $(response).filter('#result').text();
				if (result == 'success') {

					$('#addTaskModal').modal('hide');
					$.pjax.reload('#tasksPjax', {});
				
				} else {
					
					$('#addTaskModal').find('.modal-body').html(response);
					
					buttonActive(subButton);
				
				}
            }
        });
	});
	
	$('.tasks-list').on('click', '.update-task-btn', function() {
		$.ajax({
			url: SITE_URL + 'Main/updateTask?id=' + $(this).attr('data-taskid'),
            type: 'GET',
            success: function(response) {
				showModal('#updateTaskModal', response);
            }
        });
	});
	$('#updateTaskModal').on('shown.bs.modal', function () {
		$('#task-text').trigger('focus');
		
		$('#updateTaskForm').validate({
			rules: {
				'Task[text]': 'required'
			},
			highlight: function (element, errorClass, validClass) {
				$(element).addClass('is-invalid').removeClass('is-valid');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).addClass('is-valid').removeClass('is-invalid');
			}
		});
	});
	
	$('#updateTaskSub').on('click', function() {
		$('#updateTaskForm').submit();
	});
	
	$('#updateTaskModal').off('submit', '#updateTaskForm');
	$('#updateTaskModal').on('submit', '#updateTaskForm', function(e) {
		e.preventDefault();
		
		var subButton = $('#updateTaskSub');
		buttonLoading(subButton);
		
		$.ajax({
			url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                var result = $(response).filter('#result').text();
				if (result == 'success') {

					$('#updateTaskModal').modal('hide');
					$.pjax.reload('#tasksPjax', {});
				
				} else {
					
					$('#updateTaskModal').find('.modal-body').html(response);
					
					buttonActive(subButton);
				
				}
            }
        });
	});

});

function showModal(selector, content) {
	$(selector).find('.modal-body').html(content);	
    $(selector).modal('show');
}

function buttonLoading(btn) {
	btn.addClass('disabled');
	btn.prop('disabled', true);
}
	
function buttonActive(btn) {
	btn.removeClass('disabled');
	btn.prop('disabled', false);
}